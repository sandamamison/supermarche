<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Achat;
use App\Models\Produit;
use App\Models\Caisse;
use Config\Database;

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
            'achats'    => $model_achat->where('id_caisse', $caisse_id)->findAll(),
            'produits'  => $model_produit->where('quantite_stock >', 0)->findAll(),
            'caisse'    => $model_caisse->find($caisse_id),
        ];

        return view('achats', $data);
    }

    public function cloturer()
    {
        $caisse_id = session()->get('id_caisse');

        if (empty($caisse_id)) {
            return redirect()->to('/')->with('error', 'Veuillez choisir une caisse avant de faire un achat.');
        }

        $produitsPostes = $this->request->getPost('produits');

        if (empty($produitsPostes) || !is_array($produitsPostes)) {
            return redirect()->to('/achats')->with('error', 'Aucun produit dans l’achat en cours.');
        }

        $produitModel = new Produit();
        $achatModel = new Achat();

        // Regrouper les mêmes produits pour éviter les erreurs de stock
        $panier = [];
        foreach ($produitsPostes as $ligne) {
            $idProduit = isset($ligne['id_produit']) ? (int) $ligne['id_produit'] : 0;
            $quantite = isset($ligne['quantite']) ? (int) $ligne['quantite'] : 0;

            if ($idProduit <= 0 || $quantite <= 0) {
                return redirect()->to('/achats')->with('error', 'Produit ou quantité invalide.');
            }

            if (!isset($panier[$idProduit])) {
                $panier[$idProduit] = 0;
            }

            $panier[$idProduit] += $quantite;
        }

        $numeroTicket = 'TICKET-' . date('Ymd-His') . '-' . random_int(100, 999);
        $lignesAInserer = [];
        $db = Database::connect();

        $db->transBegin();

        foreach ($panier as $idProduit => $quantite) {
            $produit = $produitModel->find($idProduit);

            if (!$produit) {
                $db->transRollback();
                return redirect()->to('/achats')->with('error', 'Un produit sélectionné est introuvable.');
            }

            if ((int) $produit['quantite_stock'] < $quantite) {
                $db->transRollback();
                return redirect()->to('/achats')->with(
                    'error',
                    'Stock insuffisant pour le produit : ' . $produit['designation']
                );
            }

            $prixUnitaire = (float) $produit['prix'];
            $montantLigne = $prixUnitaire * $quantite;

            $lignesAInserer[] = [
                'numero_ticket' => $numeroTicket,
                'id_caisse'     => $caisse_id,
                'id_produit'    => $idProduit,
                'quantite'      => $quantite,
                'prix_unitaire' => $prixUnitaire,
                'montant_ligne' => $montantLigne,
                'date_achat'    => date('Y-m-d H:i:s'),
            ];

            $nouveauStock = (int) $produit['quantite_stock'] - $quantite;
            $produitModel->update($idProduit, ['quantite_stock' => $nouveauStock]);
        }

        if (!$achatModel->insertBatch($lignesAInserer)) {
            $db->transRollback();
            return redirect()->to('/achats')->with('error', 'Impossible d’enregistrer l’achat.');
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->to('/achats')->with('error', 'Impossible de clôturer l’achat.');
        }

        $db->transCommit();

        // Le panier était côté navigateur : après redirection, la liste redevient vide automatiquement.
        return redirect()->to('/achats')->with(
            'success',
            'Achat clôturé avec succès. Ticket : ' . $numeroTicket . '. Nouvelle liste prête pour le prochain client.'
        );
    }
}
