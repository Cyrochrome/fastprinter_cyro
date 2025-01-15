<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\CyroUtils;

class ProductStatusModel extends Model
{
    protected $table = 'product__status';
    protected $primaryKey = 'status_id';

    protected $useAutoIncrement = false;  // No auto-increment since we're using UUID
    protected $returnType = \App\Entities\ProductStatus::class;

    protected $allowedFields = ['status_id', 'status_name'];

    protected $beforeInsert = ['generateId'];

    /**
     * Generates a unique ID before insertion.
     *
     * @param array $data Insertion data.
     * @return array Updated data with generated ID.
     */
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
            $newId = $utils->generateRandomID('STT');
        } while ($this->find($newId) !== null);

        $data['data']['status_id'] = $newId;

        return $data;
    }

    /**
     * Ensures a status exists in the database.
     *
     * @param string $statusName
     * @return string The ID of the status.
     */
    public function ensureStatus(string $statusName): string
    {
        // Check if the status already exists
        $existingStatus = $this->where('status_name', $statusName)->first();

        if ($existingStatus) {
            return $existingStatus->status_id; // Return existing status ID
        }

        // Create a new status if it doesn't exist
        $data = [
            'status_name' => $statusName,
        ];

        // Start the transaction
        $this->db->transStart();

        // Attempt to insert the new status
        $this->save($data);

        // Complete the transaction
        $this->db->transComplete();

        // Log transaction status
        if (!$this->db->transStatus()) {
            log_message('error', "Failed to insert new status: $statusName");
            throw new \RuntimeException("Failed to insert new status: $statusName");
        }

        // Return the new status_id (auto-generated UUID)
        return $this->getInsertID();
    }
}
