<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Kobong;

class PT extends BaseController
{
    public function index()
    {
        $data = [];
        return view('Form/PT',$data);
        // return view('Form/PA');
    }
}
