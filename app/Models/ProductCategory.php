<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\CyroUtils;

class ProductCategoryModel extends Model
{
    protected $table = 'product__category';
    protected $primaryKey = 'category_id';

    protected $useAutoIncrement = false;
    protected $returnType = \App\Entities\ProductCategory::class;

    protected $allowedFields = ['category_name'];

    protected $beforeInsert = ['generateId'];

    protected function generateId(array $data)
    {
        $utils = new CyroUtils();
        $productCategoryModel = new ProductCategoryModel();

        $newId = $utils->generateRandomID('CAT');
        $searchResult = $productCategoryModel->find($newId);

        if ($searchResult !== null) {
            $newId = $utils->generateRandomID('CAT');
        }

        $data['data']['category_id'] = $newId;

        return $data;
    }
}
