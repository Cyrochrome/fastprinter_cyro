<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RawData extends Entity
{
    protected $attributes = [
        'product_id' => null,
        'product_name' => null,
        'produxt_price' => null,
        'kategori' => null,
        'harga' => null,
        'status' => null
    ];
}
