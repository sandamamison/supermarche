<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Achat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_produits()
    {
        return $this->db
            ->where('quantite_stock >', 0)
            ->order_by('designation', 'ASC')
            ->get('produit')
            ->result_array();
    }

    public function get_produit($id_produit)
    {
        return $this->db
            ->where('id_produit', $id_produit)
            ->get('produit')
            ->row_array();
    }

    public function get_caisse($id_caisse)
    {
        return $this->db
            ->where('id_caisse', $id_caisse)
            ->get('caisse')
            ->row_array();
    }

    public function generer_numero_ticket()
    {
        return 'TICKET-' . date('Ymd-His') . '-' . rand(100, 999);
    }

    public function ajouter_ligne_achat($numero_ticket, $id_caisse, $id_produit, $quantite)
    {
        $produit = $this->get_produit($id_produit);

        if (!$produit) {
            return [
                'success' => false,
                'message' => 'Produit introuvable.'
            ];
        }

        if ($quantite <= 0) {
            return [
                'success' => false,
                'message' => 'La quantité doit être supérieure à 0.'
            ];
        }

        if ($produit['quantite_stock'] < $quantite) {
            return [
                'success' => false,
                'message' => 'Stock insuffisant pour ce produit.'
            ];
        }

        $prix_unitaire = $produit['prix'];
        $montant_ligne = $prix_unitaire * $quantite;

        $this->db->trans_start();

        $this->db->insert('achat', [
            'numero_ticket' => $numero_ticket,
            'id_caisse' => $id_caisse,
            'id_produit' => $id_produit,
            'quantite' => $quantite,
            'prix_unitaire' => $prix_unitaire,
            'montant_ligne' => $montant_ligne,
            'statut' => 'en_cours'
        ]);

        $nouveau_stock = $produit['quantite_stock'] - $quantite;
        $this->db
            ->where('id_produit', $id_produit)
            ->update('produit', ['quantite_stock' => $nouveau_stock]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            return [
                'success' => false,
                'message' => 'Erreur lors de l’ajout de l’achat.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Produit ajouté à l’achat.'
        ];
    }

    public function get_achat_en_cours($numero_ticket)
    {
        return $this->db
            ->select('achat.*, produit.designation')
            ->from('achat')
            ->join('produit', 'produit.id_produit = achat.id_produit')
            ->where('achat.numero_ticket', $numero_ticket)
            ->where('achat.statut', 'en_cours')
            ->order_by('achat.id_achat', 'ASC')
            ->get()
            ->result_array();
    }

    public function total_achat_en_cours($numero_ticket)
    {
        $resultat = $this->db
            ->select_sum('montant_ligne', 'total')
            ->where('numero_ticket', $numero_ticket)
            ->where('statut', 'en_cours')
            ->get('achat')
            ->row_array();

        return $resultat && $resultat['total'] !== null ? $resultat['total'] : 0;
    }

    public function cloturer_achat($numero_ticket)
    {
        $this->db
            ->where('numero_ticket', $numero_ticket)
            ->where('statut', 'en_cours')
            ->update('achat', ['statut' => 'cloture']);

        return $this->db->affected_rows() > 0;
    }
}
