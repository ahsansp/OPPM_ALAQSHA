<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AccountControl extends BaseController
{
    public function index()
    {
        return view("/account_control");
    }
}
