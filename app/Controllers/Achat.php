<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Achat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Achat_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // Cette page doit être ouverte après le choix de la caisse.
        // La caisse choisie doit être gardée dans la session.
        $id_caisse = $this->session->userdata('id_caisse');

        if (!$id_caisse) {
            // Change "caisse" par le nom de ton contrôleur de choix de caisse.
            redirect('caisse');
            return;
        }

        $numero_ticket = $this->session->userdata('numero_ticket');

        $data['caisse'] = $this->Achat_model->get_caisse($id_caisse);
        $data['produits'] = $this->Achat_model->get_produits();
        $data['numero_ticket'] = $numero_ticket;
        $data['lignes_achat'] = [];
        $data['total'] = 0;

        if ($numero_ticket) {
            $data['lignes_achat'] = $this->Achat_model->get_achat_en_cours($numero_ticket);
            $data['total'] = $this->Achat_model->total_achat_en_cours($numero_ticket);
        }

        $this->load->view('achat/saisie', $data);
    }

    public function ajouter()
    {
        $id_caisse = $this->session->userdata('id_caisse');

        if (!$id_caisse) {
            redirect('caisse');
            return;
        }

        $numero_ticket = $this->session->userdata('numero_ticket');

        if (!$numero_ticket) {
            $numero_ticket = $this->Achat_model->generer_numero_ticket();
            $this->session->set_userdata('numero_ticket', $numero_ticket);
        }

        $id_produit = $this->input->post('id_produit');
        $quantite = (int) $this->input->post('quantite');

        $resultat = $this->Achat_model->ajouter_ligne_achat(
            $numero_ticket,
            $id_caisse,
            $id_produit,
            $quantite
        );

        if ($resultat['success']) {
            $this->session->set_flashdata('success', $resultat['message']);
        } else {
            $this->session->set_flashdata('error', $resultat['message']);
        }

        redirect('achat');
    }

    public function cloturer()
    {
        $numero_ticket = $this->session->userdata('numero_ticket');

        if (!$numero_ticket) {
            $this->session->set_flashdata('error', 'Aucun achat en cours à clôturer.');
            redirect('achat');
            return;
        }

        $ok = $this->Achat_model->cloturer_achat($numero_ticket);

        if ($ok) {
            $this->session->unset_userdata('numero_ticket');
            $this->session->set_flashdata('success', 'Achat clôturé. La caisse est prête pour le prochain client.');
        } else {
            $this->session->set_flashdata('error', 'Impossible de clôturer cet achat.');
        }

        redirect('achat');
    }
}
