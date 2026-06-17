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
        $username = trim((string) $this->request->getPost('username'));

        if ($username === '') {
            return redirect()->to('/')->with('error', 'Veuillez entrer votre nom.');
        }

        session()->set('username', $username);
        session()->remove('id_caisse');

        return redirect()->to('/caisse');
    }

    public function logout()
    {
        session()->remove('username');
        session()->remove('id_caisse');
        return redirect()->to('/');
    }
}
