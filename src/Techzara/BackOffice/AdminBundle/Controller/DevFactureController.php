<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevFactureType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevFacture;

/**
 * Class DevFactureController
 */
class DevFactureController extends Controller
{
    /**
     * Afficher tout les factures
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        // Récupérer tout les facture
        $_factures = $_facture_manager->getAllDevFacture();

        return $this->render('AdminBundle:DevFacture:index.html.twig', array(
            'factures' => $_factures
        ));
    }

    /**
     * Affichage page modification facture
     * @param DevFacture $_facture
     * @return Render page
     */
    public function editAction(DevFacture $_facture)
    {
        if (!$_facture) {
            throw $this->createNotFoundException('Unable to find DevFacture entity.');
        }

        $_edit_form = $this->createEditForm($_facture);

        return $this->render('AdminBundle:DevFacture:edit.html.twig', array(
            'facture'   => $_facture,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création facture
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        $_facture = new DevFacture();
        $_form    = $this->createCreateForm($_facture);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement facture
            $_facture_manager->saveDevFacture($_facture, 'new');

            $_facture_manager->setFlash('success', "Facture ajouté");

            return $this->redirect($this->generateUrl('facture_index'));
        }

        return $this->render('AdminBundle:DevFacture:add.html.twig', array(
            'facture' => $_facture,
            'form'    => $_form->createView(),
        ));
    }

    /**
     * Modification facture
     * @param Request $_request requête
     * @param DevFacture $_facture
     * @return Render page
     */
    public function updateAction(Request $_request, DevFacture $_facture)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        if (!$_facture) {
            throw $this->createNotFoundException('Unable to find DevFacture entity.');
        }

        $_edit_form = $this->createEditForm($_facture);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_facture_manager->saveDevFacture($_facture, 'update');

            $_facture_manager->setFlash('success', "Facture modifié");

            return $this->redirect($this->generateUrl('facture_index'));
        }

        return $this->render('AdminBundle:DevFacture:edit.html.twig', array(
            'facture'   => $_facture,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition facture
     * @param DevFacture $_facture The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevFacture $_facture)
    {
        $_form = $this->createForm(DevFactureType::class, $_facture, array(
            'action' => $this->generateUrl('facture_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création facture
     * @param DevFacture $_facture The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevFacture $_facture)
    {
        $_form = $this->createForm(DevFactureType::class, $_facture, array(
            'action' => $this->generateUrl('facture_update', array('id' => $_facture->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression facture
     * @param Request $_request requête
     * @param DevFacture $_facture
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevFacture $_facture)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        $_form = $this->createDeleteForm($_facture);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression facture
            $_facture_manager->deleteDevFacture($_facture);

            $_facture_manager->setFlash('success', 'Facture supprimé');
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Création formulaire de suppression facture
     * @param DevFacture $_facture The DevFacture entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevFacture $_facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $_facture->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste facture
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_facture_manager = $this->get(ServiceName::SRV_METIER_FACTURE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_facture_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('facture_index'));
            }
            $_facture_manager->deleteGroupDevFacture($_ids);
        }

        $_facture_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('facture_index'));
    }
}