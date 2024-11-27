<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Account;

class Auth extends BaseController
{
    public function index()
    {
        return view('Login/login');
    }
    public function checkLogin()
    {
        // dd(session());
        $session = session();
        $db = new Account();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $db->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = $password == $pass;
            // dd($verify_pass, $password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'username' => $data['username'],
                    'role' => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username not Found');
            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
