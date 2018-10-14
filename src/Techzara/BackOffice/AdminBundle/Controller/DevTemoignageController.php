<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevTemoignageType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevTemoignage;

/**
 * Class DevTemoignageController
 */
class DevTemoignageController extends Controller
{
    /**
     * Afficher tout les temoignages
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        // Récupérer tout les temoignage
        $_temoignages = $_temoignage_manager->getAllDevTemoignage();

        return $this->render('AdminBundle:DevTemoignage:index.html.twig', array(
            'temoignages' => $_temoignages
        ));
    }

    /**
     * Affichage page modification temoignage
     * @param DevTemoignage $_temoignage
     * @return Render page
     */
    public function editAction(DevTemoignage $_temoignage)
    {
        if (!$_temoignage) {
            throw $this->createNotFoundException('Unable to find DevTemoignage entity.');
        }

        $_edit_form = $this->createEditForm($_temoignage);

        return $this->render('AdminBundle:DevTemoignage:edit.html.twig', array(
            'temoignage' => $_temoignage,
            'edit_form'  => $_edit_form->createView()
        ));
    }

    /**
     * Création temoignage
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        $_temoignage = new DevTemoignage();
        $_form       = $this->createCreateForm($_temoignage);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement temoignage
            $_temoignage_manager->saveDevTemoignage($_temoignage, 'new');

            $_temoignage_manager->setFlash('success', "Témoignage ajouté");

            return $this->redirect($this->generateUrl('temoignage_index'));
        }

        return $this->render('AdminBundle:DevTemoignage:add.html.twig', array(
            'temoignage' => $_temoignage,
            'form'       => $_form->createView(),
        ));
    }

    /**
     * Modification temoignage
     * @param Request $_request requête
     * @param DevTemoignage $_temoignage
     * @return Render page
     */
    public function updateAction(Request $_request, DevTemoignage $_temoignage)
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        if (!$_temoignage) {
            throw $this->createNotFoundException('Unable to find DevTemoignage entity.');
        }

        $_edit_form = $this->createEditForm($_temoignage);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_temoignage_manager->saveDevTemoignage($_temoignage, 'update');

            $_temoignage_manager->setFlash('success', "Témoignage modifié");

            return $this->redirect($this->generateUrl('temoignage_index'));
        }

        return $this->render('AdminBundle:DevTemoignage:edit.html.twig', array(
            'temoignage' => $_temoignage,
            'edit_form'  => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition temoignage
     * @param DevTemoignage $_temoignage The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevTemoignage $_temoignage)
    {
        $_form = $this->createForm(DevTemoignageType::class, $_temoignage, array(
            'action' => $this->generateUrl('temoignage_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création temoignage
     * @param DevTemoignage $_temoignage The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevTemoignage $_temoignage)
    {
        $_form = $this->createForm(DevTemoignageType::class, $_temoignage, array(
            'action' => $this->generateUrl('temoignage_update', array('id' => $_temoignage->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression temoignage
     * @param Request $_request requête
     * @param DevTemoignage $_temoignage
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevTemoignage $_temoignage)
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        $_form = $this->createDeleteForm($_temoignage);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression temoignage
            $_temoignage_manager->deleteDevTemoignage($_temoignage);

            $_temoignage_manager->setFlash('success', 'Témoignage supprimé');
        }

        return $this->redirectToRoute('temoignage_index');
    }

    /**
     * Création formulaire de suppression temoignage
     * @param DevTemoignage $_temoignage The DevTemoignage entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevTemoignage $_temoignage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('temoignage_delete', array('id' => $_temoignage->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste temoignage
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_temoignage_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('temoignage_index'));
            }
            $_temoignage_manager->deleteGroupDevTemoignage($_ids);
        }

        $_temoignage_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('temoignage_index'));
    }
}