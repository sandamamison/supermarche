<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        session()->set('username', $username);
        return redirect()->to('/caisse');
    }

    public function logout()
    {
        session()->remove('username');
        session()->remove('id_caisse');
        return redirect()->to('/');
    }
}
