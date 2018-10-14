<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Entity\DevNews;
use App\Techzara\Service\MetierManagerBundle\Form\DevNewsType;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DevCmsController
 */
class DevNewsController extends Controller
{
    /**
     * Afficher tout les cmss
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        // Récupérer tout les cms
        $_cmss = $_cms_manager->getAllDevCms();

        return $this->render('AdminBundle:DevNews:index.html.twig', array(
            'cmss' => $_cmss
        ));
    }

    /**
     * Affichage page modification cms
     * @param DevCms $_cms
     * @return Render page
     */
    public function editAction(DevNews $_cms)
    {
        if (!$_cms) {
            throw $this->createNotFoundException('Unable to find DevCms entity.');
        }

        $_edit_form = $this->createEditForm($_cms);

        return $this->render('AdminBundle:DevNews:edit.html.twig', array(
            'cms'       => $_cms,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création cms
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        $_cms  = new DevNews();
        $_form = $this->createCreateForm($_cms);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement cms
            $news = $_cms_manager->saveDevCms($_cms, 'new');

            $_cms_manager->setFlash('success', "Contenu ajouté");

            return $this->redirect($this->generateUrl('news_index'));
        }

        return $this->render('AdminBundle:DevNews:add.html.twig', array(
            'cms'  => $_cms,
            'form' => $_form->createView()
        ));
    }

    /**
     * Modification cms
     * @param Request $_request requête
     * @param DevCms $_cms
     * @return Render page
     */
    public function updateAction(Request $_request, DevNews $_cms)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        if (!$_cms) {
            throw $this->createNotFoundException('Unable to find DevCms entity.');
        }

        $_edit_form = $this->createEditForm($_cms);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_cms_manager->saveDevCms($_cms, 'update');

            $_cms_manager->setFlash('success', "Contenu modifié");

            return $this->redirect($this->generateUrl('news_index'));
        }

        return $this->render('AdminBundle:DevNews:edit.html.twig', array(
            'cms'       => $_cms,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition cms
     * @param DevCms $_cms The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevNews $_cms)
    {
        $_form = $this->createForm(DevNewsType::class, $_cms, array(
            'action' => $this->generateUrl('news_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création cms
     * @param DevNews $_cms The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevNews $_cms)
    {
        $_form = $this->createForm(DevNewsType::class, $_cms, array(
            'action' => $this->generateUrl('news_update', array('id' => $_cms->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression cms
     * @param Request $_request requête
     * @param DevCms $_cms
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevNews $_cms)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        $_form = $this->createDeleteForm($_cms);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression cms
            $_cms_manager->deleteDevCms($_cms);

            $_cms_manager->setFlash('success', 'Contenu supprimé');
        }

        return $this->redirectToRoute('news_index');
    }

    /**
     * Création formulaire de suppression cms
     * @param DevCms $_cms The DevCms entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevNews $_cms)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_delete', array('id' => $_cms->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste cms
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_cms_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('news_index'));
            }
            $_cms_manager->deleteGroupDevCms($_ids);
        }

        $_cms_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('news_index'));
    }
}
