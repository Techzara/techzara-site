<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevSlide;

use App\Techzara\Service\MetierManagerBundle\Entity\DevSlide;
use App\Techzara\Service\MetierManagerBundle\Utils\PathName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceMetierDevSlide
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
     * Récuperer le repository slide
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SLIDE);
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllDevSlide()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les slides
     * @return array
     */
    public function getAllDevSlideOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un slide par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevSlideById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un slide
     * @param DevSlide $_slide
     * @param string $_action
     * @return boolean
     */
    public function saveDevSlide($_slide, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_slide);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Ajout slide
     * @param DevSlide $_slide
     * @param Object $_image
     * @return boolean
     */
    public function addSlide($_slide, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_slide);
            $this->addImage($_slide, $_image);
        }

        $this->saveDevSlide($_slide, 'new');
    }

    /**
     * Modification slide
     * @param DevSlide $_slide
     * @param Object $_image
     * @return boolean
     */
    public function updateSlide($_slide, $_image)
    {
        // S'il y a un nouveau image ajouté, on supprime l'ancien puis on enregistre ce nouveau
        if ($_image) {
            $this->deleteOnlyImage($_slide);
            $this->addImage($_slide, $_image);
        }

        $this->saveDevSlide($_slide, 'update');
    }

    /**
     * Supprimer un slide
     * @param DevSlide $_slide
     * @return boolean
     */
    public function deleteDevSlide($_slide)
    {
        $this->deleteImage($_slide);

        $this->_entity_manager->remove($_slide);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un slide
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevSlide($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_slide = $this->getDevSlideById($_id);
                $this->deleteDevSlide($_slide);
                $this->deleteImage($_slide);
            }
        }

        return true;
    }

    /**
     * Ajout image
     * @param DevSlide $_slide
     * @param object $_image
     */
    public function addImage($_slide, $_image) {
        // Récupérer le répertoire image spécifique
        $_directory_image  = PathName::UPLOAD_SLIDE;

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
            $_slide->setSldImageUrl($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression image (fichier avec entité)
     * @param DevSlide $_slide
     * @return array
     */
    public function deleteImage($_slide)
    {
        if ($_slide) {
            try {
                $_path = $this->_web_root.$_slide->getSldImageUrl();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_slide);
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
     * @param DevSlide $_slide
     * @return array
     */
    public function deleteOnlyImage($_slide)
    {
        if ($_slide) {
            $_path = $this->_web_root . $_slide->getSldImageUrl();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }
    }
}