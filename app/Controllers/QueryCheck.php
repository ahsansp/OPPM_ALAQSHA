<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class QueryCheck extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        dd($db->getLastQuery());
    }
}
