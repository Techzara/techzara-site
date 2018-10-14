<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevRoleType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevRole;

/**
 * Class DevRoleController
 */
class DevRoleController extends Controller
{
    /**
     * Afficher tout les rôles
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        // Récupérer tout les role
        $_roles = $_role_manager->getAllDevRole();

        return $this->render('AdminBundle:DevRole:index.html.twig', array(
            'roles' => $_roles
        ));
    }

    /**
     * Affichage page modification rôle
     * @param DevRole $_role
     * @return Render page
     */
    public function editAction(DevRole $_role)
    {
        if (!$_role) {
            throw $this->createNotFoundException('Unable to find DevRole entity.');
        }

        $_edit_form = $this->createEditForm($_role);

        return $this->render('AdminBundle:DevRole:edit.html.twig', array(
            'role'      => $_role,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création rôle
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        $_role = new DevRole();
        $_form = $this->createCreateForm($_role);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement rôle
            $_role_manager->saveDevRole($_role, 'new');

            $_role_manager->setFlash('success', "Rôle ajouté");

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:DevRole:add.html.twig', array(
            'role' => $_role,
            'form' => $_form->createView()
        ));
    }

    /**
     * Modification rôle
     * @param Request $_request requête
     * @param DevRole $_role
     * @return Render page
     */
    public function updateAction(Request $_request, DevRole $_role)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        if (!$_role) {
            throw $this->createNotFoundException('Unable to find DevRole entity.');
        }

        $_edit_form = $this->createEditForm($_role);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_role_manager->saveDevRole($_role, 'update');

            $_role_manager->setFlash('success', "Rôle modifié");

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:DevRole:edit.html.twig', array(
            'role'      => $_role,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition rôle
     * @param DevRole $_role The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevRole $_role)
    {
        $_form = $this->createForm(DevRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création rôle
     * @param DevRole $_role The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevRole $_role)
    {
        $_form = $this->createForm(DevRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_update', array('id' => $_role->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression rôle
     * @param Request $_request requête
     * @param DevRole $_role
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevRole $_role)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        $_form = $this->createDeleteForm($_role);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression rôle
            $_role_manager->deleteDevRole($_role);

            $_role_manager->setFlash('success', 'Rôle supprimé');
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Création formulaire de suppression rôle
     * @param DevRole $_role The DevRole entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevRole $_role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $_role->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste rôle
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_role_manager = $this->get(ServiceName::SRV_METIER_USER_ROLE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_role_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('role_index'));
            }
            $_role_manager->deleteGroupDevRole($_ids);
        }

        $_role_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('role_index'));
    }
}