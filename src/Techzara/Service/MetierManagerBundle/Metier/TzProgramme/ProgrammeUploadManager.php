<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\TzProgramme;

use Doctrine\ORM\EntityManager;
use App\Techzara\Service\MetierManagerBundle\Utils\PathName;
use App\Techzara\Service\MetierManagerBundle\Entity\TzProgramme;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProgrammeUploadManager
{
    protected $_em;
    protected $_web_root;

    public function __construct(EntityManager $em, $rootDir)
    {
        $this->_em       = $em;
        $this->_web_root = realpath($rootDir . '/../public');
    }

    /**
     * Suppression fichier (fichier avec entité)
     * @param integer $_id identifiant utilisateur
     * @return array
     */
    public function deleteImageById($_id)
    {
        $_user = $this->_em->getRepository('MetierManagerBundle:TzProgramme')->find($_id);

        if ($_user) {
            try {
                $_path = $this->_web_root.$_user->getTzProgrammePhoto();

                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $_user->setTzProgrammePhoto(null);
                $this->_em->persist($_user);
                $this->_em->flush();
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
     * Suppression fichier (uniquement le fichier)
     * @param integer $_id identifiant utilisateur
     * @return array
     */
    public function deleteOnlyImageById($_id)
    {
        $_user = $this->_em->getRepository('MetierManagerBundle:TzProgramme')->find($_id);

        if ($_user) {
            $_path = $this->_web_root.$_user->getTzProgrammePhoto();

            // Suppression du fichier
            @unlink($_path);
        }
    }

    /**
     * Upload fichier
     * @param Programme $_user
     * @param file $_image
     */
    public function upload(TzProgramme $_programme, $_image) {
        try {
            $_filename_image = md5(uniqid()).'.'.$_image->guessExtension();
            $_uri_file       = PathName::UPLOAD_PROGRAMME . $_filename_image;
            $_dir            = $this->_web_root . PathName::UPLOAD_PROGRAMME;
            $_image->move(
                $_dir,
                $_filename_image
            );
            $_programme->setTzProgrammePhoto($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }
}