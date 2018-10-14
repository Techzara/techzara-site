<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevCms;

use App\Techzara\Service\MetierManagerBundle\Entity\DevCms;
use App\Techzara\Service\MetierManagerBundle\Utils\CmsName;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevCms
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

    /**
     * Récuperer le repository cms
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_CMS);
    }

    /**
     * Récuperer tout les cmss
     * @return array
     */
    public function getAllDevCms()
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();
        $_user_role      = $_user_connected->getTzRole()->getId();

        $_array_type = array(
            'id' => array(
                CmsName::ID_CMS_CGV,
                CmsName::ID_CMS_MENTIONS_LEGALES,
                CmsName::ID_CMS_FAQ,
                CmsName::ID_CMS_ACCUEIL,
                CmsName::ID_CMS_CCM,
                CmsName::ID_CMS_SITE,
                CmsName::ID_CMS_APPLICATION,
                CmsName::ID_CMS_CONFIANCE,
                CmsName::ID_CMS_CONTACT_FOOTER,
                CmsName::ID_CMS_ABOUT_US_FOOTER,
                CmsName::ID_CMS_CONTACT
            )
        );


        return $this->getRepository()->findBy($_array_type, array('id' => 'DESC'));
    }

    /**
     * Récuperer un cms par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevCmsById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un cms
     * @param DevCms $_cms
     * @param string $_action
     * @return boolean
     */
    public function saveDevCms($_cms, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_cms);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un cms
     * @param DevCms $_cms
     * @return boolean
     */
    public function deleteDevCms($_cms)
    {
        $this->_entity_manager->remove($_cms);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un cms
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevCms($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_cms = $this->getDevCmsById($_id);
                $this->deleteDevCms($_cms);
            }
        }

        return true;
    }
}
