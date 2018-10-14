<?php

namespace App\Techzara\BackOffice\AdminBundle\Controller;

use App\Techzara\Service\MetierManagerBundle\Form\DevServiceClientType;
use App\Techzara\Service\MetierManagerBundle\Utils\EtatServiceProject;
use App\Techzara\Service\MetierManagerBundle\Utils\EtatServiceValidation;
use App\Techzara\Service\MetierManagerBundle\Utils\RoleName;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Techzara\Service\MetierManagerBundle\Entity\DevServiceClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class DevServiceClientController
 */
class DevServiceClientController extends Controller
{
    /**
     * Récupération données Json
     * @param Request $_request
     * @param int $_nb_total
     * @param int $_nb_displayed
     * @param mixed $_values
     * @param string $_template
     * @return string
     */
    public function getDataJson($_request, $_nb_total, $_nb_displayed, $_values, $_template)
    {
        $_data['sEcho']                = $_request->query->get('sEcho');
        $_data['iTotalRecords']        = (int) $_nb_total;
        $_data['iTotalDisplayRecords'] = (int) $_nb_displayed;

        return $this->renderView($_template, array(
            'data'   => $_data,
            'values' => $_values
        ));
    }

    /**
     * Ajax liste service client
     * @param \Symfony\Component\HttpFoundation\Request $_request
     * @param string $_type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAjaxAction(Request $_request, $_type)
    {
        // Récupérer service
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Filtre et triage
        $_filters  = $_service_client_manager->getFilters($_request);
        $_sortings = $_service_client_manager->getSortings($_request, array(
            'sc.lvUser',
            'sc.lvService',
            '',
            'sc.srvCltDate',
            'sc.srvCltStatusValidation',
            ''
        ));

        // Filtre de recherche
        $_options = array(
            'search' => $_request->query->get('sSearch'),
            'type'   => $_type
        );

        $_template = 'AdminBundle:DevServiceClient:list.json.twig';
        if ($_type == 'not-validated')
            $_template = 'AdminBundle:DevServiceClient:list_not_validated.json.twig';
        elseif ($_type == 'validated')
            $_template = 'AdminBundle:DevServiceClient:list_validated.json.twig';

        // Récupérer les espaces
        $_nb_paris       = $_service_client_manager->getNbDevServiceClientBy($_options);
        $_product_result = $_service_client_manager->getAllDevServiceClientBy($_options, $_filters, $_sortings);

        // Traitement json
        $_content = $this->getDataJson(
            $_request,
            $_nb_paris['nb'],
            $_nb_paris['nb'],
            $_product_result,
            $_template
        );
        $_response = new Response($_content);
        $_response->headers->set('Content-Type', 'application/json');

        return $_response;
    }

    /**
     * Afficher tout les service_clients
     * @return Render page
     */
    public function listAction()
    {
        return $this->render('AdminBundle:DevServiceClient:list.html.twig');
    }

    /**
     * Afficher tout les service_clients à valider
     * @return Render page
     */
    public function listNotValidatedAction()
    {
        return $this->render('AdminBundle:DevServiceClient:list_not_validated.html.twig');
    }

    /**
     * Afficher tout les service_clients validés
     * @return Render page
     */
    public function listValidatedAction()
    {
        return $this->render('AdminBundle:DevServiceClient:list_validated.html.twig');
    }

    /**
     * Affichage page modification service_client
     * @param DevServiceClient $_service_client
     * @return Render page
     */
    public function editAction(DevServiceClient $_service_client)
    {
        // Récupérer manager
        $_service_client_jointe_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        if (!$_service_client) {
            throw $this->createNotFoundException('Unable to find DevServiceClient entity.');
        }

        // Récupérer le pièce jointe
        $_id_service_client      = $_service_client->getId();
        $_service_client_jointes = $_service_client_jointe_manager->getDevServiceClientJointeByServiceClient($_id_service_client);

        $_edit_form = $this->createEditForm($_service_client);

        return $this->render('AdminBundle:DevServiceClient:edit.html.twig', array(
            'service_client'         => $_service_client,
            'service_client_jointes' => $_service_client_jointes,
            'edit_form'              => $_edit_form->createView()
        ));
    }

    /**
     * Création service_client
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        $_service_client = new DevServiceClient();
        $_form           = $this->createCreateForm($_service_client);
        $_form->handleRequest($_request);

        if ($_request->isMethod('POST')) {
            if ($_form->isSubmitted() && $_form->isValid()) {
                $_piece_jointes = $_request->files->get('tz_piece_jointe');

                // Enregistrement service_client
                $_service_client_manager->addDevServiceClient($_service_client, $_piece_jointes);

                $_service_client_manager->setFlash('success', "Service client ajouté");

                return $this->redirect($this->generateUrl('service_client_list_not_validated'));
            } else {
                $_error_message = (string)$_form->getErrors(true, false);
                $_service_client_manager->setFlash('error', $_error_message);

                return $this->redirect($this->generateUrl('service_client_new'));
            }
        }

        return $this->render('AdminBundle:DevServiceClient:add.html.twig', array(
            'service_client' => $_service_client,
            'form'           => $_form->createView(),
        ));
    }

    /**
     * Modification service_client
     * @param Request $_request requête
     * @param DevServiceClient $_service_client
     * @return Render page
     */
    public function updateAction(Request $_request, DevServiceClient $_service_client)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        if (!$_service_client) {
            throw $this->createNotFoundException('Unable to find DevServiceClient entity.');
        }

