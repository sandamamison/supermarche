<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Caisse;
class CaisseController extends BaseController
{
    public function index()
    {
        $caisseModel = new Caisse();
        $caisses = $caisseModel->findAll();

        $data = [
            'caisses' => $caisses
        ];
        return view('caisse/index', $data);
    }

    public function choisir()
    {
        $idCaisse = $this->request->getPost('id_caisse');

        if ($idCaisse) {
            // Enregistrer l'ID de la caisse dans la session
            session()->set('id_caisse', $idCaisse);
            return redirect()->to('/achats');
        }

        // Si aucune caisse n'a été choisie, on redirige avec une erreur (optionnel)
        return redirect()->back()->with('error', 'Veuillez sélectionner une caisse.');
    }
}
