<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Achat;
use App\Models\Produit;
use App\Models\Caisse;

class AchatController extends BaseController
{
    public function index()
    {
        $caisse_id = session()->get('id_caisse');

        if (empty($caisse_id)) {
            return redirect()->to('/');
        }

        $model_achat = new Achat();
        $model_produit = new Produit();
        $model_caisse = new Caisse();

        $data = [
            'caisse_id' => $caisse_id,
            'achats' => $model_achat->where('id_caisse', $caisse_id)->findAll(),
            'produits' => $model_produit->findAll(),
            'caisse' => $model_caisse->find($caisse_id)
        ];

        return view('achats', $data);
    }
}