        $_edit_form = $this->createEditForm($_service_client);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isSubmitted() && $_edit_form->isValid()) {
            $_piece_jointes = $_request->files->get('tz_piece_jointe');

            // Enregistrement service_client
            $_service_client_manager->updateDevServiceClient($_service_client, $_piece_jointes);

            $_service_client_manager->setFlash('success', "Service client modifié");

            return $this->redirect($this->generateUrl('service_client_list_not_validated'));
        } else {
            $_error_message = "Le fichier téléchargé est trop volumineux. Merci d'essayer d'envoyer un fichier plus petit.";
            $_service_client_manager->setFlash('error', $_error_message);

            return $this->redirect($this->generateUrl('service_client_edit', array(
                'id' => $_service_client->getId()
            )));
        }

        return $this->render('AdminBundle:DevServiceClient:edit.html.twig', array(
            'service_client' => $_service_client,
            'edit_form'      => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition service_client
     * @param DevServiceClient $_service_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DevServiceClient $_service_client)
    {
        $_form = $this->createForm(DevServiceClientType::class, $_service_client, array(
            'action'      => $this->generateUrl('service_client_new'),
            'method'      => 'POST',
            'type_action' => 'create'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création service_client
     * @param DevServiceClient $_service_client The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DevServiceClient $_service_client)
    {
        $_form = $this->createForm(DevServiceClientType::class, $_service_client, array(
            'action'      => $this->generateUrl('service_client_update', array('id' => $_service_client->getId())),
            'method'      => 'PUT',
            'type_action' => 'edit'
        ));

        return $_form;
    }

    /**
     * Suppression service_client
     * @param Request $_request requête
     * @param DevServiceClient $_service_client
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, DevServiceClient $_service_client)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        $_form = $this->createDeleteForm($_service_client);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression service_client
            $_service_client_manager->deleteDevServiceClient($_service_client);

            $_service_client_manager->setFlash('success', 'Service client supprimé');
        }

        $_url_referer = $_request->headers->get('referer');

        return $this->redirect($_url_referer);
    }

    /**
     * Création formulaire de suppression service_client
     * @param DevServiceClient $_service_client The DevServiceClient entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DevServiceClient $_service_client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_client_delete', array('id' => $_service_client->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste service_client
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_service_client_manager->setFlash('error', 'Veuillez sélectionner un élément à supprimer');

                return $this->redirect($this->generateUrl('service_client_index'));
            }
            $_service_client_manager->deleteGroupDevServiceClient($_ids);
        }

        $_service_client_manager->setFlash('success', 'Eléments sélectionnés supprimés');

        return $this->redirect($this->generateUrl('service_client_index'));
    }

    /**
     * Afficher la page détail
     * @param Request $_request
     * @param DevServiceClient $_service_client
     * @return Render page
     */
    public function detailAction(Request $_request, DevServiceClient $_service_client)
    {
        // Récupérer manager
        $_service_client_manager        = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);
        $_service_client_jointe_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->get('security.token_storage')->getToken()->getUser();
        $_user_role      = $_user_connected->getTzRole()->getId();

        // Vérification utilisateur
        $_is_user_valid = $_service_client_manager->isUserValid($_service_client);
        if (!$_is_user_valid) {
            throw new AccessDeniedException('Vous ne pouvez pas faire cette action !');
        }

        // Récupérer le pièce jointe
        $_id_service_client      = $_service_client->getId();
        $_service_client_jointes = $_service_client_jointe_manager->getDevServiceClientJointeByServiceClient($_id_service_client);

        $_url_referer = $_request->headers->get('referer');

        $_template = 'AdminBundle:DevServiceClient:detail.html.twig';
        if ($_user_role == RoleName::ID_ROLE_CLIENT)
            $_template = 'AdminBundle:DevServiceClient:detail_espace_membre.html.twig';

        return $this->render($_template, array(
            'service_client'         => $_service_client,
            'service_client_jointes' => $_service_client_jointes,
            'url_referer'            => $_url_referer
        ));
    }

    /**
     * Ajax mise à jour statut validation du service
     * @param Request $_request
     * @return Render page
     */
    public function updateStatusValidationAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];
        $_id_status         = $_data['id_status'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_service_client_manager->setStatusValidationService($_service_client, $_id_status);

        $_status_name   = EtatServiceValidation::$VALEUR_TYPE[$_id_status];
        $_json_response = array('message' => $_status_name);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax annulation validation du service
     * @param Request $_request
     * @return Render page
     */
    public function cancelStatusValidationAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];
        $_id_status         = $_data['id_status'];
        $_comment           = $_data['comment'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_service_client_manager->cancelStatusValidationService($_service_client, $_comment);

        $_status_name   = EtatServiceValidation::$VALEUR_TYPE[$_id_status];
        $_json_response = array('message' => $_status_name);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax mise à jour statut projet du service
     * @param Request $_request
     * @return Render page
     */
    public function updateStatusProjectAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];
        $_id_status         = $_data['id_status'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_service_client_manager->setStatusProjectService($_service_client, $_id_status);

        $_status_name   = EtatServiceProject::$VALEUR_TYPE[$_id_status];
        $_json_response = array('message' => $_status_name);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax afficher tout les options services par service
     * @param Request $_request
     * @return Render page
     */
    public function listServiceOptionAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_option_manager = $this->get(ServiceName::SRV_METIER_SERVICE_OPTION);

        // Récupérer les données formulaire
        $_post       = $_request->request->all();
        $_id_service = $_post['id_service'];

        $_service_options = $_service_option_manager->getDevServiceOptionByService($_id_service);

        return $_service_options;
    }

    /**
     * Ajax prix commande
     * @param Request $_request
     * @return string
     */
    public function prixCommandeAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_order_manager = $this->get(ServiceName::SRV_METIER_ORDER);

        // Récupérer les données formulaire
        $_post                      = $_request->request->all();
        $_data                      = [];
        $_data['id_service']        = (!empty($_post['id_service']))?$_post['id_service']:1;
        $_data['nbr_page_integrer'] = (!empty($_post['nbr_page_integrer']))?$_post['nbr_page_integrer']:1;
        $_data['nbr_page_decline']  = (!empty($_post['nbr_page_decline']))?$_post['nbr_page_decline']:0;
        $_data['service_option']    = (!empty($_post['service_option']))?$_post['service_option']:[];

        // Récupérer la récapitulation service avec prix
        $_resume_order = $_order_manager->getResumeOrder($_data);
        $_prix         = $_resume_order['prix'];

        return new JsonResponse($_prix);
    }

    /**
     * Ajax email compte espace client
     * @param Request $_request
     * @return Render page
     */
    public function sendEmailConnexionClientAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_user           = $_service_client->getLvUser();
        $_is_email_sent  = $_service_client_manager->sendEmailConnexionClient($_user);

        $_json_response = array('status' => $_is_email_sent);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax lien livré validation du service
     * @param Request $_request
     * @return Render page
     */
    public function lienLivreStatusValidationAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];
        $_id_status         = $_data['id_status'];
        $_lien_livre        = $_data['lien_livre'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_service_client_manager->lienLivreStatusValidationService($_service_client, $_lien_livre);

        $_status_name   = EtatServiceValidation::$VALEUR_TYPE[$_id_status];
        $_json_response = array('message' => $_status_name);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax finalisation validation du service
     * @param Request $_request
     * @return Render page
     */
    public function finaliseStatusValidationAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];
        $_id_status         = $_data['id_status'];
        $_lien_code_source  = $_data['lien_code_source'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_service_client_manager->finaliseStatusValidationService($_service_client, $_lien_code_source);

        $_status_name   = EtatServiceValidation::$VALEUR_TYPE[$_id_status];
        $_json_response = array('message' => $_status_name);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax email confirmation paiement client
     * @param Request $_request
     * @return Render page
     */
    public function sendEmailConfirmationPaiementAjaxAction(Request $_request)
    {
        // Récupérer manager
        $_service_client_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT);
        $_facture_manager        = $this->get(ServiceName::SRV_METIER_FACTURE);

        // Récupération données formulaires
        $_data              = $_request->request->all();
        $_id_service_client = $_data['id_service_client'];

        $_service_client = $_service_client_manager->getDevServiceClientById($_id_service_client);
        $_is_email_sent  = $_facture_manager->sendEmail($_service_client);

        $_json_response = array('status' => $_is_email_sent);

        return new JsonResponse($_json_response);
    }

    /**
     * Ajax suppression fichier
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteFileAjaxAction(Request $_request) {
        // Récupérer manager
        $_service_client_jointe_manager = $this->get(ServiceName::SRV_METIER_SERVICE_CLIENT_JOINTE);

        // Récuperation identifiant fichier
        $_data = $_request->request->all();
        $_id   = $_data['id'];

        // Suppression fichier image
        $_service_client_jointe = $_service_client_jointe_manager->getDevServiceClientJointeById($_id);
        $_response              = $_service_client_jointe_manager->deleteJointe($_service_client_jointe);

        return new JsonResponse($_response);
    }
}