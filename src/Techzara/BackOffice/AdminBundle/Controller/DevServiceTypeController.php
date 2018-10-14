<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceTypeType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceType;

/**
 * Class DevServiceTypeController
 */
class DevServiceTypeController extends Controller
{
    /**
     * Afficher tout les service types
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        // Récupérer tout les service_type
        $_service_types = $_service_type_manager->getAllDevServiceType();

        return $this->render('AdminBundle:DevServiceType:index.html.twig', array(
            'service_types' => $_service_types
        ));
    }

    /**
     * Affichage page modification service type
     * @param DevServiceType $_service_type
     * @return Render page
     */
    public function editAction(DevServiceType $_service_type)
    {
        if (!$_service_type) {
            throw $this->createNotFoundException('Unable to find DevServiceType entity.');
        }

        $_edit_form = $this->createEditForm($_service_type);

        return $this->render('AdminBundle:DevServiceType:edit.html.twig', array(
            'service_type' => $_service_type,
            'edit_form'    => $_edit_form->createView()
        ));
    }

    /**
     * Création service type
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        $_service_type = new DevServiceType();
        $_form         = $this->createCreateForm($_service_type);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement service type
            $_service_type_manager->saveDevServiceType($_service_type, 'new');

            $_service_type_manager->setFlash('success', "Type service ajouté");

            return $this->redirect($this->generateUrl('service_type_index'));
        }

        return $this->render('AdminBundle:DevServiceType:add.html.twig', array(
            'service_type' => $_service_type,
            'form'         => $_form->createView()
        ));
    }

    /**
     * Modification service type
     * @param Request $_request requête
     * @param DevServiceType $_service_type
     * @return Render page
     */
    public function updateAction(Request $_request, DevServiceType $_service_type)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        if (!$_service_type) {
            throw $this->createNotFoundException('Unable to find DevServiceType entity.');
        }

        $_edit_form = $this->createEditForm($_service_type);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_service_type_manager->saveDevServiceType($_service_type, 'update');

            $_service_type_manager->setFlash('success', "Type service modifié");

            return $this->redirect($this->generateUrl('service_type_index'));
        }

        return $this->render('AdminBundle:DevServiceType:edit.html.twig', array(
            'service_type' => $_service_type,
            'edit_form'    => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition service type
     * @param DevServiceType $_service_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevServiceType $_service_type)
    {
        $_form = $this->createForm(DevServiceTypeType::class, $_service_type, array(
            'action' => $this->generateUrl('service_type_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création service type
     * @param DevServiceType $_service_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevServiceType $_service_type)
    {
        $_form = $this->createForm(DevServiceTypeType::class, $_service_type, array(
            'action' => $this->generateUrl('service_type_update', array('id' => $_service_type->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression service type
     * @param Request $_request requête
     * @param DevServiceType $_service_type
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevServiceType $_service_type)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        $_form = $this->createDeleteForm($_service_type);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression service type
            $_service_type_manager->deleteDevServiceType($_service_type);

            $_service_type_manager->setFlash('success', 'Type service supprimé');
        }

        return $this->redirectToRoute('service_type_index');
    }

    /**
     * Création formulaire de suppression service type
     * @param DevServiceType $_service_type The DevServiceType entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevServiceType $_service_type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_type_delete', array('id' => $_service_type->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste service type
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_service_type_manager = $this->get(ServiceName::SRV_METIER_SERVICE_TYPE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_service_type_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('service_type_index'));
            }
            $_service_type_manager->deleteGroupDevServiceType($_ids);
        }

        $_service_type_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('service_type_index'));
    }
}