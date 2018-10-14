<?php

namespace App\Techzara\Service\MetierManagerBundle\Metier\DevSitemap;

use App\Techzara\Service\MetierManagerBundle\Utils\CmsName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceMetierDevSitemap
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Générer un sitemap xml
     * @return array
     */
    public function generateSitemap()
    {
        // Récupérer manager
        $_cms_manager     = $this->_container->get(ServiceName::SRV_METIER_CMS);
        $_service_manager = $this->_container->get(ServiceName::SRV_METIER_SERVICE);

        $_cms_mention_legale = $_cms_manager->getDevCmsById(CmsName::ID_CMS_MENTIONS_LEGALES);
        $_cms_cgv            = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CGV);
        $_cms_cgu            = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CGU_W3C);
        $_services           = $_service_manager->getAllDevServiceOrderAsc();

        $_urls = [];

        // Accueil
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_index', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Fonctionnement
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'fonctionnement_front_show', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Contact
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'contact_send_mail', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // FAQ
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'faq_front_show', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Mention légale
        if ($_cms_mention_legale)
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('cms_front_show', [
                    '_id'   => $_cms_mention_legale->getId(),
                    '_slug' => $_cms_mention_legale->translate('fr')->getCmstSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        // CGV
        if ($_cms_cgv)
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('cms_front_show', [
                    '_id'   => $_cms_cgv->getId(),
                    '_slug' => $_cms_cgv->translate('fr')->getCmstSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        // CGU
        if ($_cms_cgu)
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('cms_front_show', [
                    '_id'   => $_cms_cgu->getId(),
                    '_slug' => $_cms_cgu->translate('fr')->getCmstSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        // Services
        foreach ($_services as $_service) {
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('order_show', [
                    '_slug' => $_service->getSrvSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        }

        return $_urls;
    }

    /**
     * Générer un sitemap site xml
     * @return array
     */
    public function generateSitemapSite()
    {
        // Récupérer manager
        $_cms_manager = $this->_container->get(ServiceName::SRV_METIER_CMS);

        $_cms_mention_legale = $_cms_manager->getDevCmsById(CmsName::ID_CMS_MENTIONS_LEGALES);
        $_cms_cgu            = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CGU);

        $_urls = [];

        // Accueil
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_site_index', [], UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Comment ça marche
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_site_ccm', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Sites
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_site_site', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Applications
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_site_applications', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Ils nous font confiance
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'home_site_confiance', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Contact
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate(
                'contact_site_send_mail', [],UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // Mention légale
        if ($_cms_mention_legale)
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('cms_front_show_site', [
                    '_id'   => $_cms_mention_legale->getId(),
                    '_slug' => $_cms_mention_legale->translate('fr')->getCmstSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        // CGU
        if ($_cms_cgu)
            $_urls[] = [
                'loc'        => $this->_container->get('router')->generate('cms_front_show_site', [
                    '_id'   => $_cms_cgu->getId(),
                    '_slug' => $_cms_cgu->translate('fr')->getCmstSlug()
                ],UrlGeneratorInterface::ABSOLUTE_URL),
                'changefreq' => 'weekly',
                'priority'   => '1.0'
            ];
        // Site vitrine
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate('home_site_site', [
                'idref' => 'sitevitrine'
            ],UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // E-commerce
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate('home_site_site', [
                'idref' => 'ecommerce'
            ],UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];
        // WebApp
        $_urls[] = [
            'loc'        => $this->_container->get('router')->generate('home_site_site', [
                'idref' => 'webapp'
            ],UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq' => 'weekly',
            'priority'   => '1.0'
        ];

        return $_urls;
    }
}