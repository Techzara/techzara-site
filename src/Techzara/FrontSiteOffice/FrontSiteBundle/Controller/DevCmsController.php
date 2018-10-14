<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DevCmsController
 */
class DevCmsController extends Controller
{
    /**
     * Afficher la page cms
     * @param Request $_request
     * @param int $_id
     * @param string $_slug
     * @return Render page
     */
    public function showAction(Request $_request, $_id, $_slug)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        // Récupérer le cms
        $_cms = $_cms_manager->getDevCmsById($_id);

        return $this->render('FrontSiteBundle:DevCms:index.html.twig', array(
            'cms' => $_cms,
        ));
    }
}
