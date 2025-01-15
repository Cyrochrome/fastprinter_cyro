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

    /**
     * Generates a unique ID before insertion.
     *
     * @param array $data Insertion data.
     * @return array Updated data with generated ID.
     */
    protected function generateId(array $data)
    {
        $utils = new CyroUtils();

        do {
            $newId = $utils->generateRandomID('CAT');
        } while ($this->find($newId) !== null);

        $data['data']['category_id'] = $newId;

        return $data;
    }

    /**
     * Ensures a category exists in the database.
     *
     * @param string $categoryName
     * @return string The ID of the category.
     */
    public function ensureCategory(string $categoryName): string
    {
        // Check if the category already exists
        $existingCategory = $this->where('category_name', $categoryName)->first();

        if ($existingCategory) {
            return $existingCategory->category_id; // Return existing ID
        }

        // Create a new category if it doesn't exist
        $newCategory = ['category_name' => $categoryName];

        $this->db->transStart(); // Start a transaction

        $this->save($newCategory);

        $this->db->transComplete(); // Commit transaction

        if (!$this->db->transStatus()) {
            throw new \RuntimeException("Failed to insert new category: $categoryName");
        }

        // Return the newly generated ID (ensure the ID is from the inserted row)
        return $this->where('category_name', $categoryName)->first()->category_id;
    }


    /**
     * Retrieves the ID of the last inserted category.
     *
     * @return string The last inserted category ID.
     */
    public function getInsertID(): string
    {
        return $this->db->insertID(); // Retrieve the last inserted ID
    }
}
