<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Entity\DevArticle;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\MetierManagerBundle\Metier\DevHome\HomeManager;

/**
 * Class DevHomeController
 */
class DevHomeController extends Controller
{
    /**
     * Afficher la page accueil
     * @return string
     */
    public function indexAction()
    {
        // Récupérer manager
        $_slide_manager          = $this->get(ServiceName::SRV_METIER_SLIDE);
        $_portfolio_manager      = $this->get(ServiceName::SRV_METIER_PORTFOLIO);
        $_portfolio_type_manager = $this->get(ServiceName::SRV_METIER_PORTFOLIO_TYPE);
        $_membres_liste          = $this->get(ServiceName::SRV_METIER_MEMBRES);
        $_activite_manager       = $this->get(ServiceName::SRV_METIER_ACTIVITE);
        $_article_manager        = $this->get(ServiceName::SRV_METIER_ARTICLE);

        $_slides          = $_slide_manager->getAllDevSlide();
        $_portfolios      = $_portfolio_manager->getAllDevPortfolio();
        $_portfolio_types = $_portfolio_type_manager->getAllDevPortfolioType();
        $_admin           = $_membres_liste->getAdmin();
        $_activite        = $_activite_manager->getAllActivite();
        $_article         = $_article_manager->getAllArticle();


        return $this->render('FrontSiteBundle:DevHome:index.html.twig', array(
            'slides'          => $_slides,
            'portfolios'      => $_portfolios,
            'portfolio_types' => $_portfolio_types,
            'users'           => $_admin,
            'activites'       => $_activite,
            'articles'         => $_article
        ));
    }


    /**
     * Afficher la page site
     * @return string
     */
    public function siteAction()
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_slides = $_slide_manager->getAllDevSlide();

        return $this->render('FrontSiteBundle:DevHome:site.html.twig', array(
            'slides' => $_slides
        ));
    }

    /**
     * Afficher la page confiance
     * @return string
     */
    public function confianceAction()
    {
        // Récupérer manager


        return $this->render('FrontSiteBundle:DevHome:confiance.html.twig', array(
        ));
    }

    /**
     * Afficher la page application
     * @return string
     */
    public function applicationAction()
    {
        // Récupérer manager
        $_slide_manager = $this->get(ServiceName::SRV_METIER_SLIDE);

        $_slides = $_slide_manager->getAllDevSlide();

        return $this->render('FrontSiteBundle:DevHome:applications.html.twig', array(
            'slides' => $_slides
        ));
    }

    /**
     * Afficher la page ccm
     * @return string
     */
    public function ccmAction()
    {
        // Récupérer manager

        return $this->render('FrontSiteBundle:DevHome:ccm.html.twig', array(
        ));
    }

    /**
     * Afficher la page témoignage
     * @return string
     */
    public function temoignageAction()
    {
        // Récupérer manager
        $_temoignage_manager = $this->get(ServiceName::SRV_METIER_TEMOIGNAGE);

        $_temoignages = $_temoignage_manager->getAllDevTemoignage();

        return $this->render('FrontSiteBundle:DevHome:temoignage.html.twig', array(
            'temoignages' => $_temoignages
        ));
    }
}
