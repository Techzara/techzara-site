<?php

namespace App\Techzara\Service\MetierManagerBundle\Utils;

/**
 * Class EtatFactureName
 * Classe qui contient les valeurs constante des états du facture
 */
class EtatFactureName
{
    const ID_EN_ATTENTE = 0;
    const ID_ENVOYE     = 1;
    const ID_NON_ENVOYE = 2;
    const ID_REFUSE     = 3;

    static $TYPE_VALEUR = array(
        'En attente' => 0,
        'Envoyé'     => 1,
        'Non envoyé' => 2,
        'Refusé'     => 3
    );

    static $VALEUR_TYPE = array(
        0 => 'En attente',
        1 => 'Envoyé',
        2 => 'Non envoyé',
        3 => 'Refusé'
    );
}
