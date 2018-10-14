<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevServiceOption;

use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceOption;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\MetierManagerBundle\Utils\ValeurTypeName;
use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceMetierDevServiceOption
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
     * Récuperer le repository service_option
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SERVICE_OPTION);
    }

    /**
     * Récuperer tout les service_options
     * @return array
     */
    public function getAllDevServiceOption()
    {
        return $this->getRepository()->findBy(array(), array('id' => 'DESC'));
    }

    /**
     * Récuperer un service_option par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevServiceOptionById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Enregistrer un service_option
     * @param DevServiceOption $_service_option
     * @param string $_action
     * @return boolean
     */
    public function saveDevServiceOption($_service_option, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service_option);
        }
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Supprimer un service_option
     * @param DevServiceOption $_service_option
     * @return boolean
     */
    public function deleteDevServiceOption($_service_option)
    {
        $this->_entity_manager->remove($_service_option);
        $this->_entity_manager->flush();

        return true;
    }

    /**
     * Suppression multiple d'un service_option
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupDevServiceOption($_ids)
    {
        if (count($_ids)) {
            foreach ($_ids as $_id) {
                $_service_option = $this->getDevServiceOptionById($_id);
                $this->deleteDevServiceOption($_service_option);
            }
        }

        return true;
    }

    /**
     * Récupérer les services gratuit
     * @param integer $_id_service
     * @return array
     */
    public function getAllServiceOptionGratuitByService($_id_service)
    {
        $_entity = EntityName::LV_SERVICE_OPTION;
        $_dql    = "SELECT srv_opt FROM $_entity srv_opt
                    LEFT JOIN srv_opt.lvServiceOptionValeurType so_val_tp
                    LEFT JOIN srv_opt.lvServices srv
                    WHERE so_val_tp.srvOptValTpVal = :val
                    AND srv.id = :id_service";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_service', $_id_service);
        $_query->setParameter('val', ValeurTypeName::ID_GRATUIT);

        return $_query->getResult();
    }

    /**
     * Récupérer les services non gratuit
     * @param integer $_id_service
     * @return array
     */
    public function getAllServiceOptionNonGratuitByService($_id_service)
    {
        $_entity = EntityName::LV_SERVICE_OPTION;
        $_dql    = "SELECT srv_opt FROM $_entity srv_opt
                    LEFT JOIN srv_opt.lvServiceOptionValeurType so_val_tp
                    LEFT JOIN srv_opt.lvServices srv
                    WHERE so_val_tp.srvOptValTpVal <> :val
                    AND srv.id = :id_service";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_service', $_id_service);
        $_query->setParameter('val', ValeurTypeName::ID_GRATUIT);

        return $_query->getResult();
    }

    /**
     * Récuperer un service_option par tableau identifiant
     * @param array $_ids
     * @return array
     */
    public function getDevServiceOptionByArrayId($_ids)
    {
        return $this->getRepository()->findBy(array('id' => $_ids));
    }

    /**
     * Récuperer un service_option par service
     * @param integer $_id_service
     * @return array
     */
    public function getDevServiceOptionByService($_id_service)
    {
        $_service_option = EntityName::LV_SERVICE_OPTION;

        $_dql = "SELECT srv_opt.id, srv_opt.srvOptLabel FROM $_service_option srv_opt
                 LEFT JOIN srv_opt.lvServiceOptionValeurType so_val_tp
                 LEFT JOIN srv_opt.lvServices srv
                 WHERE so_val_tp.srvOptValTpVal <> :val
                 AND srv.id = :id_service";

        $_query = $this->_entity_manager->createQuery($_dql);
        $_query->setParameter('id_service', $_id_service);
        $_query->setParameter('val', ValeurTypeName::ID_GRATUIT);

        $_results = $_query->getResult();

        return new JsonResponse($_results);
    }
}