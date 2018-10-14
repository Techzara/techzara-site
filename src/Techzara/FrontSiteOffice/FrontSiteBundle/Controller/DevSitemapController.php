<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\CmsName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DevSitemapController
 */
class DevSitemapController extends Controller
{
    /**
     * Afficher la page accueil
     * @param Request $_request
     * @return string
     */
    public function indexAction(Request $_request)
    {
        // Récupérer manager
        $_cms_manager = $this->get(ServiceName::SRV_METIER_CMS);

        $_cms_about_us       = $_cms_manager->getDevCmsById(CmsName::ID_CMS_ABOUT_US_FOOTER);
        $_cms_contact        = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CONTACT_FOOTER);
        $_cms_mention_legale = $_cms_manager->getDevCmsById(CmsName::ID_CMS_MENTIONS_LEGALES);
        $_cms_cgu            = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CGU);

        return $this->render('FrontSiteBundle:DevSitemap:index.html.twig', array(
            'cms_about_us'       => $_cms_about_us,
            'cms_contact'        => $_cms_contact,
            'cms_mention_legale' => $_cms_mention_legale,
            'cms_cgu'            => $_cms_cgu
        ));
    }

    /**
     * Afficher le sitemap.xml
     * @param Request $_request
     * @return Render
     */
    public function generateSitemapAction(Request $_request)
    {
        // Récupérer manager
        $_sitemap_manager = $this->get(ServiceName::SRV_METIER_SITEMAP);

        $_urls_w3c  = $_sitemap_manager->generateSitemap();
        $_urls_site = $_sitemap_manager->generateSitemapSite();
        $_urls      = array_merge($_urls_w3c, $_urls_site);

        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        return $this->render('FrontSiteBundle:DevSitemap:sitemap.xml.twig', [
            'urls' => $_urls
        ]);
    }
}
