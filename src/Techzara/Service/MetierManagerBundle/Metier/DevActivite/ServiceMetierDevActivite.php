<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 11:27 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevActivite;

use App\Techzara\Service\MetierManagerBundle\Entity\DevActivite;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevActivite
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


    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::ACTIVITE);
    }


    public function getAllActivite()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    public function getAllActiviteById($_id)
    {
        return $this->getRepository()->find($_id);
    }



    /**
     * Ajouter un utilisateur
     * @param \App\Techzara\Service\MetierManagerBundle\Form\DevActivite $activite
     * @param Object $_form
     * @return boolean
     */
    public function addActivite($activite)
    {
        $this->saveActivite($activite, 'new');
    }


    /**
     * Enregistrer un utilisateur
     * @param DevActivite $activite
     * @param string $_action
     * @return boolean
     */
    public function saveActivite($activite, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($activite);
        }
        $this->_entity_manager->flush();

        return $activite;
    }


    /**
     * Modifier un utilisateur
     * @param DevActivite $activite
     * @param Object $_form
     * @return boolean
     */
    public function updateActivite($activite)
    {
        $this->saveActivite($activite, 'update');
    }

    /**
     * Supprimer un utilisateur
     * @param DevActivite $activite
     * @return boolean
     */
    public function deleteDevActivite($activite)
    {
        $this->_entity_manager->remove($activite);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un activite
     * @param array $_ids
     * @return boolean
     */
    public function deleteDevActiviteGroup($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                // Suppression fichier image
                // Suppression utilisateur
                $activite = $this->getAllActiviteById($_id);
                $this->deleteDevActivite($activite);
            }
        }

        return true;
    }


}