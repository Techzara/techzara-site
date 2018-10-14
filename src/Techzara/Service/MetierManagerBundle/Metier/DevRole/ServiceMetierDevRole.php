<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevRole;

use App\Techzara\Service\MetierManagerBundle\Entity\DevRole;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevRole
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
     * Récuperer le repository rôle
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_USER_ROLE);
    }

    /**
     * Récuperer tout les rôles
     * @return array
     */
    public function getAllDevRole()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un rôle par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevRoleById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un rôle
     * @param DevRole $_role
     * @param string $_action
     * @return boolean
     */
    public function saveDevRole($_role, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_role);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un rôle
     * @param DevRole $_role
     * @return boolean
     */
    public function deleteDevRole($_role)
    {
        $this->_entity_manager->remove($_role);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un rôle
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevRole($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_role = $this->getDevRoleById($_id);
                $this->deleteDevRole($_role);
            }
        }

        return true;
    }
}