<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevContactDevis;

use App\Techzara\Service\MetierManagerBundle\Utils\MaxSizeValue;
use App\Techzara\Service\MetierManagerBundle\Utils\PathName;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceMetierDevContactDevis
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    public function __construct(EntityManager $_entity_manager, Container $_container, $_root_dir)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
        $this->_web_root       = realpath($_root_dir . '/../public');
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
     * Envoie email
     * @param array $_data
     * @param array $_file_join
     * @return boolean
     */
    public function sendEmail($_data, $_file_join)
    {
        // Pièce jointe
        $_file_details        = $_file_join['file_jointe'];
        $_jointe_path         = '';
        $_max_file_size_value = $this->_container->getParameter('max_size_value_upload');
        if ($_file_details and ($_file_details->getClientSize() < $_max_file_size_value)) {
            $_jointe_path = $this->addJointeMail($_file_details);
        }

        // Récupérer l'adresse mail destinataire
        $_recipient = $this->_container->getParameter('to_email_address');

        $_template   = 'FrontBundle:DevContactDevis:email.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'firstname' => $_data['firstname'],
            'data'      => $_data
        ));

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Demande de devis'))
            ->setFrom(array($_data['email'] => $_data['firstname']))
            ->setTo($_recipient)
            ->setBody($_email_body);

        // Pièce jointe
        if ($_file_details and ($_file_details->getClientSize() < $_max_file_size_value)) {
            $_message->attach(\Swift_Attachment::fromPath($_jointe_path));
        }

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
     * Upload pièce jointe
     * @param $_jointe
     * @return string
     */
    public function addJointeMail($_jointe) {
        // Récupérer le répertoire image spécifique
        $_directory_image = PathName::UPLOAD_JOINTE;

        try {
            $_extension = $_jointe->guessExtension();

            // Upload jointe
            $_file_name_image = md5(uniqid()) . '.' . $_extension;
            $_dir             = $this->_web_root . $_directory_image;
            $_jointe->move(
                $_dir,
                $_file_name_image
            );

            return $_dir.$_file_name_image;
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }
}
