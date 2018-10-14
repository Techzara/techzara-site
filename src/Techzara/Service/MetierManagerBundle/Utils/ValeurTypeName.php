<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class ValeurTypeName
 * Classe qui contient les noms constante des types valeur
 */
class ValeurTypeName
{
    const ID_GRATUIT     = 0;
    const ID_EURO        = 1;
    const ID_POURCENTAGE = 2;

    static $TYPE_VALEUR = array(
        'Gratuit'     => 0,
        'Euro'        => 1,
        'Pourcentage' => 2
    );
}
