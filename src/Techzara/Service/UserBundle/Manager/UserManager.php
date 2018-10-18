<?php

namespace App\Techzara\Service\UserBundle\Manager;

use App\Techzara\Service\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use Symfony\Component\DependencyInjection\Container;
use FOS\UserBundle\Model\UserInterface;

class UserManager
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager  = $_entity_manager;
        $this->_container       = $_container;
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
     * Récuperer le repository utilisateur
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::USER);
    }

    /**
     * Récuperer tout les utilisateurs
     * @return array
     */
    public function getAllUser()
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();
        $_user_role      = $_user_connected->getTzRole()->getId();

        // Rôle superadmin
        $_array_type = array(
            'tzRole' => array(
                RoleName::ID_ROLE_SUPERADMIN,
                RoleName::ID_ROLE_ADMIN,
                RoleName::ID_ROLE_MEMBRES,
                RoleName::ID_ROLE_PARTENAIRES,
            )
        );

        return $this->getRepository()->findBy($_array_type, array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les utilisateurs par ordre
     * @param array $_order
     * @return array
     */
    public function getAllUserByOrder($_order)
    {
        return $this->getRepository()->findBy(array(), $_order);
    }

    /**
     * Récuperer un utilisateur par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getUserById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Tester l'existence username
     * @param string $_username
     * @return boolean
     */
    public function isUsernameExist($_username) {
        $_exist = $this->getRepository()->findByUsername($_username);
        if ($_exist) {
            return true;
        }

        return false;
    }

    /**
     * Tester l'existence email
     * @param string $_email
     * @return boolean
     */
    public function isEmailExist($_email) {
        $_exist = $this->getRepository()->findByEmail($_email);
        if ($_exist) {
            return true;
        }

        return false;
    }

    /**
     * Ajouter un utilisateur
     * @param User $_user
     * @param Object $_form
     * @return boolean
     */
    public function addUser($_user, $_form) {
        // Récupérer manager

        // Activer par défaut
        $_user->setEnabled(1);

        // Traitement rôle utilisateur
        $_type      = $_form['tzRole']->getData();
        $_user_role = RoleName::$ROLE_TYPE[$_type->getRlName()];
        $_user->setRoles(array($_user_role));

        // Traitement du photo
        $_img_photo = $_form['usrPhoto']->getData();
        if ($_img_photo) {
            $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);
            $_user_upload_manager->upload($_user, $_img_photo);
        }

        $this->saveUser($_user, 'new');
    }

    /**
     * Modifier un utilisateur
     * @param User $_user
     * @param Object $_form
     * @return boolean
     */
    public function updateUser($_user, $_form) {
        // Traitement photo
        $_img_photo = $_form['usrPhoto']->getData();
        // S'il y a un nouveau fichier ajouté, on supprime l'ancien fichier puis on enregistre ce nouveau
        if ($_img_photo) {
            $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);
            $_user_upload_manager->deleteOnlyImageById($_user->getId());
            $_user_upload_manager->upload($_user, $_img_photo);
        }

        // Traitement rôle utilisateur
        $_type      = $_form['tzRole']->getData();
        $_user_role = RoleName::$ROLE_TYPE[$_type->getRlName()];
        $_user->setRoles(array($_user_role));

        $_user->setUsrDateUpdate(new \DateTime());

        // Mise à jour mot de passe
        $_fos_user_manager = $this->_container->get('fos_user.user_manager');
        $_fos_user_manager->updatePassword($_user);

        $this->saveUser($_user, 'update');
    }

    /**
     * Enregistrer un utilisateur
     * @param User $_user
     * @param string $_action
     * @return boolean
     */
    public function saveUser($_user, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_user);
        }
        $this->_entity_manager->flush();

        return $_user;
    }

    /**
     * Supprimer un utilisateur
     * @param User $_user
     * @return boolean
     */
    public function deleteUser($_user)
    {
        $this->_entity_manager->remove($_user);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un utilisateur
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupUser($_ids)
    {
        $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);

        if (count($_ids)) {
            foreach ($_ids as $_id) {
                // Suppression fichier image
                $_user_upload_manager->deleteImageById($_id);

                // Suppression utilisateur
                $_user = $this->getUserById($_id);
                $this->deleteUser($_user);
            }
        }

        return true;
    }

    /**
     * Récuperer un utilisateur par email
     * @param string $_email
     * @return array
     */
    public function getUserByEmail($_email)
    {
        $_user = $this->getRepository()->findByEmail($_email);

        if ($_user)
            return $_user[0];

        return false;
    }

    /**
     * Vérification si l'utilisateur n'est autre que client
     * @param string $_email
     * @return array
     */
    public function isUserNotClient($_email)
    {
        $_user = $this->getRepository()->findByEmail($_email);

        $_is_user_admin = false;
        if ($_user) {
            $_id_role = $_user[0]->getDevRole()->getId();
            if ($_id_role != RoleName::ID_ROLE_MEMBRES)
                $_is_user_admin = true;
        }

        return $_is_user_admin;
    }

    /**
     * Réinitialisation mot de passe (mot de passe oublié)
     * @param string $_user_email
     * @return boolean
     */
    public function resettingPassword($_user_email)
    {
        // Récupérer l'utilisateur
        $_entity_user = $this->getRepository()->findBy(array('email' => $_user_email));

        if (count($_entity_user) == 0)
            return false;

        // Générer un mot de passe
        $_generated_password = $this->generatePassword(9);
        $_entity_user[0]->setPlainPassword($_generated_password);

        // Mise à jour mot de passe
        $_user_manager = $this->_container->get('fos_user.user_manager');
        $_user_manager->updatePassword($_entity_user[0]);

        $this->saveUser($_entity_user, 'update');

        // Envoyer un email contenant le lien validation compte
        $this->sendEmailUserResettingPassword(
            array(
                "username" => $_user_email,
                "password" => $_generated_password
            ),
            $_user_email,
            $_entity_user[0]
        );

        return true;
    }

    /**
     * Envoie email contenant login et mot de passe (mot de passe oublié)
     * @param array $_data ex: array("username"=>"test","password"=>"123456")
     * @param string $_mail_to
     * @param User $_user
     * @return boolean
     */
    public function sendEmailUserResettingPassword(array $_data, $_mail_to, $_user = null)
    {
        $_template   = 'UserBundle:Email:email_resetting_password.html.twig';
        $_email_body = $this->_container->get('templating')->renderResponse($_template, array(
            'data' => $_data,
            'user' => $_user
        ));

        $_from_email_address = $this->_container->getParameter('from_email_address');
        $_from_firstname     = $this->_container->getParameter('from_firstname');

        $_email_body = implode("\n", array_slice(explode("\n", $_email_body), 4));
        $_message   =  (new \Swift_Message('Techzara: Récupération mot de passe oublié'))
            ->setFrom(array( $_from_email_address => $_from_firstname))
            ->setTo($_mail_to)
            ->setBody($_email_body);

        $_message->setContentType("text/html");
        $_result = $this->_container->get('mailer')->send($_message);

        $_headers = $_message->getHeaders();
        $_headers->addIdHeader('Message-ID', uniqid() . "@domain.com");
        $_headers->addTextHeader('MIME-Version', '1.0');
        $_headers->addTextHeader('X-Mailer', 'PHP v' . phpversion());
        $_headers->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

        if($_result){
            return true;
        }

        return false;
    }

    /**
     * Génération mot de passe
     * @param integer $_length
     * @return string
     */
    public function generatePassword($_length)
    {
        $_caracter         = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789');
        $_special_caracter = str_split('!/\@#$^&*()?');

        shuffle($_caracter);
        shuffle($_special_caracter);

        $_rand            = '';
        $_merged_caracter = array();
        foreach (array_rand($_caracter, ($_length-1)) as $_k) $_merged_caracter[] = $_caracter[$_k];
        $_merged_caracter[] = $_special_caracter[array_rand($_special_caracter, 1)];
        shuffle($_merged_caracter);
        foreach (array_rand($_merged_caracter, $_length) as $_i) $_rand .= $_merged_caracter[$_i];

        return $_rand ;
    }
}
