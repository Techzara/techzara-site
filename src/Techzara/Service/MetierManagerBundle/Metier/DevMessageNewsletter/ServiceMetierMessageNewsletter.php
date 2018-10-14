<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevMessageNewsletter;

use App\Techzara\Service\MetierManagerBundle\Entity\DevMessageNewsletter;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceMetierMessageNewsletter
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->_entity_manager;
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
     * Récuperer le repository message newsletter
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_MESSAGE_NEWSLETTER);
    }

    /**
     * Récuperer tout les messages newsletter
     * @return array
     */
    public function getAllMessageNewsletter()
    {
        return $this->getRepository()->findBy(
            array(),
            array('id' => 'DESC')
        );
    }

    /**
     * Récuperer un message newsletter par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getMessageNewsletterById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un Message newsletter
     * @param DevMessageNewsletter $_message_newsletter
     * @param string $_action
     * @return boolean
     */
    public function saveMessageNewsletter($_message_newsletter, $_action)
    {

        if ($_action == 'new') {
            $this->_entity_manager->persist($_message_newsletter);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un message newsletter
     * @param DevMessageNewsletter $_message_newsletter
     * @return boolean
     */
    public function deleteMessageNewsletter($_message_newsletter)
    {
        $this->_entity_manager->remove($_message_newsletter);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un message newsletter
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupMessageNewsletter($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_message_newsletter = $this->getMessageNewsletterById($_id);
                $this->deleteMessageNewsletter($_message_newsletter);
            }
        }

        return true;
    }

    /**
     * Insertion message newsletter dans front office
     * @param $_message
     * @return bool
     */
    public function insertFrontMessageNewsletter($_message)
    {
        $_message_newsletter = $this->getRepository()->findBy(array(
            'nwsmessage' => $_message
        ));

        if (!empty($_message_newsletter)) {
            return false;
        }

        $_message_newsletter = new DevMessageNewsletter();
        $_message_newsletter->setNwsmessage($_message);

        $this->saveMessageNewsletter($_message_newsletter, 'new');

        return true;
    }

    public function sendEmailNewsletter($_request, $_emails)
    {
        $_post    = $_request->request->all();
        $_subject = $_post['tz_service_metiermanagerbundle_message_newsletter']['translations']['fr']['messageNewsletterTitle'];
        $_content = $_post['tz_service_metiermanagerbundle_message_newsletter']['translations']['fr']['messageNewsletterContent'];

        $_template = 'AdminBundle:DevMessageNewsletter:email.html.twig';

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        foreach($_emails as $_email) {
            if ($_email->isNwsSubscribed() == true) {
                $_to_email_address = $_email->getNwsEmail();

                // Url de désabonnement
                $_unsubscriber_url = $_url_detail_group = $this->_container->get('router')->generate('email_newsletter_unsubscriber',
                    array('id' => $_email->getId()),UrlGeneratorInterface::ABSOLUTE_URL
                );

                $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
                    'content'          => $_content,
                    'unsubscriber_url' => $_unsubscriber_url
                ));

                $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
                $_message    = (new \Swift_Message('Techzara newsletter | ' . $_subject))
                    ->setFrom(array($_from_email_address => $_from_firstname))
                    ->setTo($_to_email_address)
                    ->setBody($_email_body);

                $_message->setContentType("text/html");
                $this->_container->get('mailer')->send($_message);

                $_headers = $_message->getHeaders();
                $_headers->addIdHeader('Message-ID', uniqid() . "@domain.com");
                $_headers->addTextHeader('MIME-Version', '1.0');
                $_headers->addTextHeader('X-Mailer', 'PHP v' . phpversion());
                $_headers->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);
            }
        }

        return true;
    }
}
