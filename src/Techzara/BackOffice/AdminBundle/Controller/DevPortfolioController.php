<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevPortfolioType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolio;

/**
 * Class DevPortfolioController
 */
class DevPortfolioController extends Controller
{
    /**
     * Afficher tout les portfolios
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_portfolio_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO);

        // Récupérer tout les portfolio
        $_portfolios = $_portfolio_manager->getAllDevPortfolio();

        return $this->render('AdminBundle:DevPortfolio:index.html.twig', array(
            'portfolios' => $_portfolios
        ));
    }

    /**
     * Affichage page modification portfolio
     * @param DevPortfolio $_portfolio
     * @return Render page
     */
    public function editAction(DevPortfolio $_portfolio)
    {
        if (!$_portfolio) {
            throw $this->createNotFoundException('Unable to find DevPortfolio entity.');
        }

        $_edit_form = $this->createEditForm($_portfolio);

        return $this->render('AdminBundle:DevPortfolio:edit.html.twig', array(
            'portfolio' => $_portfolio,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création portfolio
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_portfolio_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO);

        $_portfolio = new DevPortfolio();
        $_form      = $this->createCreateForm($_portfolio);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Traitement image
            $_image = $_form['pfImageUrl']->getData();

            // Enregistrement portfolio
            $_portfolio_manager->addPortfolio($_portfolio, $_image);

            $_portfolio_manager->setFlash('success', "Portfolio ajouté");

            return $this->redirect($this->generateUrl('portfolio_index'));
        }

        return $this->render('AdminBundle:DevPortfolio:add.html.twig', array(
            'portfolio' => $_portfolio,
            'form'      => $_form->createView(),
        ));
    }

    /**
     * Modification portfolio
     * @param Request $_request requête
     * @param DevPortfolio $_portfolio
     * @return Render page
     */
    public function updateAction(Request $_request, DevPortfolio $_portfolio)
    {
        // Récupérer manager
        $_portfolio_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO);

        if (!$_portfolio) {
            throw $this->createNotFoundException('Unable to find DevPortfolio entity.');
        }

        $_edit_form = $this->createEditForm($_portfolio);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Traitement image
            $_image = $_edit_form['pfImageUrl']->getData();

            // Enregistrement portfolio
            $_portfolio_manager->updatePortfolio($_portfolio, $_image);

            $_portfolio_manager->setFlash('success', "Portfolio modifié");

            return $this->redirect($this->generateUrl('portfolio_index'));
        }

        return $this->render('AdminBundle:DevPortfolio:edit.html.twig', array(
            'portfolio' => $_portfolio,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition portfolio
     * @param DevPortfolio $_portfolio The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevPortfolio $_portfolio)
    {
        $_form = $this->createForm(DevPortfolioType::class, $_portfolio, array(
            'action' => $this->generateUrl('portfolio_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création portfolio
     * @param DevPortfolio $_portfolio The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevPortfolio $_portfolio)
    {
        $_form = $this->createForm(DevPortfolioType::class, $_portfolio, array(
            'action' => $this->generateUrl('portfolio_update', array('id' => $_portfolio->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression portfolio
     * @param Request $_request requête
     * @param DevPortfolio $_portfolio
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevPortfolio $_portfolio)
    {
        // Récupérer manager
        $_portfolio_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO);

        $_form = $this->createDeleteForm($_portfolio);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression portfolio
            $_portfolio_manager->deleteDevPortfolio($_portfolio);

            $_portfolio_manager->setFlash('success', 'Portfolio supprimé');
        }

        return $this->redirectToRoute('portfolio_index');
    }

    /**
     * Création formulaire de suppression portfolio
     * @param DevPortfolio $_portfolio The DevPortfolio entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevPortfolio $_portfolio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('portfolio_delete', array('id' => $_portfolio->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste portfolio
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_portfolio_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_portfolio_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('portfolio_index'));
            }
            $_portfolio_manager->deleteGroupDevPortfolio($_ids);
        }

        $_portfolio_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('portfolio_index'));
    }
}