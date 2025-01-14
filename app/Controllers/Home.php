<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Exceptions\HTTPException;

class Home extends BaseController
{
    public function index(): string
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

        echo $response->getStatusCode();
        echo $response->getBody();
        return view('welcome_message');
    }
}
