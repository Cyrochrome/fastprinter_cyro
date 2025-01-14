<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\CyroUtils;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    protected $useAutoIncrement = false;
    protected $returnType = \App\Entities\Product::class;

    protected $allowedFields = ['product_name', 'product_price', 'category_id', 'status_id'];

    protected $beforeInsert = ['generateId'];

    protected function generateId(array $data)
    {
        $utils = new CyroUtils();
        $productModel = new ProductModel();

        $newId = $utils->generateRandomID('PRD');
        $searchResult = $productModel->find($newId);

        if ($searchResult !== null) {
            $newId = $utils->generateRandomID('PRD');
        }

        $data['data']['product_id'] = $newId;

        return $data;
    }
}
