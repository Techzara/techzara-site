<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\CmsName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DevFooterController extends Controller
{
    /**
     * Afficher la page footer
     * @param Request $_request
     * @return Render page
     */
    public function showAction(Request $_request)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        $_cms_about_us       = $_cms_manager->getDevCmsById(CmsName::ID_CMS_ABOUT_US_FOOTER);
        $_cms_contact        = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CONTACT_FOOTER);
        $_cms_mention_legale = $_cms_manager->getDevCmsById(CmsName::ID_CMS_MENTIONS_LEGALES);
        $_cms_cgu            = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CGU);

        return $this->render('FrontSiteBundle:DevFooter:index.html.twig', array(
            'cms_about_us'       => $_cms_about_us,
            'cms_contact'        => $_cms_contact,
            'cms_mention_legale' => $_cms_mention_legale,
            'cms_cgu'            => $_cms_cgu
        ));
    }
}