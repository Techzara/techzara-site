<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevFaq;

use App\Techzara\Service\MetierManagerBundle\Entity\DevFaq;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevFaq
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
     * Récuperer le repository faq
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_FAQ);
    }

    /**
     * Récuperer tout les faqs
     * @return array
     */
    public function getAllDevFaq()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un faq par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevFaqById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un faq
     * @param DevFaq $_faq
     * @param string $_action
     * @return boolean
     */
    public function saveDevFaq($_faq, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_faq);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un faq
     * @param DevFaq $_faq
     * @return boolean
     */
    public function deleteDevFaq($_faq)
    {
        $this->_entity_manager->remove($_faq);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un faq
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevFaq($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_faq = $this->getDevFaqById($_id);
                $this->deleteDevFaq($_faq);
            }
        }

        return true;
    }
}
