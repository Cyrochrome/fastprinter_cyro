<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductStatus extends Entity
{
    protected $attributes = [
        'status_id' => null,
        'status_name' => null,
    ];
}
