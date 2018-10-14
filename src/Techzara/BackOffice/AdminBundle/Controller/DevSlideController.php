<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevSlideType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevSlide;

/**
 * Class DevSlideController
 */
class DevSlideController extends Controller
{
    /**
     * Afficher tout les slides
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        // Récupérer tout les slide
        $_slides = $_slide_manager->getAllDevSlide();

        return $this->render('AdminBundle:DevSlide:index.html.twig', array(
            'slides' => $_slides
        ));
    }

    /**
     * Affichage page modification slide
     * @param DevSlide $_slide
     * @return Render page
     */
    public function editAction(DevSlide $_slide)
    {
        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find DevSlide entity.');
        }

        $_edit_form = $this->createEditForm($_slide);

        return $this->render('AdminBundle:DevSlide:edit.html.twig', array(
            'slide'     => $_slide,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création slide
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_slide = new DevSlide();
        $_form  = $this->createCreateForm($_slide);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Traitement image
            $_image = $_form['sldImageUrl']->getData();

            // Enregistrement slide
            $_slide_manager->addSlide($_slide, $_image);

            $_slide_manager->setFlash('success', "Slide ajouté");

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:DevSlide:add.html.twig', array(
            'slide' => $_slide,
            'form'  => $_form->createView(),
        ));
    }

    /**
     * Modification slide
     * @param Request $_request requête
     * @param DevSlide $_slide
     * @return Render page
     */
    public function updateAction(Request $_request, DevSlide $_slide)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        if (!$_slide) {
            throw $this->createNotFoundException('Unable to find DevSlide entity.');
        }

        $_edit_form = $this->createEditForm($_slide);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Traitement image
            $_image = $_edit_form['sldImageUrl']->getData();

            // Enregistrement slide
            $_slide_manager->updateSlide($_slide, $_image);

            $_slide_manager->setFlash('success', "Slide modifié");

            return $this->redirect($this->generateUrl('slide_index'));
        }

        return $this->render('AdminBundle:DevSlide:edit.html.twig', array(
            'slide'     => $_slide,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition slide
     * @param DevSlide $_slide The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevSlide $_slide)
    {
        $_form = $this->createForm(DevSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création slide
     * @param DevSlide $_slide The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevSlide $_slide)
    {
        $_form = $this->createForm(DevSlideType::class, $_slide, array(
            'action' => $this->generateUrl('slide_update', array('id' => $_slide->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression slide
     * @param Request $_request requête
     * @param DevSlide $_slide
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevSlide $_slide)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_form = $this->createDeleteForm($_slide);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression slide
            $_slide_manager->deleteDevSlide($_slide);

            $_slide_manager->setFlash('success', 'Slide supprimé');
        }

        return $this->redirectToRoute('slide_index');
    }

    /**
     * Création formulaire de suppression slide
     * @param DevSlide $_slide The DevSlide entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevSlide $_slide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slide_delete', array('id' => $_slide->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste slide
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_slide_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('slide_index'));
            }
            $_slide_manager->deleteGroupDevSlide($_ids);
        }

        $_slide_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('slide_index'));
    }
}