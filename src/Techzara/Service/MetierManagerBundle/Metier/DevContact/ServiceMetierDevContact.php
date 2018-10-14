<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevContact;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevContact
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
     * Envoie email
     * @param array $_data
     * @return boolean
     */
    public function sendEmail($_data)
    {
        // Récupérer l'adresse mail destinataire
        $_recipient = $this->_container->getParameter('to_email_address');

        $_template   = 'FrontBundle:DevContact:email.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'firstname' => $_data['firstname'],
            'data'      => $_data
        ));

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message    = (new \Swift_Message('Contact'))
            ->setFrom(array($_data['email'] => $_data['firstname']))
            ->setTo($_recipient)
            ->setBody($_email_body);

        $_message->setContentType("text/html");
        $result = $this->_container->get('mailer')->send($_message);

        if ($result) {
            return true;
        }

        return false;
    }
}
