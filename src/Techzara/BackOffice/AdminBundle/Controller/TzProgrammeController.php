<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Entity\TzProgramme;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class TzProgrammeController
 * @package App\Techzara\BackOffice\AdminBundle\Controller
 */
class TzProgrammeController extends Controller
{
    /**
     * Afficher tout les emails
     * @return render page
     */
    public function indexAction()
    {
        $_programme_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);
        $_programme_liste = $_programme_manager->getAllProgramme();

        return $this->render('@Admin/TzProgramme/index.html.twig',array(
            'programmes' => $_programme_liste,
        ));

    }

    /**
     * Création programme
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_programme_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);

        $_programme = new TzProgramme();
        $_form = $this->createCreateForm($_programme);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement utilisateur
            $_programme_manager->addProgramme($_programme, $_form);

            $_programme_manager->setFlash('success', "Programme ajouté");

            return $this->redirect($this->generateUrl('programme_liste'));
        } else {
            var_dump($_form->getErrors());
            die('misy erreur');
        }

        return $this->render('AdminBundle:TzProgramme:add.html.twig', array(
            'programme' => $_programme,
            'form' => $_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition utilisateur
     * @param TzProgramme $_programme The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TzProgramme $_programme)
    {
        $_form = $this->createForm(\App\Techzara\Service\MetierManagerBundle\Form\TzProgramme::class, $_programme, array(
            'action'    => $this->generateUrl('programme_new'),
            'method'    => 'POST',
        ));

        return $_form;
    }

    /*
     * Modification
     */

    /**
     * Affichage page modification cms
     * @param TzProgramme $_programme
     * @return Render page
     */
    public function editAction(TzProgramme $_programme)
    {
        if (!$_programme) {
            throw $this->createNotFoundException('Unable to find TzProgramme entity.');
        }

        $_edit_form = $this->createEditForm($_programme);

        return $this->render('AdminBundle:TzProgramme:edit.html.twig', array(
            'programmes'        => $_programme,
            'edit_form'         => $_edit_form->createView()
        ));
    }


    /**
     * Modification cms
     * @param Request $_request requête
     * @param TzProgramme $_cms
     * @return Render page
     */
    public function updateAction(Request $_request, TzProgramme $_programme)
    {
        // Récupérer manager
        // Récupérer manager
        $_art_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);

        if (!$_programme) {
            throw $this->createNotFoundException('Unable to find programme entity.');
        }

        $_edit_form = $this->createEditForm($_programme);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Mise à jour utilisateur
            $_art_manager->updateProgramme($_programme, $_edit_form);

            $_art_manager->setFlash('success', "Programme modifié");

            return $this->redirect($this->generateUrl('programme_liste'));
        }


        return $this->render('AdminBundle:TzProgramme:edit.html.twig', array(
            'programme'      => $_programme,
            'edit_form' => $_edit_form->createView()
        ));

    }


    /**
     * Création formulaire de création cms
     * @param TzProgramme $_programme The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TzProgramme $_programme)
    {
        $_form = $this->createForm(\App\Techzara\Service\MetierManagerBundle\Form\TzProgramme::class, $_programme, array(
            'action' => $this->generateUrl('programme_update', array('id' => $_programme->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    public function deleteAction(Request $request , TzProgramme $_programme)
    {
        $_art_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);

        $form = $this->createDeleteForm($_programme);
        $form->handleRequest($request);

        if ($request->isMethod('GET') || ($form->isSubmited() && $form->isValid())){
            $_art_manager->deleteTzProgramme($_programme);
            $_art_manager->setFlash('success','Programme supprimé');
        }

        return $this->redirectToRoute('programme_liste');
    }

    public function createDeleteForm(TzProgramme $_programme)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('programme_delete',array('id'=>$_programme->getId())))
            ->setMethod('DELETE')
            ->getForm();

    }
    /**
     * Ajax suppression fichier image du programme
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteImageAjaxAction(Request $_request) {
        // Récupérer manager
        $_user_upload_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME_UPLOAD);

        // Récuperation identifiant fichier
        $_data = $_request->request->all();
        $_id   = $_data['id'];

        // Suppression fichier image
        $_response = $_user_upload_manager->deleteImageById($_id);

        return new JsonResponse($_response);
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect programme_liste
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_programme_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_programme_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('programme_liste'));
            }
            $_programme_manager->deleteTzProgrammeGroup($_ids);
        }

        $_programme_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('programme_liste'));
    }

}