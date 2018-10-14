<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceOptionType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOption;

/**
 * Class DevServiceOptionController
 */
class DevServiceOptionController extends Controller
{
    /**
     * Afficher tout les option services
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        // Récupérer tout les service_option
        $_service_options = $_service_option_manager->getAllDevServiceOption();

        return $this->render('AdminBundle:DevServiceOption:index.html.twig', array(
            'service_options' => $_service_options
        ));
    }

    /**
     * Affichage page modification option service
     * @param DevServiceOption $_service_option
     * @return Render page
     */
    public function editAction(DevServiceOption $_service_option)
    {
        if (!$_service_option) {
            throw $this->createNotFoundException('Unable to find DevServiceOption entity.');
        }

        $_edit_form = $this->createEditForm($_service_option);

        return $this->render('AdminBundle:DevServiceOption:edit.html.twig', array(
            'service_option' => $_service_option,
            'edit_form'      => $_edit_form->createView()
        ));
    }

    /**
     * Création option service
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        $_service_option = new DevServiceOption();
        $_form           = $this->createCreateForm($_service_option);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement option service
            $_service_option_manager->saveDevServiceOption($_service_option, 'new');

            $_service_option_manager->setFlash('success', "Option service ajouté");

            return $this->redirect($this->generateUrl('service_option_index'));
        }

        return $this->render('AdminBundle:DevServiceOption:add.html.twig', array(
            'service_option' => $_service_option,
            'form'           => $_form->createView()
        ));
    }

    /**
     * Modification option service
     * @param Request $_request requête
     * @param DevServiceOption $_service_option
     * @return Render page
     */
    public function updateAction(Request $_request, DevServiceOption $_service_option)
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        if (!$_service_option) {
            throw $this->createNotFoundException('Unable to find DevServiceOption entity.');
        }

        $_edit_form = $this->createEditForm($_service_option);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_service_option_manager->saveDevServiceOption($_service_option, 'update');

            $_service_option_manager->setFlash('success', "Option service modifié");

            return $this->redirect($this->generateUrl('service_option_index'));
        }

        return $this->render('AdminBundle:DevServiceOption:edit.html.twig', array(
            'service_option' => $_service_option,
            'edit_form'      => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition option service
     * @param DevServiceOption $_service_option The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevServiceOption $_service_option)
    {
        $_form = $this->createForm(DevServiceOptionType::class, $_service_option, array(
            'action' => $this->generateUrl('service_option_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création option service
     * @param DevServiceOption $_service_option The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevServiceOption $_service_option)
    {
        $_form = $this->createForm(DevServiceOptionType::class, $_service_option, array(
            'action' => $this->generateUrl('service_option_update', array('id' => $_service_option->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression option service
     * @param Request $_request requête
     * @param DevServiceOption $_service_option
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevServiceOption $_service_option)
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        $_form = $this->createDeleteForm($_service_option);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression option service
            $_service_option_manager->deleteDevServiceOption($_service_option);

            $_service_option_manager->setFlash('success', 'Option service supprimé');
        }

        return $this->redirectToRoute('service_option_index');
    }

    /**
     * Création formulaire de suppression option service
     * @param DevServiceOption $_service_option The DevServiceOption entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevServiceOption $_service_option)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_option_delete', array('id' => $_service_option->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste option service
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_service_option_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('service_option_index'));
            }
            $_service_option_manager->deleteGroupDevServiceOption($_ids);
        }

        $_service_option_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('service_option_index'));
    }
}