<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\TzEmailNewsletter;

use App\Techzara\Service\MetierManagerBundle\Entity\TzEmailNewsletter;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierEmailNewsletter
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
     * Récuperer le repository email newsletter
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::TZ_EMAIL_NEWSLETTER);
    }

    /**
     * Récuperer tout les emails newsletter
     * @return array
     */
    public function getAllEmailNewsletter()
    {
        return $this->getRepository()->findBy(
            array(),
            array('id' => 'DESC')
        );
    }

    /**
     * Récuperer un email newsletter par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getEmailNewsletterById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un email newsletter
     * @param TzEmailNewsletter $_email_newsletter
     * @param string $_action
     * @return boolean
     */
    public function saveEmailNewsletter($_email_newsletter, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_email_newsletter);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un email newsletter
     * @param TzEmailNewsletter $_email_newsletter
     * @return boolean
     */
    public function deleteEmailNewsletter($_email_newsletter)
    {
        $this->_entity_manager->remove($_email_newsletter);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un email newsletter
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupEmailNewsletter($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_email_newsletter = $this->getEmailNewsletterById($_id);
                $this->deleteEmailNewsletter($_email_newsletter);
            }
        }

        return true;
    }

    /**
     * Insertion email newsletter dans front office
     * @param $_email
     * @return bool
     */
    public function insertFrontEmailNewsLetter($_email)
    {
        $_email_newsletter = $this->getRepository()->findBy(array(
            'nwsEmail' => $_email
        ));
        if (!empty($_email_newsletter)) {
            return false;
        }
        $_email_newsletter = new TzEmailNewsletter();
        $_email_newsletter->setNwsEmail($_email);

        $this->saveEmailNewsletter($_email_newsletter, 'new');
        return true;
    }

    /**
     * Désabonnement newsletter
     * @param TzEmailNewsletter $_email_newsletter
     * @return array
     */
    public function unsubscriberById(TzEmailNewsletter $_email_newsletter)
    {
        $_email_newsletter->setNwsSubscribed(0);

        return $this->saveEmailNewsletter($_email_newsletter, 'update');
    }
}
