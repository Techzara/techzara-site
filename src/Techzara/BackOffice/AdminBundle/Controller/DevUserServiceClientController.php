<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient;
use App\Techzara\Service\MetierManagerBundle\Form\DevUserServiceClientType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevUserServiceClient;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class DevUserServiceClientController
 */
class DevUserServiceClientController extends Controller
{
    /**
     * Afficher tout les user_service_clients
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_user_service_client_manager = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);

        // Récupérer tout les user_service_client
        $_user_service_clients = $_user_service_client_manager->getAllDevUserServiceClient();

        return $this->render('AdminBundle:DevUserServiceClient:index.html.twig', array(
            'user_service_clients' => $_user_service_clients
        ));
    }

    /**
     * Affichage page modification user_service_client
     * @param DevUserServiceClient $_user_service_client
     * @return Render page
     */
    public function editAction(DevUserServiceClient $_user_service_client)
    {
        if (!$_user_service_client) {
            throw $this->createNotFoundException('Unable to find DevUserServiceClient entity.');
        }

        $_edit_form = $this->createEditForm($_user_service_client);

        return $this->render('AdminBundle:DevUserServiceClient:edit.html.twig', array(
            'user_service_client' => $_user_service_client,
            'edit_form'           => $_edit_form->createView()
        ));
    }

    /**
     * Création user_service_client
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_user_service_client_manager = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);

        $_user_service_client = new DevUserServiceClient();
        $_form                = $this->createCreateForm($_user_service_client);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement user_service_client
            $_user_service_client_manager->saveDevUserServiceClient($_user_service_client, 'new');

            $_user_service_client_manager->setFlash('success', "Attribution service ajoutée");

            return $this->redirect($this->generateUrl('user_service_client_index'));
        }

        return $this->render('AdminBundle:DevUserServiceClient:add.html.twig', array(
            'user_service_client' => $_user_service_client,
            'form'                => $_form->createView(),
        ));
    }

    /**
     * Modification user_service_client
     * @param Request $_request requête
     * @param DevUserServiceClient $_user_service_client
     * @return Render page
     */
    public function updateAction(Request $_request, DevUserServiceClient $_user_service_client)
    {
        // Récupérer manager
        $_user_service_client_manager = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);

        if (!$_user_service_client) {
            throw $this->createNotFoundException('Unable to find DevUserServiceClient entity.');
        }

        $_edit_form = $this->createEditForm($_user_service_client);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_user_service_client_manager->saveDevUserServiceClient($_user_service_client, 'update');

            $_user_service_client_manager->setFlash('success', "Attribution service modifiée");

            return $this->redirect($this->generateUrl('user_service_client_index'));
        }

        return $this->render('AdminBundle:DevUserServiceClient:edit.html.twig', array(
            'user_service_client' => $_user_service_client,
            'edit_form'           => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition user_service_client
     * @param DevUserServiceClient $_user_service_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevUserServiceClient $_user_service_client)
    {
        $_form = $this->createForm(DevUserServiceClientType::class, $_user_service_client, array(
            'action'      => $this->generateUrl('user_service_client_new'),
            'method'      => 'POST',
            'type_action' => 'create'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création user_service_client
     * @param DevUserServiceClient $_user_service_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevUserServiceClient $_user_service_client)
    {
        $_form = $this->createForm(DevUserServiceClientType::class, $_user_service_client, array(
            'action'      => $this->generateUrl('user_service_client_update', array('id' => $_user_service_client->getId())),
            'method'      => 'PUT',
            'type_action' => 'edit'
        ));

        return $_form;
    }

    /**
     * Suppression user_service_client
     * @param Request $_request requête
     * @param DevUserServiceClient $_user_service_client
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevUserServiceClient $_user_service_client)
    {
        // Récupérer manager
        $_user_service_client_manager = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);

        $_form = $this->createDeleteForm($_user_service_client);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression user_service_client
            $_user_service_client_manager->deleteDevUserServiceClient($_user_service_client);

            $_user_service_client_manager->setFlash('success', 'Attribution service supprimée');
        }

        return $this->redirectToRoute('user_service_client_index');
    }

    /**
     * Création formulaire de suppression user_service_client
     * @param DevUserServiceClient $_user_service_client The DevUserServiceClient entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevUserServiceClient $_user_service_client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_service_client_delete', array('id' => $_user_service_client->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste user_service_client
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_user_service_client_manager = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_user_service_client_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('user_service_client_index'));
            }
            $_user_service_client_manager->deleteGroupDevUserServiceClient($_ids);
        }

        $_user_service_client_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('user_service_client_index'));
    }

    /**
     * Mettre à jour le statut projet du service
     * @param DevServiceClient $_service_client
     * @param int $_status
     * @return Render page
     */
    public function updateStatusProjectAction(DevServiceClient $_service_client, $_status)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        $_service_client_manager->setStatusProjectService($_service_client, $_status);

        $_service_client_manager->setFlash('success', 'Statut projet modifié');

        return $this->redirect($this->generateUrl('user_service_client_index'));
    }

    /**
     * Afficher la page détail
     * @param DevUserServiceClient $_user_service_client
     * @return Render page
     */
    public function detailAction(DevUserServiceClient $_user_service_client)
    {
        // Récupérer manager
        $_user_service_client_manager   = $this->get(ServiceName::SRV_METIER_USER_SERVICE_CLIENT);
        $_service_client_jointe_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->get('security.token_storage')->getToken()->getUser();
        $_id_user        = $_user_connected->getId();

        $_service_client = $_user_service_client->getLvServiceClient();

        // Vérification utilisateur
        $_id_user_service_client = $_user_service_client->getId();
        $_is_user_attributed     = $_user_service_client_manager->isUserAttributed($_id_user_service_client, $_id_user);
        if (!$_is_user_attributed) {
            throw new AccessDeniedException('Vous ne pouvez pas faire cette action !');
        }

        // Récupérer le pièce jointe
        $_id_service_client     = $_service_client->getId();
        $_service_client_jointe = $_service_client_jointe_manager->getLvServiceClientJointeByServiceClient($_id_service_client);

        return $this->render('AdminBundle:DevUserServiceClient:detail.html.twig', array(
            'service_client'        => $_service_client,
            'service_client_jointe' => $_service_client_jointe
        ));
    }
}