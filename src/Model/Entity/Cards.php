<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Cards extends Entity
{
    protected $_accessible = [
        "name" => true,
        "email" => true,
        "phone_no" => true
    ];
}

?>