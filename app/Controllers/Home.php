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
        // Fetch data from the models
        $products = $this->productModel->findAll();
        $productCategories = $this->productCategoryModel->findAll();
        $productStatuses = $this->productStatusModel->findAll();

        // Organize the data into a usable format
        $organizedList = [];
        foreach ($products as $product) {
            // Find the category name based on category_id
            $category = array_filter($productCategories, function ($category) use ($product) {
                return $category->category_id === $product->category_id;
            });
            $categoryName = reset($category)->category_name ?? 'Unknown Category'; // Default to 'Unknown Category' if not found

            // Find the status name based on status_id
            $status = array_filter($productStatuses, function ($status) use ($product) {
                return $status->status_id === $product->status_id;
            });
            $statusName = reset($status)->status_name ?? 'Unknown Status'; // Default to 'Unknown Status' if not found

            // Add the organized product information to the list
            array_push($organizedList, [
                'productId' => $product->product_id,
                'productName' => $product->product_name,
                'productPrice' => $product->product_price,
                'productCategory' => $categoryName,
                'productStatus' => $statusName,
            ]);
        }
        $organizedCategories = array_map(function ($category) {
            return [
                'categoryId' => $category->category_id,
                'categoryName' => $category->category_name
            ];
        }, $productCategories);
        $organizedStatuses = array_map(function ($status) {
            return [
                'statusId' => $status->status_id,
                'statusName' => $status->status_name
            ];
        }, $productStatuses);
        // Prepare data for the view
        $data = [
            'title' => "Fast Print Tes by Marshalinas Yustiawan",
            'description' => "Ini adalah program tes yang dibuat menggunkan PHP oleh Marshalinas",
            'products' => $organizedList,
            'productCategories' => $organizedCategories,
            'productStatuses' => $organizedStatuses
        ];
        // Load the view with the data
        return view('home', $data);
    }

    public function createProduct()
    {
        $data = $this->request->getPost();

        if (!$data) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
        }
        // Validation rules
        $validationRules = [
            'productName'  => 'required|string|max_length[255]',
            'productPrice' => 'required|numeric|is_natural',
            'productCategory'   => 'required|string|exact_length[40]',
            'productStatus'     => 'required|string|exact_length[40]',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return error
            return $this->response->setStatusCode(200)->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        try {
            $product = new \App\Entities\Product([
                'product_name'  => $data['productName'],
                'product_price' => $data['productPrice'],
                'category_id'   => $data['productCategory'],
                'status_id'     => $data['productStatus'],
            ]);

            $this->productModel->save($product);

            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
        }
    }

    public function updateProduct($id)
    {
        $data = $this->request->getRawInput();

        if (!$data) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false, 'data' => $data]);
        }

        // Validation rules
        $validationRules = [
            'productName'  => 'required|string|max_length[255]',
            'productPrice' => 'required|numeric|is_natural',
            'productCategory'   => 'required|string|exact_length[40]',
            'productStatus'     => 'required|string|exact_length[40]',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return error
            return $this->response->setStatusCode(200)->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        try {
            $this->productModel->update($id, [
                'product_name'  => $data['productName'],
                'product_price' => $data['productPrice'],
                'category_id'   => $data['productCategory'],
                'status_id'     => $data['productStatus'],
            ]);

            return $this->response->setStatusCode(200)->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $this->productModel->delete($id);

            return $this->response->setStatusCode(200)->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
        }
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
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
        }

        // Decode the response body
        $responseData = json_decode($response->getBody(), true);

        // Validate the response format
        if (!isset($responseData['data']) || !is_array($responseData['data'])) {
            return $this->response->setStatusCode(200)->setJSON(['success' => false]);
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
            $cleanedProductName = trim($productData['product_name']);
            $existingProduct = $this->productModel
                ->where('LOWER(TRIM(product_name))', strtolower($cleanedProductName))
                ->first();

            try {
                if ($existingProduct) {
                    // Update the existing product
                    $this->productModel->update($existingProduct->product_id, $productData);
                } else {
                    // Insert a new product
                    $this->productModel->save($productData);
                }
            } catch (\Exception $e) {
                return $this->response->setStatusCode(200)->setJSON(['success' => false]);
            }
        }
        return $this->response->setStatusCode(200)->setJSON(['success' => true]);
    }
}
