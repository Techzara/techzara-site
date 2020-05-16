<?php
/**
 * @author <Bocasay>.
 */

namespace App\Controller\Front;

use App\Controller\AbstractBaseController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController.
 */
class HomeController extends AbstractBaseController
{
    /**
     * @Route("/", methods={"POST","GET"})
     */
    public function homePage()
    {
        return $this->render('front/_front_index.html.twig');
    }
}
