<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\CyroUtils;

class ProductStatusModel extends Model
{
    protected $table = 'product__status';
    protected $primaryKey = 'status_id';

    protected $useAutoIncrement = false;
    protected $returnType = \App\Entities\ProductStatus::class;

    protected $allowedFields = ['status_name'];

    protected $beforeInsert = ['generateId'];

    protected function generateId(array $data)
    {
        $utils = new CyroUtils();
        $productStatusModel = new ProductStatusModel();

        $newId = $utils->generateRandomID('STT');
        $searchResult = $productStatusModel->find($newId);

        if ($searchResult !== null) {
            $newId = $utils->generateRandomID('STT');
        }

        $data['data']['status_id'] = $newId;

        return $data;
    }
}
