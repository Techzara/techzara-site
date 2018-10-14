<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Entity\DevFaq;
use App\Techzara\Service\MetierManagerBundle\Form\DevFaqType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DevFaqController
 */
class DevFaqController extends Controller
{
    /**
     * Afficher tout les faqs
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_faq_manager = $this->get(ServiceName::SRV_METIER_FAQ);

        // Récupérer tout les faq
        $_faqs = $_faq_manager->getAllDevFaq();

        return $this->render('AdminBundle:DevFaq:index.html.twig', array(
            'faqs' => $_faqs
        ));
    }

    /**
     * Affichage page modification faq
     * @param DevFaq $_faq
     * @return Render page
     */
    public function editAction(DevFaq $_faq)
    {
        if (!$_faq) {
            throw $this->createNotFoundException('Unable to find DevFaq entity.');
        }

        $_edit_form = $this->createEditForm($_faq);

        return $this->render('AdminBundle:DevFaq:edit.html.twig', array(
            'faq'       => $_faq,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création faq
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_faq_manager = $this->get(ServiceName::SRV_METIER_FAQ);

        $_faq  = new DevFaq();
        $_form = $this->createCreateForm($_faq);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement faq
            $_faq_manager->saveDevFaq($_faq, 'new');

            $_faq_manager->setFlash('success', "FAQ ajouté");

            return $this->redirect($this->generateUrl('faq_index'));
        }

        return $this->render('AdminBundle:DevFaq:add.html.twig', array(
            'faq'  => $_faq,
            'form' => $_form->createView()
        ));
    }

    /**
     * Modification faq
     * @param Request $_request requête
     * @param DevFaq $_faq
     * @return Render page
     */
    public function updateAction(Request $_request, DevFaq $_faq)
    {
        // Récupérer manager
        $_faq_manager = $this->get(ServiceName::SRV_METIER_FAQ);

        if (!$_faq) {
            throw $this->createNotFoundException('Unable to find DevFaq entity.');
        }

        $_edit_form = $this->createEditForm($_faq);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_faq_manager->saveDevFaq($_faq, 'update');

            $_faq_manager->setFlash('success', "FAQ modifié");

            return $this->redirect($this->generateUrl('faq_index'));
        }

        return $this->render('AdminBundle:DevFaq:edit.html.twig', array(
            'faq'       => $_faq,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition faq
     * @param DevFaq $_faq The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevFaq $_faq)
    {
        $_form = $this->createForm(DevFaqType::class, $_faq, array(
            'action' => $this->generateUrl('faq_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création faq
     * @param DevFaq $_faq The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevFaq $_faq)
    {
        $_form = $this->createForm(DevFaqType::class, $_faq, array(
            'action' => $this->generateUrl('faq_update', array('id' => $_faq->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }

    /**
     * Suppression faq
     * @param Request $_request requête
     * @param DevFaq $_faq
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevFaq $_faq)
    {
        // Récupérer manager
        $_faq_manager = $this->get(ServiceName::SRV_METIER_FAQ);

        $_form = $this->createDeleteForm($_faq);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression faq
            $_faq_manager->deleteDevFaq($_faq);

            $_faq_manager->setFlash('success', 'FAQ supprimé');
        }

        return $this->redirectToRoute('faq_index');
    }

    /**
     * Création formulaire de suppression faq
     * @param DevFaq $_faq The DevFaq entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevFaq $_faq)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('faq_delete', array('id' => $_faq->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste faq
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_faq_manager = $this->get(ServiceName::SRV_METIER_FAQ);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_faq_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('faq_index'));
            }
            $_faq_manager->deleteGroupDevFaq($_ids);
        }

        $_faq_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('faq_index'));
    }
}
