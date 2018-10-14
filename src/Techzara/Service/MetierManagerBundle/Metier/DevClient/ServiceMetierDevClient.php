<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevClient;

use App\Techzara\Service\MetierManagerBundle\Entity\DevClient;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Role\Role;

class ServiceMetierDevClient
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
     * Récuperer le repository client
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::USER);
    }

    /**
     * Récuperer tout les clients
     * @return array
     */
    public function getAllDevClient()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un client par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevClientById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un client
     * @param DevClient $_client
     * @param string $_action
     * @return boolean
     */
    public function saveDevClient($_client, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_client);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un client
     * @param DevClient $_client
     * @return boolean
     */
    public function deleteDevClient($_client)
    {
        $this->_entity_manager->remove($_client);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un client
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevClient($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_client = $this->getDevClientById($_id);
                $this->deleteDevClient($_client);
            }
        }

        return true;
    }

    /**
     * Enregistrer un client qui a fait le commande
     * @param array $_data
     * @return boolean
     */
    public function saveDevClientInOrder($_data)
    {
        // Récupérer manager
        $_user_manager      = $this->_container->get(ServiceName::SRV_METIER_USER);
        $_user_role_manager = $this->_container->get(ServiceName::SRV_METIER_USER_ROLE);

        $_client_nom_entreprise = $_data['client_nom_entreprise'];
        $_client_email          = $_data['client_email'];
        $_client_tel            = $_data['client_tel'];
        $_client_mdp            = $_data['client_mdp'];
        $_client_adresse        = $_data['client_adresse'];

        $_is_email_exist = $_user_manager->isEmailExist($_client_email);
        if ($_is_email_exist) {
            $_user_return = $_user_manager->getUserByEmail($_client_email);
        } else {
            $_user = new User();
            $_user->setUsrNomEntreprise($_client_nom_entreprise);
            $_user->setUsrPhone($_client_tel);
            $_user->setUsrAddress($_client_adresse);
            $_user->setUsername($_client_email);
            $_user->setEmail($_client_email);
            $_user->setEnabled(true);

            // Traitement rôle utilisateur
            $_user_role = $_user_role_manager->getDevRoleById(RoleName::ID_ROLE_CLIENT);
            $_user->setDevRole($_user_role);
            $_user->setRoles(array(RoleName::ROLE_CLIENT));

            // Mise à jour mot de passe
            if ($_client_mdp != null) {
                $_fos_user_manager = $this->_container->get('fos_user.user_manager');
                $_user->setPlainPassword($_client_mdp);
                $_fos_user_manager->updatePassword($_user);
            }

            $_user_return = $_user_manager->saveUser($_user, 'new');
        }

        return $_user_return;
    }
}