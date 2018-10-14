<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevOrder;

use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevOrder
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Ajouter un message flash
     * @param string $_type
     * @param string $_message
     * @return mixed
     */
    public function setFlash($_type, $_message) {
        return $this->_container->get('session')->getFlashBag()->add($_type, $_message);
    }

    /**
     * Récuperer un récapitulatif commande avec prix
     * @param array $_data
     * @return array
     */
    public function getResumeOrder($_data)
    {
        // Récupérer manager
        $_service_manager        = $this->_container->get(ServiceName::SRV_METIER_SERVICE);
        $_service_option_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        $_data_order = [];
        $_prix_total = 0.0;

        // Récupérer le service avec prix
        $_service            = $_service_manager->getLvServiceById($_data['id_service']);
        $_prix_service       = $_service->getSrvPrix();
        $_nbr_page_integrer  = $_data['nbr_page_integrer'];
        $_nbr_page_decline   = $_data['nbr_page_decline'];
        $_prix_total_service = $_prix_service * $_nbr_page_integrer;
        $_is_decline         = false;
        if ($_nbr_page_decline > 0 && (($_nbr_page_integrer - 1) >= $_nbr_page_decline)) {
            $_total_nbr_page     = $_nbr_page_integrer - $_nbr_page_decline;
            $_prix_page_decline  = $_prix_service * $_total_nbr_page;
            $_taux_reduction     = $_service->getSrvReduction();
            $_prix_taux_service  = ($_taux_reduction * $_prix_service) / 100;
            $_prix_taux          = $_prix_service - $_prix_taux_service;
            $_prix_total_service = $_prix_page_decline + ($_prix_taux * $_nbr_page_decline);
            $_is_decline         = true;
        }
        $_resume_service[0]['quantite']    = $_is_decline ? $_total_nbr_page : $_nbr_page_integrer;
        $_resume_service[0]['description'] = $_service->getSrvLabel();
        $_resume_service[0]['prix']        = $_prix_service;
        $_resume_service[0]['prix_total']  = $_is_decline ? $_prix_service * $_total_nbr_page : $_prix_total_service;
        if ($_is_decline) {
            $_resume_service[1]['quantite']    = $_nbr_page_decline;
            $_resume_service[1]['description'] = $_service->getSrvLabel() . ' déclinées';
            $_resume_service[1]['prix']        = $_prix_taux_service;
            $_resume_service[1]['prix_total']  = $_prix_taux_service * $_nbr_page_decline;
        }
        $_data_order  = array_merge($_data_order, $_resume_service);
        $_prix_total += $_prix_total_service;

        // Récupérer les options service avec prix
        $_prix = 0.0;
        if (count($_data['service_option']) > 0) {
            $_services_option = $_service_option_manager->getLvServiceOptionByArrayId($_data['service_option']);
            foreach ($_services_option as $_key => $_service_option) {
                $_key++;

                // Calcul prix
                $_service_option_valeur = $_service_option->getLvServiceOptionValeurType();
                $_valeur                = empty($_service_option->getSrvOptValeur()) ? 0 : $_service_option->getSrvOptValeur();
                if ($_service_option_valeur->getSrvOptValTpVal() == ValeurTypeName::ID_POURCENTAGE) {
                    $_prix_taux = ($_valeur * $_prix_service) / 100;
                    $_prix      = $_prix_taux;
                }
                if ($_service_option_valeur->getSrvOptValTpVal() == ValeurTypeName::ID_EURO) {
                    $_prix = $_valeur;
                }
                $_prix_total += $_prix;

                $_resume_service_option[$_key]['quantite']    = 1;
                $_resume_service_option[$_key]['description'] = $_service_option->getSrvOptLabel();
                $_resume_service_option[$_key]['prix']        = $_prix;
                $_resume_service_option[$_key]['prix_total']  = $_prix;
            }
            $_data_order = array_merge($_data_order, $_resume_service_option);
        }

        $_resume_order['commande'] = $_data_order;
        $_resume_order['prix']     = $_prix_total;

        return $_resume_order;
    }

    /**
     * Enregistrement commande
     * @param array $_data
     * @return array
     */
    public function saveOrder($_data)
    {
        // Récupérer manager
        $_client_manager                = $this->_container->get(ServiceName::SRV_METIER_CLIENT);
        $_service_client_manager        = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT);
        $_service_client_jointe_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Enregistrement client
        $_client = $_client_manager->saveLvClientInOrder($_data);

        // Enregistrement commande du client
        $_service_client = $_service_client_manager->saveServiceClient($_client, $_data);

        // Enregistrement pièce jointe du client
        $_lien_projet     = $_data['lien_projet'];
        $_fichier_projets = $_data['fichier_projet'];
        if ($_lien_projet != '' || count($_fichier_projets) > 0) {
            foreach ($_fichier_projets as $_fichier_projet)
                $_service_client_jointe_manager->saveServiceClientJointe($_service_client, $_fichier_projet);
        }

        return $_service_client;
    }

    /**
     * Envoie email confirmation
     * @param array $_data
     * @return boolean
     */
    public function sendEmailConfirmation($_data)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $this->_container->getParameter('to_email_address');

        $_template   = 'FrontBundle:DevOrder:email_confirmation.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'data' => $_data
        ));

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Contact'))
            ->setFrom(array('gniaina@gmail.com' => 'Niaina'))
            ->setTo($_recipient)
            ->setBody($_email_body);

        $_message->setContentType("text/html");
        $_result = $this->_container->get('mailer')->send($_message);

        $_headers = $_message->getHeaders();
        $_headers->addIdHeader('Message-ID', uniqid() . "@domain.com");
        $_headers->addTextHeader('MIME-Version', '1.0');
        $_headers->addTextHeader('X-Mailer', 'PHP v' . phpversion());
        $_headers->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

        if ($_result) {
            return true;
        }

        return false;
    }
}