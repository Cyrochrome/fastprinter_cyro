<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProductCategory extends Entity
{
    protected $attributes = [
        'category_id' => null,
        'category_name' => null,
    ];
}
