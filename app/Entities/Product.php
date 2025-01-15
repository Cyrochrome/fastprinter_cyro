<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $attributes = [
        'product_id' => null,
        'product_name' => null,
        'product_price' => null,
        'category_id' => null,
        'status_id' => null
    ];
    
}
