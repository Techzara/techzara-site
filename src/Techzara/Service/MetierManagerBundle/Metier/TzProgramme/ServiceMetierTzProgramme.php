<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 11:27 PM
 */

namespace App\Techzara\Service\MetierManagerBundle\Metier\TzProgramme;

use App\Techzara\Service\MetierManagerBundle\Form\TzProgramme;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class ServiceMetierTzProgramme
 * @package App\Techzara\Service\MetierManagerBundle\Metier\TzProgramme
 */
class ServiceMetierTzProgramme
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
        return $this->_entity_manager->getRepository(EntityName::PROGRAMME);
    }


    public function getAllProgramme()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    public function getAllProgrammeById($_id)
    {
        return $this->getRepository()->find($_id);
    }



    /**
     * Ajouter un utilisateur
     * @param TzProgramme $_programme
     * @param Object $_form
     * @return boolean
     */
    public function addProgramme($_programme, $_form) {

        // Traitement du photo
        $_img_photo = $_form['tzProgrammePhoto']->getData();
        if ($_img_photo) {
            $_programme_upload_manager = $this->_container->get(ServiceName::SRV_METIER_PROGRAMME_UPLOAD);
            $_programme_upload_manager->upload($_programme, $_img_photo);
        }

        $this->saveProgramme($_programme, 'new');
    }


    /**
     * Enregistrer un utilisateur
     * @param TzProgramme $_programme
     * @param string $_action
     * @return boolean
     */
    public function saveProgramme($_programme, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_programme);
        }
        $this->_entity_manager->flush();

        return $_programme;
    }


    /**
     * Modifier un utilisateur
     * @param \App\Techzara\Service\MetierManagerBundle\Entity\TzProgramme $_programme
     * @param Object $_form
     * @return boolean
     */
    public function updateProgramme($_programme, $_form) {
        // Traitement photo
        $_img_photo = $_form['tzProgrammePhoto']->getData();
        // S'il y a un nouveau fichier ajouté, on supprime l'ancien fichier puis on enregistre ce nouveau
        if ($_img_photo) {
            $_programme_upload_manager = $this->_container->get(ServiceName::SRV_METIER_PROGRAMME_UPLOAD);
            $_programme_upload_manager->deleteOnlyImageById($_programme->getId());
            $_programme_upload_manager->upload($_programme, $_img_photo);
        }

        $this->saveProgramme($_programme, 'update');
    }

    /**
     * Supprimer un utilisateur
     * @param \App\Techzara\Service\MetierManagerBundle\Entity\TzProgramme $_programme
     * @return boolean
     */
    public function deleteTzProgramme($_programme)
    {
        $this->_entity_manager->remove($_programme);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un programme
     * @param array $_ids
     * @return boolean
     */
    public function deleteTzProgrammeGroup($_ids)
    {
        $_art_imaege_manager = $this->_container->get(ServiceName::SRV_METIER_PROGRAMME_UPLOAD);

        if (count($_ids)) {
            foreach ($_ids as $_id) {
                // Suppression fichier image
                $_art_imaege_manager->deleteImageById($_id);

                // Suppression utilisateur
                $_programme = $this->getAllProgrammeByID($_id);
                $this->deleteTzProgramme($_programme);
            }
        }

        return true;
    }


}