<?php
namespace App\Enum;

use App\Enum\EnumType;

class EnumGenderType extends EnumType
{
    protected $name = 'enumgender';
    protected $values = array('Femme', 'Homme', 'Non spécifié');
}
