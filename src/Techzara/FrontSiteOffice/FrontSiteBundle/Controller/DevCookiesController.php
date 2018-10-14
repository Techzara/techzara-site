<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DevCookiesController
 */
class DevCookiesController extends Controller
{
    /**
     * Afficher la page mention légale
     * @return string
     */
    public function indexAction()
    {
        return $this->render('FrontSiteBundle:DevCookies:index.html.twig');
    }
}
