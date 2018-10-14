<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevService;

use App\Techzara\Service\MetierManagerBundle\Entity\DevService;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevService
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
     * Récuperer le repository service
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SERVICE);
    }

    /**
     * Récuperer tout les services
     * @return array
     */
    public function getAllDevService()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les services
     * @return array
     */
    public function getAllDevServiceOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un service par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevServiceById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un service
     * @param DevService $_service
     * @param string $_action
     * @return boolean
     */
    public function saveDevService($_service, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un service
     * @param DevService $_service
     * @return boolean
     */
    public function deleteDevService($_service)
    {
        $this->_entity_manager->remove($_service);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un service
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevService($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_service = $this->getDevServiceById($_id);
                $this->deleteDevService($_service);
            }
        }

        return true;
    }

    /**
     * Récuperer le service par slug
     * @param string $_slug
     * @return array
     */
    public function getDevServiceBySlug($_slug)
    {
        $_service = $this->getRepository()->findBySrvSlug($_slug);

        if ($_service)
            return $_service[0];

        return false;
    }
}