<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/14/18
 * Time: 9:13 PM
 */

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Techzara\Service\UserBundle\Entity\User;
use App\Techzara\Service\UserBundle\Form\UserType;

class TzMembresController extends Controller
{
    public function indexAction()
    {
        $_tz_membres    = $this->get(ServiceName::SRV_METIER_MEMBRES);
        $_list_membres  = $_tz_membres->getAllUser();

        return $this->render('FrontSiteBundle:TzMembres:membres.html.twig',array(
           'membres' => $_list_membres
        ));
    }

    public function showAction(User $_user)
    {
        if (!$_user)
            $this->createNotFoundException('Member not found');
        return $this->render('FrontSiteBundle:TzMembres:profile.html.twig',array(
            'profile' => $_user
        ));
    }

    /**
     * Création utilisateur
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        $_user = new User();
        $_form = $this->createCreateForm($_user);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement utilisateur
            $_user_manager->addUser($_user, $_form);

            $_user_manager->setFlash('success', "Merci pour votre inscription");

            return $this->redirect($this->generateUrl('membres_liste'));
        }

        return $this->render('FrontSiteBundle:TzMembres:add.html.twig', array(
            'user' => $_user,
            'form' => $_form->createView()
        ));
    }


    /**
     * Création formulaire d'édition utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $_user)
    {

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('membres_new'),
            'method'    => 'POST',
        ));

        return $_form;
    }
}