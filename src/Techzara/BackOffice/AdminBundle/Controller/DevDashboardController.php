<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;

/**
 * Class DevDashboardController
 */
class DevDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     * @return Render page
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:DevDashboard:index.html.twig');
    }
}
