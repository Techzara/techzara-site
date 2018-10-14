<?php

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Utils\CmsName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;

class DevContactController extends Controller
{
    /**
     * Afficher la page contact
     * @param Request $_request
     * @return Render page
     */
    public function sendMailAction(Request $_request)
    {
        // Récupérer manager
        $_contact_manager = $this->get(ServiceName::SRV_METIER_CONTACT_SITE);
        $_cms_manager     = $this->get(ServiceName::SRV_METIER_CMS);

        $_cms_contact = $_cms_manager->getDevCmsById(CmsName::ID_CMS_CONTACT);

        $_array_file = $_request->files->all();

        if ($_request->isMethod('POST')) {
            // Récuperer les données formulaire
            $_post                     = $_request->request->all();
            $_file_details             = $_array_file['url_file'];
            $_options['firstname']     = $_post['firstname'];
            $_options['lastname']      = $_post['lastname'];
            $_options['email']         = $_post['email'];
            $_options['phone']         = $_post['phone'];
            $_options['message']       = $_post['message'];
            $_options['service_type']  = (!empty($_post['service_type']))?$_post['service_type']:[];
            $_file_join['file_jointe'] = $_file_details;

            // Envoie mail
            $_send_mail = $_contact_manager->sendEmail($_options, $_file_join);

            if ($_send_mail == false) {
                $_message = $this->get('translator')->trans('contact.mail.not.sent');
                $_contact_manager->setFlash('error', $_message);
            } else {
                $_message = $this->get('translator')->trans('contact.mail.sent');
                $_contact_manager->setFlash('success', $_message);
            }
        }

        return $this->render('FrontSiteBundle:DevContact:index.html.twig', array(
            'cms_contact' => $_cms_contact
        ));
    }
}