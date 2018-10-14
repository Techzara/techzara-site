<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevServiceClient;

use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use App\Techzara\Service\MetierManagerBundle\Utils\EtatServiceValidation;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ServiceMetierDevServiceClient
{
    private $_entity_manager;
    private $_container;
    private $_translator;

    public function __construct(EntityManager $_entity_manager, Container $_container, TranslatorInterface $_translator)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
        $this->_translator     = $_translator;
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
     * Récuperer le repository service_client
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SERVICE_CLIENT);
    }

    /*
     * Début - Pagination en mode chargement
     */
    /**
     * Filtre
     * @param Request $_request
     * @return array
     */
    public function getFilters($_request)
    {
        $_filters = array();
        $_start   = $_request->query->get('iDisplayStart');
        $_length  = $_request->query->get('iDisplayLength');

        if (isset($_start)) {
            $_filters['start'] = (int) $_start;
        }
        if (isset($_length)) {
            $_filters['length'] = (int) $_length;
        }

        return $_filters;
    }

    /**
     * Triage
     * @param Request $_request
     * @param array $_columns
     * @return array
     */
    public function getSortings($_request, $_columns)
    {
        $_sortings = array();

        foreach ($_columns as $_k => $_v) {
            $_is_sort_col = $_request->query->get('iSortCol_' . $_k);
            if (isset($_is_sort_col) && $_columns[$_is_sort_col]) {
                $_order_column = $_columns[$_is_sort_col];
                $_sort_dir = $_request->query->get('sSortDir_' . $_k);
                if (isset($_sort_dir) && $_sort_dir == 'asc') {
                    $_order_direction = 'ASC';
                } else {
                    $_order_direction = 'DESC';
                }

                $_sortings[$_order_column] = $_order_direction;
            }
        }

        return $_sortings;
    }

    /**
     * Récupérer le nombre total d'enregistrement
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNbDevServiceClientQueryBuilder($_options = null)
    {
        $qb = $this->findByQueryBuilder($_options);

        return $qb->select('COUNT(DISTINCT sc.id) AS nb');

    }

    /**
     * Limite sql
     * @param object $_qb
     * @param array $_limit
     * @return mixed
     */
    public function addLimit($_qb, $_limit = array())
    {
        if (isset($_limit['start'])) {
            $_qb->setFirstResult($_limit['start']);
        }
        if (isset($_limit['length'])) {
            $_qb->setMaxResults($_limit['length']);
        }

        return $_qb;
    }

    /**
     * Triage des données
     * @param object $_qb
     * @param array $_sortings
     * @return mixed
     */
    public function addSortings($_qb, $_sortings = array())
    {
        if (isset($_sortings['isOrderRand'])) {
            $_qb
                ->addSelect('RAND() as HIDDEN rand')
                ->orderBy('rand');
        } else {
            if (count($_sortings) == 0) {
                $_qb->groupBy('sc.id');
                $_qb->orderBy('sc.id', 'DESC');
            } else {
                foreach ($_sortings as $_sorting_column => $_sorting_direction) {
                    $_qb->groupBy('sc.id');
                    $_qb->addOrderBy($_sorting_column, $_sorting_direction);
                }
            }
        }

        return $_qb;
    }

    /**
     * Ajout filtre
     * @param null $_query
     * @param array $_filters
     * @return null
     */
    public function addFilters($_query = null, $_filters = array())
    {
        return $_query;
    }

    /**
     * Récupérer tout les services clients
     * @param array $_options
     * @param array $_filters
     * @param array $_sortings
     * @return mixed
     */
    public function getAllDevServiceClientBy($_options, $_filters=array(), $_sortings=array())
    {
        $_query = $this->findByQueryBuilder($_options);
        $_query = $this->addFilters($_query, $_filters);
        $_query = $this->addSortings($_query, $_sortings);

        if ($_filters != null) {
            $_query = $this->addLimit($_query, $_filters);
        }

        return $_query->getQuery()->getResult();
    }

    /**
     * Récupérer le nombre d'enregistrement service client
     * @param array $_options
     * @param array $_filters
     * @return mixed
     */
    public function getNbDevServiceClientBy($_options=array(), $_filters = array())
    {
        $_query = $this->getNbDevServiceClientQueryBuilder($_options);

        return $_query->getQuery()->getSingleResult();
    }

    /**
     * Filtre de recherche
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder($_options = null)
    {
        $_entity = EntityName::LV_SERVICE_CLIENT;
        $_qb     = $this->_entity_manager
            ->createQueryBuilder('sc')
            ->select('sc')
            ->from($_entity, 'sc')
            ->leftJoin('sc.lvUser', 'usr')
            ->leftJoin('sc.lvService', 'srv');

        if (isset($_options['type'])) {
            if ($_options['type'] == 'validated') {
                $_qb->andWhere('sc.srvCltStatusValidation IN (:array)');
                $_qb->setParameter('array', array(
                    EtatServiceValidation::ID_DEVELOPPEMENT,
                    EtatServiceValidation::ID_LIEN_LIVRE,
                    EtatServiceValidation::ID_TEST,
                    EtatServiceValidation::ID_FINALISE,
                ));
            } elseif ($_options['type'] == 'not-validated') {
                $_qb->andWhere('sc.srvCltStatusValidation IN (:array)');
                $_qb->setParameter('array', array(
                    EtatServiceValidation::ID_BON_COMMANDE,
                    EtatServiceValidation::ID_ANALYSE,
                    EtatServiceValidation::ID_FICHIER_NON_CONFORME,
                    EtatServiceValidation::ID_AJUSTEMENT_PANIER_COMMANDE,
                    EtatServiceValidation::ID_DEVELOPPEMENT,
                    EtatServiceValidation::ID_LIEN_LIVRE,
                    EtatServiceValidation::ID_TEST,
                    EtatServiceValidation::ID_FINALISE,
                ));
            } else {
                // Récupérer l'utilisateur connecté
                $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
                $_id_user        = $_user_connected->getId();

                $_qb->andWhere('usr.id = :id_user');
                $_qb->setParameter('id_user', $_id_user);
            }
        }

        // Filtre recherche
        if (isset($_options['search'])) {
            $_qb->andWhere('usr.usrNomEntreprise LIKE :entreprise OR srv.srvLabel LIKE :service')
                ->setParameter('entreprise', '%'.$_options['search'].'%')
                ->setParameter('service', '%'.$_options['search'].'%');
        }

        return $_qb;
    }
    /*
     * Fin - Pagination en mode chargement
     */

    /**
     * Récuperer tout les service_clients
     * @return array
     */
    public function getAllDevServiceClient()
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();

        $_array_type = array(
            'lvUser' => $_id_user
        );

        return $this->getRepository()->findBy($_array_type, array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les service_clients à valider
     * @return array
     */
    public function getAllDevServiceClientNotValidated()
    {
        return $this->getRepository()->findBy(
            array('srvCltStatusValidation' => array(
                EtatServiceValidation::ID_ANALYSE,
                EtatServiceValidation::ID_FICHIER_NON_CONFORME,
            )),
            array('id' => 'DESC')
        );
    }

    /**
     * Récuperer tout les service_clients validé
     * @return array
     */
    public function getAllDevServiceClientValidated()
    {
        return $this->getRepository()->findBy(
            array('srvCltStatusValidation' => EtatServiceValidation::ID_BON_COMMANDE),
            array('id' => 'DESC')
        );
    }

    /**
     * Récuperer un service_client par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevServiceClientById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Ajout service_client
     * @param DevServiceClient $_service_client
     * @param array $_piece_jointes
     * @return boolean
     */
    public function addDevServiceClient($_service_client, $_piece_jointes)
    {
        // Récupérer manager
        $_service_client_jointe_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Enregistrement pièce jointe du client
        if (count($_piece_jointes) > 0) {
            foreach ($_piece_jointes as $_piece_jointe)
                $_service_client_jointe_manager->saveServiceClientJointe($_service_client, $_piece_jointe);
        }

        return $this->saveDevServiceClient($_service_client, 'new');
    }

    /**
     * Modification service_client
     * @param DevServiceClient $_service_client
     * @param array $_piece_jointes
     * @return boolean
     */
    public function updateDevServiceClient($_service_client, $_piece_jointes)
    {
        // Récupérer manager
        $_service_client_jointe_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Enregistrement pièce jointe du client
        if (count($_piece_jointes) > 0) {
            foreach ($_piece_jointes as $_piece_jointe)
                $_service_client_jointe_manager->saveServiceClientJointe($_service_client, $_piece_jointe);
        }

        return $this->saveDevServiceClient($_service_client, 'new');
    }

    /**
     * Enregistrer un service_client
     * @param DevServiceClient $_service_client
     * @param string $_action
     * @return boolean
     */
    public function saveDevServiceClient($_service_client, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service_client);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un service_client
     * @param DevServiceClient $_service_client
     * @return boolean
     */
    public function deleteDevServiceClient($_service_client)
    {
        // Récupérer manager
        $_service_client_jointe_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        $_id_service_client      = $_service_client->getId();
        $_service_client_jointes = $_service_client_jointe_manager->getDevServiceClientJointeByServiceClient($_id_service_client);
        foreach ($_service_client_jointes as $_service_client_jointe)
            $_service_client_jointe_manager->deleteOnlyJointe($_service_client_jointe);

        $this->_entity_manager->remove($_service_client);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un service_client
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevServiceClient($_ids)
    {
        // Récupérer manager
        $_service_client_jointe_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_service_client = $this->getDevServiceClientById($_id);

                $_id_service_client      = $_service_client->getId();
                $_service_client_jointes = $_service_client_jointe_manager->getDevServiceClientJointeByServiceClient($_id_service_client);
                foreach ($_service_client_jointes as $_service_client_jointe)
                    $_service_client_jointe_manager->deleteOnlyJointe($_service_client_jointe);

                $this->deleteDevServiceClient($_service_client);
            }
        }

        return true;
    }

    /**
     * Enregistrement service client commandé
     * @param User $_client
     * @param array $_data
     * @return array
     */
    public function saveServiceClient($_client, $_data)
    {
        // Récupérer manager
        $_service_manager        = $this->_container->get(ServiceName::SRV_METIER_SERVICE);
        $_service_option_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_OPTION);
        $_order_manager          = $this->_container->get(ServiceName::SRV_METIER_ORDER);

        $_lien_projet                = $_data['lien_projet'];
        $_id_service                 = $_data['id_service'];
        $_ids_service_option         = $_data['service_option'];
        $_information_complementaire = $_data['information_complementaire'];
        $_nbr_page_integrer          = $_data['nbr_page_integrer'];
        $_nbr_page_decline           = $_data['nbr_page_decline'];
        $_service                    = $_service_manager->getDevServiceById($_id_service);

        $_service_client = new DevServiceClient();
        $_service_client->setSrvCltProjectLink($_lien_projet);
        $_service_client->setSrvCltDesc($_information_complementaire);
        $_service_client->setSrvCltNbrPage($_nbr_page_integrer);
        $_service_client->setSrvCltNbrPageDecline($_nbr_page_decline);
        $_service_client->setDevUser($_client);
        $_service_client->setDevService($_service);

        // Enregistrement prix
        $_resume_order = $_order_manager->getResumeOrder($_data);
        $_prix_order   = $_resume_order['prix'];
        $_service_client->setSrvCltPrix($_prix_order);

        // Enregistrement option service
        foreach ($_ids_service_option as $_id_service_option) {
            $_service_option = $_service_option_manager->getDevServiceOptionById($_id_service_option);
            $_service_client->addDevServiceOption($_service_option);
        }

        $this->_entity_manager->persist($_service_client);
        $this->_entity_manager->flush();

        return $_service_client;
    }

    /**
     * Mettre à jour le statut de paiement en payé
     * @param DevServiceClient $_service_client
     * @param boolean $_payed
     * @return array
     */
    public function setPaymentPayed(DevServiceClient $_service_client, $_payed)
    {
        $_service_client->setSrvCltIsPayed($_payed);

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Envoie email bon de commande
     * @param DevServiceClient $_service_client
     * @return boolean
     */
    public function sendEmailBonCommandePayment(DevServiceClient $_service_client)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        $_template   = 'AdminBundle:DevServiceClient:email_bon_commande.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Bon de commande'))
            ->setFrom(array($_from_email_address => $_from_firstname))
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

    /**
     * Envoie email notification de commande
     * @param DevServiceClient $_service_client
     * @return boolean
     */
    public function sendEmailNouveauCommande(DevServiceClient $_service_client)
    {
        // Récupérer les adresses mail destinataire
        $_to_email_address       = $this->_container->getParameter('to_email_address');
        $_to_email_name          = $this->_container->getParameter('to_email_name');
        $_to_cc_ct_email_address = $this->_container->getParameter('to_cc_ct_email_address');
        $_to_cc_rc_email_address = $this->_container->getParameter('to_cc_rc_email_address');

        $_template   = 'AdminBundle:DevServiceClient:email_nouveau_commande.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client,
            'to_email_name'  => $_to_email_name
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Nouveau commande'))
            ->setFrom(array($_from_email_address => $_from_firstname))
            ->setTo($_to_email_address)
            ->setBcc($_to_cc_ct_email_address)
            ->setCc($_to_cc_rc_email_address)
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

    /**
     * Envoie email annulation validation
     * @param DevServiceClient $_service_client
     * @param string $_comment
     * @return boolean
     */
    public function sendEmailCancelValidation(DevServiceClient $_service_client, $_comment)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        $_template   = 'AdminBundle:DevServiceClient:email_cancel_validation.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client,
            'comment'        => $_comment
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Fichiers non conformes'))
            ->setFrom(array($_from_email_address => $_from_firstname))
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

    /**
     * Annulation validation du service
     * @param DevServiceClient $_service_client
     * @param string $_comment
     * @return array
     */
    public function cancelStatusValidationService(DevServiceClient $_service_client, $_comment)
    {
        $_service_client->setSrvCltStatusValidation(EtatServiceValidation::ID_FICHIER_NON_CONFORME);

        // Envoie mail annulation
        $this->sendEmailCancelValidation($_service_client, $_comment);

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Mettre à jour le statut validation du service
     * @param DevServiceClient $_service_client
     * @param int $_status
     * @return array
     */
    public function setStatusValidationService(DevServiceClient $_service_client, $_status)
    {
        $_service_client->setSrvCltStatusValidation($_status);

        // Envoie mail de confirmation et mail de facture
        if ($_status == EtatServiceValidation::ID_BON_COMMANDE) {
            $this->sendEmailBonCommandePayment($_service_client);
        } else {
            $this->sendEmailClientByStatus($_service_client, $_status);
        }

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Mettre à jour le statut projet du service
     * @param DevServiceClient $_service_client
     * @param int $_status
     * @return array
     */
    public function setStatusProjectService(DevServiceClient $_service_client, $_status)
    {
        $_service_client->setSrvCltStatusProject($_status);

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Envoie email compte espace client
     * @param User $_user
     * @return boolean
     */
    public function sendEmailConnexionClient(User $_user)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_user->getEmail();

        // Url de connexion
        $_connexion_url = $_url_detail_group = $this->_container->get('router')->generate('service_client_list',
            array(),UrlGeneratorInterface::ABSOLUTE_URL
        );

        $_template   = 'AdminBundle:DevServiceClient:email_connexion_client.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'user'          => $_user,
            'connexion_url' => $_connexion_url
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Lien espace membre'))
            ->setFrom(array($_from_email_address => $_from_firstname))
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

    /**
     * Tester si l'utilisateur est bien validé
     * @param DevServiceClient $_service_client
     * @return array
     */
    public function isUserValid(DevServiceClient $_service_client)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();
        $_id_role_user   = $_user_connected->getDevRole()->getId();

        $_service_client = $this->getRepository()->findBy(array(
            'id'     => $_service_client->getId(),
            'lvUser' => $_id_user
        ));

        if ($_service_client || in_array($_id_role_user, array(RoleName::ID_ROLE_ADMIN, RoleName::ID_ROLE_SUPERADMIN)))
            return true;

        return false;
    }

    /**
     * Envoie email au client
     * @param DevServiceClient $_service_client
     * @param int $_id_status
     * @return boolean
     */
    public function sendEmailClientByStatus(DevServiceClient $_service_client, $_id_status)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        switch ($_id_status) {
            case 0:
                $_message = $this->_translator->trans('mail.message.analyse');
                break;
            case 3:
                $_message = $this->_translator->trans('mail.message.ajustement.panier.commande');
                break;
            case 4:
                $_message = $this->_translator->trans('mail.message.developpement');
                break;
            case 5:
                $_message = $this->_translator->trans('mail.message.test');
                break;
        }

        $_template   = 'AdminBundle:DevServiceClient:email_client.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client,
            'message'        => $_message
        ));

        $_subject            = 'Techzara | ' . EtatServiceValidation::$VALEUR_TYPE[$_id_status];
        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message($_subject))
            ->setFrom(array($_from_email_address => $_from_firstname))
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

    /**
     * Finalisation validation du service
     * @param DevServiceClient $_service_client
     * @param string $_lien_code_source
     * @return array
     */
    public function finaliseStatusValidationService(DevServiceClient $_service_client, $_lien_code_source)
    {
        $_service_client->setSrvCltStatusValidation(EtatServiceValidation::ID_FINALISE);
        $_service_client->setSrvCltLienCodeSource($_lien_code_source);

        // Envoie mail finalisation
        $this->sendEmailFinaliseValidation($_service_client, $_lien_code_source);

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Lien livraison validation du service
     * @param DevServiceClient $_service_client
     * @param string $_lien_livre
     * @return array
     */
    public function lienLivreStatusValidationService(DevServiceClient $_service_client, $_lien_livre)
    {
        $_service_client->setSrvCltStatusValidation(EtatServiceValidation::ID_LIEN_LIVRE);
        $_service_client->setSrvCltLienLivre($_lien_livre);

        // Envoie mail lien livré
        $this->sendEmailLienLivreValidation($_service_client, $_lien_livre);

        $this->saveDevServiceClient($_service_client, 'update');
    }

    /**
     * Envoie email lien livré validation
     * @param DevServiceClient $_service_client
     * @param string $_lien_livre
     * @return boolean
     */
    public function sendEmailLienLivreValidation(DevServiceClient $_service_client, $_lien_livre)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        $_template   = 'AdminBundle:DevServiceClient:email_lien_livre_validation.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client,
            'lien_livre'     => $_lien_livre
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Lien livré'))
            ->setFrom(array($_from_email_address => $_from_firstname))
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

    /**
     * Envoie email finalisation validation
     * @param DevServiceClient $_service_client
     * @param string $_lien_code_source
     * @return boolean
     */
    public function sendEmailFinaliseValidation(DevServiceClient $_service_client, $_lien_code_source)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        $_template   = 'AdminBundle:DevServiceClient:email_finalise_validation.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client'   => $_service_client,
            'lien_code_source' => $_lien_code_source
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Projet finalisé'))
            ->setFrom(array($_from_email_address => $_from_firstname))
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