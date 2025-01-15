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

   /**
     * Checks if a product with the same name exists, updates if found, inserts if not.
     * 
     * @param array $data Data to save or update.
     * @return bool True if the operation is successful, false otherwise.
     */
    public function saveOrUpdate(array $data)
    {
        // Check if a product with the same name exists
        $existingProduct = $this->where('product_name', $data['product_name'])->first();

        if ($existingProduct) {
            // Update existing product
            $existingProduct->fill($data);
            return $this->save($existingProduct);
        }

        // Insert new product
        $product = new \App\Entities\Product($data);
        return $this->save($product);
    }

    /**
     * Automatically generates a new product ID before insertion.
     * 
     * @param array $data Insertion data.
     * @return array Updated data with generated ID.
     */
    protected function generateId(array $data)
    {
        $utils = new CyroUtils();

        do {
            $newId = $utils->generateRandomID('PRD');
        } while ($this->find($newId) !== null);

        $data['data']['product_id'] = $newId;

        return $data;
    }
}
