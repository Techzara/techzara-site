<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TzFooterController extends Controller
{
    /**
     * Afficher la page footer
     * @param Request $_request
     * @return Render page
     */
    public function showAction(Request $_request)
    {
        // Récupérer manager

        return $this->render('FrontSiteBundle:TzFooter:index.html.twig', array(
        ));
    }
}