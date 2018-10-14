<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevFacture;

use App\Techzara\Service\MetierManagerBundle\Entity\DevFacture;
use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use App\Techzara\Service\MetierManagerBundle\Utils\EtatFactureName;
use App\Techzara\Service\MetierManagerBundle\Utils\PathReportingName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\EntityManager;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Translation\TranslatorInterface;

class ServiceMetierDevFacture
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
     * Récuperer le repository facture
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_FACTURE);
    }

    /**
     * Récuperer tout les factures
     * @return array
     */
    public function getAllDevFacture()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un facture par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevFactureById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un facture
     * @param DevFacture $_facture
     * @param string $_action
     * @return boolean
     */
    public function saveDevFacture($_facture, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_facture);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un facture
     * @param DevFacture $_facture
     * @return boolean
     */
    public function deleteDevFacture($_facture)
    {
        $this->_entity_manager->remove($_facture);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un facture
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevFacture($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_facture = $this->getDevFactureById($_id);
                $this->deleteDevFacture($_facture);
            }
        }

        return true;
    }
    
    /**
     * Envoie email facture
     * @param DevServiceClient $_service_client
     * @return boolean
     */
    public function sendEmail(DevServiceClient $_service_client)
    {
        // Récupérer manager
        $_service_client_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupérer l'adresse mail destinataire
        $_recipient = $_service_client->getDevUser()->getEmail();

        $_template   = 'AdminBundle:DevServiceClient:email_facture_paiement.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'service_client' => $_service_client
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Techzara | Confirmation de paiement'))
            ->setFrom(array($_from_email_address => $_from_firstname))
            ->setTo($_recipient)
            ->setBody($_email_body);

        // Pièce jointe
        $_file = $this->generateReportingFacture($_service_client);
        $_message->attach(\Swift_Attachment::fromPath($_file));

        $_message->setContentType("text/html");
        $_result = $this->_container->get('mailer')->send($_message);

        $_headers = $_message->getHeaders();
        $_headers->addIdHeader('Message-ID', uniqid() . "@domain.com");
        $_headers->addTextHeader('MIME-Version', '1.0');
        $_headers->addTextHeader('X-Mailer', 'PHP v' . phpversion());
        $_headers->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

        if ($_result) {
            // Enregistrement facture
            $_facture = new DevFacture();

            $_facture->setFctStatus(EtatFactureName::ID_ENVOYE);
            $_facture->setFctDate(new \DateTime());
            $_facture->setDevServiceClient($_service_client);
            
            $this->saveDevFacture($_facture, 'new');

            // Modification etat facture en envoyé
            $_service_client->setSrvCltPaymentIsFacture(true);
            $_service_client->setSrvCltIsPayed(true);
            $_service_client_manager->saveDevServiceClient($_service_client, 'update');

            return true;
        }

        return false;
    }

    /**
     * Générer un reporting facture
     * @param DevServiceClient $_service_client
     * @return string
     */
    public function generateReportingFacture(DevServiceClient $_service_client) {
        $_num_facture = $_service_client->getId();
        $_filename    = "FACTURE_PAIEMENT_NUMERO_$_num_facture";

        $_reporting_directory = $this->_container->getParameter('reporting_template_directory');
        $_path                = $_reporting_directory . PathReportingName::GENERATE_FACTURE;
        $_path_file_pdf       = $_path .DIRECTORY_SEPARATOR. $_filename . '.pdf';

        $_date = (new \DateTime())->format('d/m/Y');

        $_html2pdf = new Html2Pdf("P",
            "A4",
            "fr",
            true,
            "UTF-8",
            array(
                10,
                15,
                10,
                15
            )
        );

        $_template     = 'AdminBundle:DevServiceClient:facture.html.twig';
        $_html_facture = $this->_container->get('templating')->render($_template,
            [
                'service_client' => $_service_client,
                'date'           => $_date
            ]
        );

        $_html2pdf->setTestTdInOnePage(false);
        $_html2pdf->writeHTML($_html_facture);
        $_html2pdf->output($_path_file_pdf,"F");

        return $_path_file_pdf;
    }
}