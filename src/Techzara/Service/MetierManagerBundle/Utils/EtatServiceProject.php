<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class EtatServiceProject
 * Classe qui contient les valeurs constante des états du service
 */
class EtatServiceProject
{
    const ID_EN_ATTENTE = 0;
    const ID_ENCOURS    = 1;
    const ID_TERMINE    = 2;
    const ID_TESTE      = 3;

    static $TYPE_VALEUR = array(
        'En attente' => 0,
        'En cours'   => 1,
        'Terminé'    => 2,
        'Testé'      => 3
    );

    static $VALEUR_TYPE = array(
        0 => 'En attente',
        1 => 'En cours',
        2 => 'Terminé',
        3 => 'Testé'
    );
}
