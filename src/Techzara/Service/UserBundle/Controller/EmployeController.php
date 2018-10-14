<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 9/4/18
 * Time: 2:45 PM
 */

namespace App\Techzara\Service\UserBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use App\Techzara\Service\UserBundle\UserBundle;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Techzara\Service\UserBundle\Entity\User;
use App\Techzara\Service\UserBundle\Form\UserType;

class EmployeController extends Controller
{
    public function indexAction(){
        $_employe_manager = $this->get(ServiceName::SRV_METIER_USER);
        $_employes = $_employe_manager->getAllUser();


        return $this->render('UserBundle:Employe:index.html.twig' ,array(
                'employes' => $_employes,
        ));
    }
}