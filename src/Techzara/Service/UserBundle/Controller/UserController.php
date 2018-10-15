<?php

namespace App\Techzara\Service\UserBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Techzara\Service\UserBundle\Entity\User;
use App\Techzara\Service\UserBundle\Form\UserType;

/**
 * Class UserController
 *
 * @package UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * Afficher tout les utilisateurs
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        // Récupérer tout les utilisateurs
        $_users = $_user_manager->getAllUser();

        return $this->render('UserBundle:User:index.html.twig', array(
            'users' => $_users,
        ));
    }

    /**
     * Affichage page modification utilisateur
     *
     * @param User $_user
     *
     * @return Render page
     */
    public function editAction(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();
        $_user_role      = $_user_connected->getTzRole()->getId();

        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        // Vérification utilisateur connecté
        if (($_user_role != RoleName::ID_ROLE_ADMIN) && ($_user_role != RoleName::ID_ROLE_SUPERADMIN)) {
            if ($_user->getId() != $_id_user) {
                return $this->redirectToRoute('user_edit', array(
                    'id' => $_id_user
                ));
            }
        }

        $_edit_form = $this->createEditForm($_user);

        $_template = 'UserBundle:User:edit.html.twig';
        if ($_user_role == RoleName::ID_ROLE_MEMBRES)
            $_template = 'UserBundle:User:edit_member.html.twig';

        return $this->render($_template, array(
            'user'      => $_user,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création utilisateur
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        $_user = new User();
        $_form = $this->createCreateForm($_user);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement utilisateur
            $_user_manager->addUser($_user, $_form);

            $_user_manager->setFlash('success', "Utilisateur ajouté");

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('UserBundle:User:add.html.twig', array(
            'user' => $_user,
            'form' => $_form->createView()
        ));
    }

    /**
     * Modification utilisateur
     * @param Request $_request requête
     * @param User $_user
     * @return Render page
     */
    public function updateAction(Request $_request, User $_user)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();
        $_user_role      = $_user_connected->getTzRole()->getId();

        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $_edit_form = $this->createEditForm($_user);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Mise à jour utilisateur
            $_user_manager->updateUser($_user, $_edit_form);

            $_user_manager->setFlash('success', "Utilisateur modifié");

            // Vérification utilisateur connecté
            if ($_user_role == RoleName::ID_ROLE_MEMBRES) {
                return $this->redirectToRoute('user_edit', array(
                    'id' => $_id_user
                ));
            }

            return $this->redirect($this->generateUrl('user_index'));
        }

        $_template = 'UserBundle:User:edit.html.twig';
        if ($_user_role == RoleName::ID_ROLE_MEMBRES)
            $_template = 'UserBundle:User:edit_member.html.twig';

        return $this->render($_template, array(
            'user'      => $_user,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->container->get('security.token_storage')->getToken()->getUser();
        $_user_role      = $_user_connected->getTzRole()->getId();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('user_new'),
            'method'    => 'POST',
            'user_role' => $_user_role
        ));

        return $_form;
    }

    /**
     * Création formulaire de création utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->container->get('security.token_storage')->getToken()->getUser();
        $_user_role      = $_user_connected->getTzRole()->getId();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('user_update', array('id' => $_user->getId())),
            'method'    => 'PUT',
            'user_role' => $_user_role
        ));
        return $_form;
    }

    /**
     * Suppression utilisateur
     * @param Request $_request requête
     * @param User $_user
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, User $_user)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        $_form = $this->createDeleteForm($_user);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression utilisateur
            $_user_manager->deleteUser($_user);

            $_user_manager->setFlash('success', 'Utilisateur supprimé');
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Création formulaire de suppression utilisateur
     * @param User $_user The user entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $_user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $_user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Ajax suppression fichier image utilisateur
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteImageAjaxAction(Request $_request) {
        // Récupérer manager
        $_user_upload_manager = $this->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Récuperation identifiant fichier
        $_data = $_request->request->all();
        $_id   = $_data['id'];

        // Suppression fichier image
        $_response = $_user_upload_manager->deleteImageById($_id);

        return new JsonResponse($_response);
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste utilisateur
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_user_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('user_index'));
            }
            $_user_manager->deleteGroupUser($_ids);
        }

        $_user_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('user_index'));
    }

    /**
     * Mot de passe oublié
     * @param Request $_request
     * @return Render page
     */
    public function resettingPasswordAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        if ($_request->isMethod('POST')) {
            // Récuperer les données formulaire
            $_post       = $_request->request->all();
            $_user_email = $_post['user-email'];

            $_resetting_password = $_user_manager->resettingPassword($_user_email);

            $_status  = 'success';
            $_message = 'Récupération mot de passe a été envoyée au mail';
            if (!$_resetting_password) {
                $_status  = 'error';
                $_message = 'Utilisateur non identifié';
            }

            $_user_manager->setFlash($_status, $_message);

            return $this->redirect($this->generateUrl('Dev_resetting_password'));
        }

        return $this->render('UserBundle:Security:resetting_password.html.twig');
    }
}
