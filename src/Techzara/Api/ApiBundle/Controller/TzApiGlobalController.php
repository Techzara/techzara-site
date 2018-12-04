<?php
/**
 * Created by PhpStorm.
 * User: jul
 * Date: 12/4/18
 * Time: 5:31 PM
 */

namespace App\Techzara\Api\ApiBundle\Controller;


use App\Techzara\Service\MetierManagerBundle\Entity\TzArticle;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\MetierManagerBundle\Metier\TzHome\HomeManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class TzApiGlobalController extends Controller
{
    /**
     * Afficher la page accueil
     * @return string
     */
    public function indexAction()
    {
        // Récupérer manager

        $_activite_manager       = $this->get(ServiceName::SRV_METIER_ACTIVITE);
        $_article_manager        = $this->get(ServiceName::SRV_METIER_ARTICLE);
        $_programme_manager      = $this->get(ServiceName::SRV_METIER_PROGRAMME);
        // Serializer
        $_encoders = array(new JsonEncoder());
        $_normalizers = array(new ObjectNormalizer());
        $_serializer = new Serializer($_normalizers, $_encoders);


        $_programme       = $_programme_manager->getAllProgramme();
        $_activite        = $_activite_manager->getAllActivite();
        $_article         = $_article_manager->getAllArticle();

        $_result_articles = [];
        $_result_programme = [];
        foreach($_article as $_key => $_article) {
            $_result_articles [$_key]['id'] = $_article->getId();
            $_result_articles [$_key]['title'] = $_article->getTitle();
            $_result_articles [$_key]['author'] = $_article->getAuthor();
            $_result_articles [$_key]['photo'] = $_article->getArtphoto();
            $_result_articles [$_key]['content'] = $_article->getContent();
            $_result_articles [$_key]['date'] = $_article->getArtDate()->format('d/m/Y');
        }
        foreach ($_programme as $_key => $_programme) {
            $_result_programme [$_key]['id'] = $_programme->getId();
            $_result_programme [$_key]['title'] = $_programme->getTzProgrammeDescription();
            $_result_programme [$_key]['photo'] = $_programme->getTzProgrammePhoto();
            $_result_programme [$_key]['intervenants'] = $_programme->getTzProgrammeIntervenants();
            $_result_programme [$_key]['lieu'] = $_programme->getTzProgrammeLieu();
        }


        return new JsonResponse(array(
            'programmes'      => $_result_programme,
            'articles'        => $_result_articles
        ));
    }

    public function adminAction()
    {
        $_membres_liste          = $this->get(ServiceName::SRV_METIER_MEMBRES);
        $_admin           = $_membres_liste->getAdmin();

        // Serializer
        $_encoders = array(new JsonEncoder());
        $_normalizers = array(new ObjectNormalizer());
        $_serializer = new Serializer($_normalizers, $_encoders);

        $_admin_liste = $_serializer->serialize($_admin,'json');
        $_adm_liste = json_decode($_admin_liste);

        return new JsonResponse(array(
            'admin' => $_adm_liste
        ));
    }

    public function activiteAction()
    {
        $_activite_manager = $this->get(ServiceName::SRV_METIER_ACTIVITE);
        $_activite_liste=$_activite_manager->getAllActivite();
        // Serializer
        $_encoders = array(new JsonEncoder());
        $_normalizers = array(new ObjectNormalizer());
        $_serializer = new Serializer($_normalizers, $_encoders);

        $_activite = $_serializer->serialize($_activite_liste,'json');
        $_activite_result = json_decode($_activite);

        return new JsonResponse(array(
           'activite' => $_activite_result
        ));
    }

    public function membersAction()
    {
        $_members_manager = $this->get(ServiceName::SRV_METIER_MEMBRES);
        $_members_list = $_members_manager->getAllUser();

        $_encoders = new JsonEncoder();
        $_time=new DateTimeNormalizer();
        $_obj=new ObjectNormalizer();
        $_normalizers =  new ObjectNormalizer();
        $_normalizers->setIgnoredAttributes(array('usrDateUpdate','usrDateCreate','lastLogin'));
        $_serializer = new Serializer(array($_normalizers),array($_encoders));

        $_members=$_serializer->serialize($_members_list,'json');
        $_results_members = json_decode($_members);

        return new JsonResponse(array(
           'members' => $_results_members
        ));
    }
}