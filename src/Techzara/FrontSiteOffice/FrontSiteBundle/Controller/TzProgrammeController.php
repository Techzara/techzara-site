<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/21/18
 * Time: 12:38 PM
 */

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;


use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TzProgrammeController extends Controller
{
    public function indexAction()
    {
        $_entity_manager = $this->get(ServiceName::SRV_METIER_PROGRAMME);
        $_programme_liste = $_entity_manager->getAllProgramme();
        dump($_programme_liste);die();

        return $this->render('FrontSiteBundle:TzProgramme:index.html.twig',array(
            'programmes' => $_programme_liste,
        ));
    }
}