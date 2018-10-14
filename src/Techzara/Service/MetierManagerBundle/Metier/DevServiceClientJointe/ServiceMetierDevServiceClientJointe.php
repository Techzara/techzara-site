<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevServiceClientJointe;

use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient;
use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClientJointe;
use App\Techzara\Service\MetierManagerBundle\Utils\EntityName;
use App\Techzara\Service\MetierManagerBundle\Utils\MaxSizeValue;
use App\Techzara\Service\MetierManagerBundle\Utils\PathName;
use App\Techzara\Service\MetierManagerBundle\Utils\Util;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceMetierDevServiceClientJointe
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
     * Récuperer le repository service_client_jointe
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::LV_SERVICE_CLIENT_JOINTE);
    }

    /**
     * Récuperer un service_client_jointe par identifiant
     * @param Integer $_id
     * @return array
     */
    public function getDevServiceClientJointeById($_id)
    {
        return $this->getRepository()->find($_id);
    }

    /**
     * Récuperer un service_client_jointe par identifiant service client
     * @param Integer $_id_service_client
     * @return array
     */
    public function getDevServiceClientJointeByServiceClient($_id_service_client)
    {
        $_service_client_jointe = $this->getRepository()->findBy(array(
            'lvServiceClient' => $_id_service_client
        ));

        if ($_service_client_jointe)
            return $_service_client_jointe;

        return;
    }

    /**
     * Enregistrer un pièce jointe du client
     * @param DevServiceClientJointe $_service_client_jointe
     * @param string $_action
     * @return boolean
     */
    public function saveDevServiceClientJointe($_service_client_jointe, $_action)
    {
        if ($_action == 'new') {
            $this->_entity_manager->persist($_service_client_jointe);
        }
        $this->_entity_manager->flush();

        return $_service_client_jointe;
    }

    /**
     * Enregistrement pièce jointe du service client commandé
     * @param DevServiceClient $_service_client
     * @param array $_fichier_projet
     * @return array
     */
    public function saveServiceClientJointe($_service_client, $_fichier_projet)
    {
        $_service_client_jointe = new DevServiceClientJointe();
        $_service_client_jointe->setDevServiceClient($_service_client);

        if ($_fichier_projet) {
            $this->addJointe($_service_client_jointe, $_fichier_projet);
        }

        $this->saveDevServiceClientJointe($_service_client_jointe, 'new');
    }

    /**
     * Ajout pièce jointe
     * @param DevServiceClientJointe $_service_client_jointe
     * @param object $_jointe
     */
    public function addJointe($_service_client_jointe, $_jointe) {
        // Récupérer le répertoire image spécifique
        $_directory_image = PathName::UPLOAD_JOINTE;

        try {
            $_original_name = $_jointe->getClientOriginalName();
            $_path_part     = pathinfo($_original_name);
            $_extension     = $_path_part['extension'];
            $_filename      = Util::slug($_path_part['filename']);

            // Upload jointe
            $_file_name_image = $_filename . '.' . $_extension;
            $_uri_file        = $_directory_image . $_file_name_image;
            $_dir             = $this->_web_root . $_directory_image;
            $_jointe->move(
                $_dir,
                $_file_name_image
            );

            // Enregistrement jointe
            $_service_client_jointe->setSrvCltJtExt($_extension);
            $_service_client_jointe->setSrvCltJtPath($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }

    /**
     * Suppression pièce jointe (fichier avec entité)
     * @param DevServiceClientJointe $_service_client_jointe
     * @return array
     */
    public function deleteJointe($_service_client_jointe)
    {
        if ($_service_client_jointe) {
            try {
                $_path = $this->_web_root.$_service_client_jointe->getSrvCltJtPath();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $this->_entity_manager->remove($_service_client_jointe);
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
                'message' => 'Joint not found in database'
            );
        }
    }

    /**
     * Suppression pièce jointe (uniquement le fichier)
     * @param DevServiceClientJointe $_service_client_jointe
     * @return array
     */
    public function deleteOnlyJointe($_service_client_jointe)
    {
        if ($_service_client_jointe) {
            $_path = $this->_web_root . $_service_client_jointe->getSrvCltJtPath();

            // Suppression du fichier
            @unlink($_path);

            return true;
        }

        return false;
    }
}