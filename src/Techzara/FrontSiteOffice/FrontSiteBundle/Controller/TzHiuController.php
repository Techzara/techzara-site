<?php
/**
 * Created by PhpStorm.
 * User: jul
 * Date: 12/28/18
 * Time: 10:39 PM
 */

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TzHiuController extends Controller
{

    public function showAction(){
        return $this->render('FrontSiteBundle:TzHiu:index.html.twig', array(
        ));
    }
}