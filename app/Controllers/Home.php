<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductStatusModel;

class Home extends BaseController
{
    protected $productModel;
    protected $productCategoryModel;
    protected $productStatusModel;

    public function __construct()
    {
        // Initialize models
        $this->productModel = new ProductModel();
        $this->productCategoryModel = new ProductCategoryModel();
        $this->productStatusModel = new ProductStatusModel();
    }

    public function index(): string
    {
        return view('home');
    }

    public function fetchRawData()
    {
        $client = \Config\Services::curlrequest();
        helper('apiCreds');

        $username = generateAPIUsername();
        $password = generateAPIPassword();
        $raw = $password['raw'];
        $hashed = $password['hashed'];

        $response = $client->request("POST", 'https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'form_params' => ['username' => $username, 'password' => $hashed],
            'http_errors' => false
        ]);

        // Check response status code
        if ($response->getStatusCode() !== 200) {
            return redirect()->to('/')->with('error', 'Failed to fetch data from API.');
        }

        // Decode the response body
        $responseData = json_decode($response->getBody(), true);

        // Validate the response format
        if (!isset($responseData['data']) || !is_array($responseData['data'])) {
            return redirect()->to('/')->with('error', 'Invalid API response.');
        }

        // Extract the "data" part of the response
        $rawData = $responseData['data'];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                // Log invalid entries and skip them
                log_message('error', 'Invalid item format: ' . json_encode($item));
                continue;
            }

            // Map status to status_id
            $statusId = $this->productStatusModel->ensureStatus($item['status']);

            // Map category to category_id
            $categoryId = $this->productCategoryModel->ensureCategory($item['kategori']);

            // Prepare product data
            $productData = [
                'product_name'  => $item['nama_produk'],
                'product_price' => (int)$item['harga'],
                'category_id'   => $categoryId,
                'status_id'     => $statusId,
            ];

            // Check if the product exists
            $existingProduct = $this->productModel->where('product_name', $productData['product_name'])->first();
            if ($existingProduct) {
                // Update existing product
                $this->productModel->update($existingProduct->product_id, $productData);
            } else {
                // Insert new product
                $this->productModel->save($productData);
            }
        }

        return redirect()->to('/')->with('success', 'Data successfully processed.');
    }
}
