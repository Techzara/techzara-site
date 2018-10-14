<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevClientType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevClient;

/**
 * Class DevClientController
 */
class DevClientController extends Controller
{
    /**
     * Afficher tout les clients
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_client_manager = $this->get(ServiceName::SRV_METIER_CLIENT);

        // Récupérer tout les client
        $_clients = $_client_manager->getAllDevClient();

        return $this->render('AdminBundle:DevClient:index.html.twig', array(
            'clients' => $_clients
        ));
    }

    /**
     * Affichage page modification client
     * @param DevClient $_client
     * @return Render page
     */
    public function editAction( DevClient $_client )
    {
        if (!$_client) {
            throw $this->createNotFoundException('Unable to find DevClient entity.');
        }

        $_edit_form = $this->createEditForm($_client);

        return $this->render('AdminBundle:DevClient:edit.html.twig', array(
            'client'    => $_client,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création client
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_client_manager = $this->get(ServiceName::SRV_METIER_CLIENT);

        $_client = new DevClient();
        $_form   = $this->createCreateForm($_client);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement client
            $_client_manager->saveDevClient($_client, 'new');

            $_client_manager->setFlash('success', "Service ajouté");

            return $this->redirect($this->generateUrl('client_index'));
        }

        return $this->render('AdminBundle:DevClient:add.html.twig', array(
            'client' => $_client,
            'form'   => $_form->createView(),
        ));
    }

    /**
     * Modification client
     * @param Request $_request requête
     * @param DevClient $_client
     * @return Render page
     */
    public function updateAction(Request $_request, DevClient $_client)
    {
        // Récupérer manager
        $_client_manager = $this->get(ServiceName::SRV_METIER_CLIENT);

        if (!$_client) {
            throw $this->createNotFoundException('Unable to find DevClient entity.');
        }

        $_edit_form = $this->createEditForm($_client);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_client_manager->saveDevClient($_client, 'update');

            $_client_manager->setFlash('success', "Client modifié");

            return $this->redirect($this->generateUrl('client_index'));
        }

        return $this->render('AdminBundle:DevClient:edit.html.twig', array(
            'client'    => $_client,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition client
     * @param DevClient $_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevClient $_client)
    {
        $_form = $this->createForm(DevClientType::class, $_client, array(
            'action' => $this->generateUrl('client_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création client
     * @param DevClient $_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevClient $_client)
    {
        $_form = $this->createForm(DevClientType::class, $_client, array(
            'action' => $this->generateUrl('client_update', array('id' => $_client->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression client
     * @param Request $_request requête
     * @param DevClient $_client
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevClient $_client)
    {
        // Récupérer manager
        $_client_manager = $this->get(ServiceName::SRV_METIER_CLIENT);

        $_form = $this->createDeleteForm($_client);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression client
            $_client_manager->deleteDevClient($_client);

            $_client_manager->setFlash('success', 'Client supprimé');
        }

        return $this->redirectToRoute('client_index');
    }

    /**
     * Création formulaire de suppression client
     * @param DevClient $_client The DevClient entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevClient $_client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $_client->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste client
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_client_manager = $this->get(ServiceName::SRV_METIER_CLIENT);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_client_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('client_index'));
            }
            $_client_manager->deleteGroupDevClient($_ids);
        }

        $_client_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('client_index'));
    }
}