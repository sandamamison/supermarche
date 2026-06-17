<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des achats</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card mb-3">
        <div class="card-body">
            <h3 class="mb-1">Page de saisie des achats</h3>

            <?php if (!empty($caisse)) { ?>
                <p class="mb-0">
                    <strong>Caisse choisie :</strong>
                    <?php echo htmlspecialchars($caisse['numero_caisse']); ?> -
                    <?php echo htmlspecialchars($caisse['libelle']); ?>
                </p>
            <?php } ?>

            <?php if (!empty($numero_ticket)) { ?>
                <p class="mb-0">
                    <strong>Ticket en cours :</strong>
                    <?php echo htmlspecialchars($numero_ticket); ?>
                </p>
            <?php } else { ?>
                <p class="mb-0 text-muted">Aucun ticket en cours. Le ticket sera créé au premier produit ajouté.</p>
            <?php } ?>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php } ?>

    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>

    <!-- PARTIE 6 : saisie des achats -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Ajouter un produit à l’achat
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo site_url('achat/ajouter'); ?>">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label for="id_produit" class="form-label">Produit</label>
                        <select name="id_produit" id="id_produit" class="form-select" required>
                            <option value="">-- Choisir un produit --</option>
                            <?php foreach ($produits as $produit) { ?>
                                <option value="<?php echo $produit['id_produit']; ?>">
                                    <?php echo htmlspecialchars($produit['designation']); ?>
                                    - Prix : <?php echo number_format($produit['prix'], 0, ',', ' '); ?> Ar
                                    - Stock : <?php echo $produit['quantite_stock']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PARTIE 7 : affichage achat en cours -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Achat en cours
        </div>
        <div class="card-body">
            <?php if (empty($lignes_achat)) { ?>
                <p class="text-muted">Aucun produit ajouté pour le moment.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lignes_achat as $ligne) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ligne['designation']); ?></td>
                                    <td><?php echo number_format($ligne['prix_unitaire'], 0, ',', ' '); ?> Ar</td>
                                    <td><?php echo $ligne['quantite']; ?></td>
                                    <td><?php echo number_format($ligne['montant_ligne'], 0, ',', ' '); ?> Ar</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total général</th>
                                <th><?php echo number_format($total, 0, ',', ' '); ?> Ar</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <form method="post" action="<?php echo site_url('achat/cloturer'); ?>" onsubmit="return confirm('Clôturer cet achat ?');">
                    <button type="submit" class="btn btn-success">
                        Clôturer achat
                    </button>
                </form>
            <?php } ?>
        </div>
    </div>

</div>

</body>
</html>
