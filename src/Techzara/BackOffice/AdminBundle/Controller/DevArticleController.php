<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;
use App\Techzara\Service\MetierManagerBundle\Entity\DevArticle;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class DevArticleController
 * @package App\Techzara\BackOffice\AdminBundle\Controller
 */
class DevArticleController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $article_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);
        $article_liste = $article_manager->getAllArticle();

        return $this->render('AdminBundle:DevArticle:index.html.twig',array(
            'articles' => $article_liste,
        ));
    }

    /**
     * Création utilisateur
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);

        $article = new DevArticle();
        $_form = $this->createCreateForm($article);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement utilisateur
            $_user_manager->addArticle($article, $_form);

            $_user_manager->setFlash('success', "Utilisateur ajouté");

            return $this->redirect($this->generateUrl('article_index'));
        }

        return $this->render('AdminBundle:DevArticle:add.html.twig', array(
            'article' => $article,
            'form' => $_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition utilisateur
     * @param Article $article The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevArticle $article)
    {
        $_form = $this->createForm(\App\Techzara\Service\MetierManagerBundle\Form\DevArticle::class, $article, array(
            'action'    => $this->generateUrl('article_new'),
            'method'    => 'POST',
        ));

        return $_form;
    }

    /*
     * Modification
     */

    /**
     * Affichage page modification cms
     * @param DevArticle $article
     * @return Render page
     */
    public function editAction(DevArticle $article)
    {
        if (!$article) {
            throw $this->createNotFoundException('Unable to find DevCms entity.');
        }

        $_edit_form = $this->createEditForm($article);

        return $this->render('AdminBundle:DevArticle:edit.html.twig', array(
            'articles'       => $article,
            'edit_form' => $_edit_form->createView()
        ));
    }


    /**
     * Modification cms
     * @param Request $_request requête
     * @param DevArticle $_cms
     * @return Render page
     */
    public function updateAction(Request $_request, DevArticle $article)
    {
        // Récupérer manager
        // Récupérer manager
        $_art_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find article entity.');
        }

        $_edit_form = $this->createEditForm($article);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Mise à jour utilisateur
            $_art_manager->updateArticle($article, $_edit_form);

            $_art_manager->setFlash('success', "Utilisateur modifié");

            return $this->redirect($this->generateUrl('article_index'));
        }


        return $this->render('AdminBundle:DevArticle:edit.html.twig', array(
            'article'      => $article,
            'edit_form' => $_edit_form->createView()
        ));

    }


    /**
     * Création formulaire de création cms
     * @param DevArticle $article The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevArticle $article)
    {
        $_form = $this->createForm(\App\Techzara\Service\MetierManagerBundle\Form\DevArticle::class, $article, array(
            'action' => $this->generateUrl('article_update', array('id' => $article->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    public function deleteAction(Request $request , DevArticle $article)
    {
        $_art_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);

        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($request->isMethod('GET') || ($form->isSubmited() && $form->isValid())){
            $_art_manager->deleteDevArticle($article);
            $_art_manager->setFlash('success','Article supprimé');
        }

        return $this->redirectToRoute('article_index');
    }

    public function createDeleteForm(DevArticle $article)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete',array('id'=>$article->getId())))
            ->setMethod('DELETE')
            ->getForm();

    }
    /**
     * Ajax suppression fichier image utilisateur
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteImageAjaxAction(Request $_request) {
        // Récupérer manager
        $_user_upload_manager = $this->get(ServiceName::SRV_METIER_ARTICLE_UPLOAD);

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
     * @return Redirect article_liste
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_article_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_article_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('article_index'));
            }
            $_article_manager->deleteDevArticleGroup($_ids);
        }

        $_article_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('article_index'));
    }

}