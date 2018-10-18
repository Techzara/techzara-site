<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 11:27 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Metier\TzArticle;

use App\Techzara\Service\MetierManagerBundle\Entity\TzArticle;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierTzArticle
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Ajouter un message flash
     * @param string $_type
     * @param string $_message
     * @return mixed
     */
    public function setFlash($_type, $_message) {
        return $this->_container->get('session')->getFlashBag()->add($_type, $_message);
    }


    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::ARTICLE);
    }


    public function getAllArticle()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    public function getAllArticleById($_id)
    {
        return $this->getRepository()->find($_id);
    }



    /**
     * Ajouter un utilisateur
     * @param Article $article
     * @param Object $_form
     * @return boolean
     */
    public function addArticle($article, $_form) {

        // Traitement du photo
        $_img_photo = $_form['artphoto']->getData();
        if ($_img_photo) {
            $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_ARTICLE_UPLOAD);
            $_user_upload_manager->upload($article, $_img_photo);
        }

        $this->saveArticle($article, 'new');
    }


    /**
     * Enregistrer un utilisateur
     * @param Article $article
     * @param string $_action
     * @return boolean
     */
    public function saveArticle($article, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($article);
        }
        $this->_entity_manager->flush();

        return $article;
    }


    /**
     * Modifier un utilisateur
     * @param TzArticle $article
     * @param Object $_form
     * @return boolean
     */
    public function updateArticle($article, $_form) {
        // Traitement photo
        $_img_photo = $_form['artphoto']->getData();
        // S'il y a un nouveau fichier ajouté, on supprime l'ancien fichier puis on enregistre ce nouveau
        if ($_img_photo) {
            $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_ARTICLE_UPLOAD);
            $_user_upload_manager->deleteOnlyImageById($article->getId());
            $_user_upload_manager->upload($article, $_img_photo);
        }


        $article->setArtDate(new \DateTime());


        $this->saveArticle($article, 'update');
    }

    /**
     * Supprimer un utilisateur
     * @param TzArticle $article
     * @return boolean
     */
    public function deleteTzArticle($article)
    {
        $this->_entity_manager->remove($article);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un utilisateur
     * @param array $_ids
     * @return boolean
     */
    public function deleteTzArticleGroup($_ids)
    {
        $_art_imaege_manager = $this->_container->get(ServiceName::SRV_METIER_ARTICLE_UPLOAD);

        if (count($_ids)) {
            foreach ($_ids as $_id) {
                // Suppression fichier image
                $_art_imaege_manager->deleteImageById($_id);

                // Suppression utilisateur
                $article = $this->getAllArticleByID($_id);
                $this->deleteTzArticle($article);
            }
        }

        return true;
    }


}