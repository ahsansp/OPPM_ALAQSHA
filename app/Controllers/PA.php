<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Kobong;

class PA extends BaseController
{
    public function index()
    {
        $kobongModel = new Kobong();
        $kobong = $kobongModel->findAll();
        $data = [
            'kobong' => $kobong
        ];
        return view('Form/PA',$data);
        // return view('Form/PA');
    }
}
