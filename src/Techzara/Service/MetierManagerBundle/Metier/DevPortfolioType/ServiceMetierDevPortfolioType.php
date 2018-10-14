<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevPortfolioType;

use App\Techzara\Service\MetierManagerBundle\Entity\DevPortfolioType;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;

class ServiceMetierDevPortfolioType
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
     * Récuperer le repository portfolio_type
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_PORTFOLIO_TYPE);
    }

    /**
     * Récuperer tout les portfolio_types
     * @return array
     */
    public function getAllDevPortfolioType()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer tout les portfolio_types
     * @return array
     */
    public function getAllDevPortfolioTypeOrderAsc()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'ASC'));
    }

    /**
     * Récuperer un portfolio_type par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevPortfolioTypeById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un portfolio_type
     * @param DevPortfolioType $_portfolio_type
     * @param string $_action
     * @return boolean
     */
    public function saveDevPortfolioType($_portfolio_type, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_portfolio_type);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un portfolio_type
     * @param DevPortfolioType $_portfolio_type
     * @return boolean
     */
    public function deleteDevPortfolioType($_portfolio_type)
    {
        $this->_entity_manager->remove($_portfolio_type);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un portfolio_type
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevPortfolioType($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_portfolio_type = $this->getDevPortfolioTypeById($_id);
                $this->deleteDevPortfolioType($_portfolio_type);
            }
        }

        return true;
    }
}