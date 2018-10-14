<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevServiceOptionType;

use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOptionType;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevServiceOptionType
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
     * Récuperer le repository service_option_type
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SERVICE_OPTION_TYPE);
    }

    /**
     * Récuperer tout les service_option_types
     * @return array
     */
    public function getAllDevServiceOptionType()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un service_option_type par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevServiceOptionTypeById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un service_option_type
     * @param DevServiceOptionType $_service_option_type
     * @param string $_action
     * @return boolean
     */
    public function saveDevServiceOptionType($_service_option_type, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service_option_type);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un service_option_type
     * @param DevServiceOptionType $_service_option_type
     * @return boolean
     */
    public function deleteDevServiceOptionType($_service_option_type)
    {
        $this->_entity_manager->remove($_service_option_type);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un service_option_type
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevServiceOptionType($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_service_option_type = $this->getDevServiceOptionTypeById($_id);
                $this->deleteDevServiceOptionType($_service_option_type);
            }
        }

        return true;
    }
}