<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductStatusModel;

class Home extends BaseController
{
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
        echo "$username ";
        echo "$raw -> $hashed ";
        $response = $client->request("POST", 'https://recruitment.fastprint.co.id/tes/api_tes_programmer', ['form_params' => ['username' => $username, 'password' => $hashed], 'http_errors' => false]);
        echo $response->getBody();
        echo $response->getStatusCode();

        if ($response->getStatusCode() !== 200) {
            return redirect()->to('/');
        }

        $productModel = new ProductModel();
        $productCategoryModel = new ProductCategoryModel();
        $productStatusModel = new ProductStatusModel();

        return redirect()->to('/');
    }
}
