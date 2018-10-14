<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class RoleName
 * Classe qui contient les noms constante des rôles utilisateur
 */
class RoleName
{
    // Nom rôle
    const ROLE_SUPER_ADMINISTRATEUR = 'ROLE_SUPERADMIN';
    const ROLE_ADMINISTRATEUR       = 'ROLE_ADMIN';
    const ROLE_ADMINISTRATEUR_SITE  = 'ROLE_ADMIN_SITE';
    const ROLE_SUPERVISEUR          = 'ROLE_SUPERVISEUR';
    const ROLE_INTEGRATEUR          = 'ROLE_INTEGRATEUR';
    const ROLE_CLIENT               = 'ROLE_CLIENT';
    const ROLE_TESTEUR              = 'ROLE_TESTEUR';

    // Identifiant rôle
    const ID_ROLE_SUPERADMIN  = 1;
    const ID_ROLE_ADMIN       = 2;
    const ID_ROLE_SUPERVISEUR = 3;
    const ID_ROLE_INTEGRATEUR = 4;
    const ID_ROLE_CLIENT      = 5;
    const ID_ROLE_TESTEUR     = 6;
    const ID_ROLE_ADMIN_SITE  = 7;

    static $ROLE_TYPE = array(
        'Admin'       => 'ROLE_ADMIN',
        'Admin site'  => 'ROLE_ADMIN_SITE',
        'Superadmin'  => 'ROLE_SUPERADMIN',
        'Superviseur' => 'ROLE_SUPERVISEUR',
        'Integrateur' => 'ROLE_INTEGRATEUR',
        'Client'      => 'ROLE_CLIENT',
        'Testeur'     => 'ROLE_TESTEUR'
    );
}
