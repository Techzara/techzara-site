<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class EtatServiceValidation
 * Classe qui contient les valeurs constante des états du service
 */
class EtatServiceValidation
{
    const ID_ANALYSE = 0;
    const ID_BON_COMMANDE = 1;
    const ID_FICHIER_NON_CONFORME = 2;
    const ID_AJUSTEMENT_PANIER_COMMANDE = 3;
    const ID_DEVELOPPEMENT = 4;
    const ID_TEST = 5;
    const ID_LIEN_LIVRE = 6;
    const ID_FINALISE = 7;

    static $TYPE_VALEUR = array(
        'Analyse'                       => 0,
        'Bon commande'                  => 1,
        'Fichiers non conforme'         => 2,
        'Ajustement panier de commande' => 3,
        'Développement'                 => 4,
        'Tests'                         => 5,
        'Lien livré'                    => 6,
        'Finalisé'                      => 7
    );

    static $VALEUR_TYPE = array(
        0 => 'Analyse',
        1 => 'Bon commande',
        2 => 'Fichiers non conforme',
        3 => 'Ajustement panier de commande',
        4 => 'Développement',
        5 => 'Tests',
        6 => 'Lien livré',
        7 => 'Finalisé'
    );
}
