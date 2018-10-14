<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevPortfolioTypeType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolioType;

/**
 * Class DevPortfolioController
 */
class DevPortfolioTypeController extends Controller
{
    /**
     * Afficher tout les portfolio_types
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);

        // Récupérer tout les portfolio_type
        $_portfolio_types = $_portfolio_type_manager->getAllDevPortfolioType();

        return $this->render('AdminBundle:DevPortfolioType:index.html.twig', array(
            'portfolio_types' => $_portfolio_types
        ));
    }

    /**
     * Affichage page modification portfolio_type
     * @param DevPortfolioType $_portfolio_type
     * @return Render page
     */
    public function editAction(DevPortfolioType $_portfolio_type)
    {
        if (!$_portfolio_type) {
            throw $this->createNotFoundException('Unable to find DevPortfolioType entity.');
        }

        $_edit_form = $this->createEditForm($_portfolio_type);

        return $this->render('AdminBundle:DevPortfolioType:edit.html.twig', array(
            'portfolio_type' => $_portfolio_type,
            'edit_form'      => $_edit_form->createView()
        ));
    }

    /**
     * Création portfolio_type
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);

        $_portfolio_type = new DevPortfolioType();
        $_form           = $this->createCreateForm($_portfolio_type);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement portfolio_type
            $_portfolio_type_manager->saveDevPortfolioType($_portfolio_type, 'new');

            $_portfolio_type_manager->setFlash('success', "Catégorie portfolio ajoutée");

            return $this->redirect($this->generateUrl('portfolio_type_index'));
        }

        return $this->render('AdminBundle:DevPortfolioType:add.html.twig', array(
            'portfolio_type' => $_portfolio_type,
            'form'           => $_form->createView(),
        ));
    }

    /**
     * Modification portfolio_type
     * @param Request $_request requête
     * @param DevPortfolioType $_portfolio_type
     * @return Render page
     */
    public function updateAction(Request $_request, DevPortfolioType $_portfolio_type)
    {
        // Récupérer manager
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);

        if (!$_portfolio_type) {
            throw $this->createNotFoundException('Unable to find DevPortfolioType entity.');
        }

        $_edit_form = $this->createEditForm($_portfolio_type);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_portfolio_type_manager->saveDevPortfolioType($_portfolio_type, 'update');

            $_portfolio_type_manager->setFlash('success', "Catégorie portfolio modifiée");

            return $this->redirect($this->generateUrl('portfolio_type_index'));
        }

        return $this->render('AdminBundle:DevPortfolioType:edit.html.twig', array(
            'portfolio_type' => $_portfolio_type,
            'edit_form'      => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition portfolio_type
     * @param DevPortfolioType $_portfolio_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevPortfolioType $_portfolio_type)
    {
        $_form = $this->createForm(DevPortfolioTypeType::class, $_portfolio_type, array(
            'action' => $this->generateUrl('portfolio_type_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création portfolio_type
     * @param DevPortfolioType $_portfolio_type The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevPortfolioType $_portfolio_type)
    {
        $_form = $this->createForm(DevPortfolioTypeType::class, $_portfolio_type, array(
            'action' => $this->generateUrl('portfolio_type_update', array('id' => $_portfolio_type->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression portfolio_type
     * @param Request $_request requête
     * @param DevPortfolioType $_portfolio_type
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevPortfolioType $_portfolio_type)
    {
        // Récupérer manager
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);

        $_form = $this->createDeleteForm($_portfolio_type);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression portfolio_type
            $_portfolio_type_manager->deleteDevPortfolioType($_portfolio_type);

            $_portfolio_type_manager->setFlash('success', 'Catégorie portfolio supprimée');
        }

        return $this->redirectToRoute('portfolio_type_index');
    }

    /**
     * Création formulaire de suppression portfolio_type
     * @param DevPortfolioType $_portfolio_type The DevPortfolioType entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevPortfolioType $_portfolio_type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('portfolio_type_delete', array('id' => $_portfolio_type->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste portfolio_type
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_portfolio_type_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('portfolio_type_index'));
            }
            $_portfolio_type_manager->deleteGroupDevPortfolioType($_ids);
        }

        $_portfolio_type_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('portfolio_type_index'));
    }
}