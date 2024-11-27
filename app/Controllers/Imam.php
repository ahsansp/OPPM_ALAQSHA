<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Imam extends BaseController
{
    public function index()
    {
        return view('Form/imam');
    }
}
