<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevTemoignage;

use App\Techzara\Service\MetierManagerBundle\Entity\DevTemoignage;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevTemoignage
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
     * Récuperer le repository temoignage
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_TEMOIGNAGE);
    }

    /**
     * Récuperer tout les temoignages
     * @return array
     */
    public function getAllDevTemoignage()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les temoignages
     * @return array
     */
    public function getAllDevTemoignageOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un temoignage par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevTemoignageById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un temoignage
     * @param DevTemoignage $_temoignage
     * @param string $_action
     * @return boolean
     */
    public function saveDevTemoignage($_temoignage, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_temoignage);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un temoignage
     * @param DevTemoignage $_temoignage
     * @return boolean
     */
    public function deleteDevTemoignage($_temoignage)
    {
        $this->_entity_manager->remove($_temoignage);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un temoignage
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevTemoignage($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_temoignage = $this->getDevTemoignageById($_id);
                $this->deleteDevTemoignage($_temoignage);
            }
        }

        return true;
    }
}