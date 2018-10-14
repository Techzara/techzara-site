<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevPortfolio;

use App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolio;
use App\Techzara\Service\MetierManagerBundle\Utils\PathName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceMetierDevPortfolio
{
    private $_entity_manager;
    private $_container;
    private $_web_root;

    public function __construct(EntityManager $_entity_manager, Container $_container, $_root_dir)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
        $this->_web_root       = realpath($_root_dir . '/../public');
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

    /**
     * Récuperer le repository portfolio
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_PORTFOLIO);
    }

    /**
     * Récuperer tout les portfolios
     * @return array
     */
    public function getAllDevPortfolio()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les portfolios
     * @return array
     */
    public function getAllDevPortfolioOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un portfolio par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevPortfolioById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un portfolio
     * @param DevPortfolio $_portfolio
     * @param string $_action
     * @return boolean
     */
    public function saveDevPortfolio($_portfolio, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_portfolio);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Ajout portfolio
     * @param DevPortfolio $_portfolio
     * @param Object $_image
     * @return boolean
     */
    public function addPortfolio($_portfolio, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_portfolio);
            $this->addImage($_portfolio, $_image);
        }

        $this->saveDevPortfolio($_portfolio, 'new');
    }

    /**
     * Modification portfolio
     * @param DevPortfolio $_portfolio
     * @param Object $_image
     * @return boolean
     */
    public function updatePortfolio($_portfolio, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_portfolio);
            $this->addImage($_portfolio, $_image);
        }

        $this->saveDevPortfolio($_portfolio, 'update');
    }

    /**
     * Supprimer un portfolio
     * @param DevPortfolio $_portfolio
     * @return boolean
     */
    public function deleteDevPortfolio($_portfolio)
    {
        $this->deleteImage($_portfolio);

        $this->_entity_manager->remove($_portfolio);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un portfolio
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevPortfolio($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_portfolio = $this->getDevPortfolioById($_id);
                $this->deleteDevPortfolio($_portfolio);
                $this->deleteImage($_portfolio);
            }
        }

        return true;
    }

    /**
     * Ajout image
     * @param DevPortfolio $_portfolio
     * @param object $_image
     */
    public function addImage($_portfolio, $_image) {
        // Récupérer le répertoire image spécifique
        $_directory_image  = PathName::UPLOAD_PORTFOLIO;

        try {
            // Upload image
            $_file_name_image = md5(uniqid()) . '.' . $_image->guessExtension();
            $_uri_file        = $_directory_image . $_file_name_image;
            $_dir             = $this->_web_root . $_directory_image;
            $_image->move(
                $_dir,
                $_file_name_image
            );

            // Enregistrement image
            $_portfolio->setPfImageUrl($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité)
     * @param DevPortfolio $_portfolio
     * @return array
     */
    public function deleteImage($_portfolio)
    {
        if ($_portfolio) {
            try {
                $_path = $this->_web_root.$_portfolio->getPfImageUrl();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_portfolio);
                $this->_entity_manager->flush();

                return array(
                    'success' => true
                );
            } catch (\Exception $_exc) {
                return array(
                    'success' => false,
                    'message' => $_exc->getTraceAsString()
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => 'Image not found in database'
            );
        }
    }

    /**
     * Suppression image (uniquement le fichier)
     * @param DevPortfolio $_portfolio
     * @return array
     */
    public function deleteOnlyImage($_portfolio)
    {
        if ($_portfolio) {
            $_path = $this->_web_root . $_portfolio->getPfImageUrl();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}