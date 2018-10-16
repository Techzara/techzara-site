<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class RoleName
 * Classe qui contient les noms constante des rôles utilisateur
 */
class RoleName
{
    // Nom rôle
    const ROLE_SUPER_ADMINISTRATEUR     = 'ROLE_SUPERADMIN';
    const ROLE_MEMBRES                  = 'ROLE_MEMBRES';
    const ROLE_PARTENAIRES              = 'ROLE_PARTENAIRES';
    const ROLE_ADMINISTRATEUR           = 'ROLE_ADMIN';

    // Identifiant rôle
    const ID_ROLE_SUPERADMIN  = 0;
    const ID_ROLE_ADMIN       = 1;
    const ID_ROLE_PARTENAIRES = 2;
    const ID_ROLE_MEMBRES     = 3;

    static $ROLE_TYPE = array(
        'Superadmin'      => 'ROLE_SUPERADMIN',
        'Admin'           => 'ROLE_ADMIN',
        'Patenaires'      => 'ROLE_PARTENAIRES',
        'Membres'         => 'ROLE_MEMBRES',
    );
}
