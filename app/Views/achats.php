<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie d’achat - Caisse <?= esc($caisse['numero_caisse'] ?? '--') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/supermarche.css') ?>">
</head>
<body>

<div class="app-shell">
    <header class="topbar">
        <div class="brand">
            <div class="brand-icon">🛒</div>
            <div>
                <h1 class="brand-title">Caisse Supermarché</h1>
                <p class="brand-subtitle">Saisie des achats</p>
            </div>
        </div>

        <div class="topbar-actions">
            <span class="caisse-badge">
                Caisse N° <?= esc($caisse['numero_caisse'] ?? '--') ?>
            </span>
            <span class="user-badge">
                Acheteur : <?= esc($nom_acheteur ?? session()->get('username') ?? '') ?>
            </span>
            <a href="<?= base_url('caisse') ?>" class="btn btn-light btn-small">Changer caisse</a>
            <a href="<?= base_url('logout') ?>" class="btn btn-danger-light btn-small">Fermer & Quitter</a>
        </div>
    </header>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <section class="page-header">
        <h2 class="page-title">Nouvel achat client</h2>
        <p class="page-subtitle">
            <?= esc($caisse['libelle'] ?? 'Caisse sélectionnée') ?> — ajoutez les produits au panier puis clôturez l’achat.
        </p>
    </section>

    <div class="grid-two">
        <section class="card">
            <h3 class="card-title">Ajouter un produit</h3>

            <form id="form-ajout">
                <div class="form-group">
                    <label for="id_produit">Produit</label>
                    <select name="id_produit" id="id_produit" required>
                        <option value="" data-prix="0" data-nom="" data-stock="0">-- Choisissez un produit --</option>
                        <?php if (!empty($produits) && is_array($produits)): ?>
                            <?php foreach ($produits as $produit): ?>
                                <option
                                    value="<?= esc($produit['id_produit']) ?>"
                                    data-prix="<?= esc($produit['prix']) ?>"
                                    data-nom="<?= esc($produit['designation']) ?>"
                                    data-stock="<?= esc($produit['quantite_stock'] ?? 0) ?>"
                                >
                                    <?= esc($produit['designation']) ?> — <?= number_format((float) $produit['prix'], 2, ',', ' ') ?> Ar
                                    <?php if (isset($produit['quantite_stock'])): ?>
                                        | Stock : <?= esc($produit['quantite_stock']) ?>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité</label>
                    <input type="number" name="quantite" id="quantite" min="1" value="1" required>
                    <small class="small-note" id="stock-info">Sélectionnez un produit pour voir le stock.</small>
                </div>

                <button type="button" id="btn-ajouter" class="btn btn-full">Ajouter au panier</button>
            </form>
        </section>

        <section class="card">
            <h3 class="card-title">Panier en cours</h3>

            <div class="form-group">
                <label>Nom de l’acheteur</label>
                <div class="buyer-box">
                    <?= esc($nom_acheteur ?? session()->get('username') ?? '') ?>
                </div>
                <small class="small-note">Ce nom vient directement du login.</small>
            </div>

            <form action="<?= base_url('achats/cloturer') ?>" method="post" id="form-cloture">
                <?= csrf_field() ?>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Prix U.</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-panier">
                            <tr id="ligne-vide">
                                <td colspan="5">
                                    <div class="empty-state">Aucun produit ajouté pour le moment.</div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;">Total général :</td>
                                <td class="total-text" id="total-general">0,00 Ar</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="hidden-panier"></div>

                <div class="cart-actions">
                    <button type="button" class="btn btn-light" id="btn-vider" disabled>Vider le panier</button>
                    <button type="submit" class="btn btn-success" id="btn-cloturer" disabled>Clôturer l’achat</button>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    let panier = [];

    const selectProduit = document.getElementById('id_produit');
    const inputQuantite = document.getElementById('quantite');
    const stockInfo = document.getElementById('stock-info');
    const btnAjouter = document.getElementById('btn-ajouter');
    const btnVider = document.getElementById('btn-vider');
    const btnCloturer = document.getElementById('btn-cloturer');
    const tbody = document.getElementById('table-panier');
    const hiddenPanier = document.getElementById('hidden-panier');
    const totalGeneral = document.getElementById('total-general');
    const nomAcheteur = <?= json_encode($nom_acheteur ?? session()->get('username') ?? '') ?>;

    selectProduit.addEventListener('change', function () {
        const option = selectProduit.options[selectProduit.selectedIndex];
        const stock = parseInt(option.getAttribute('data-stock') || '0');

        if (!selectProduit.value) {
            stockInfo.textContent = 'Sélectionnez un produit pour voir le stock.';
            return;
        }

        stockInfo.textContent = 'Stock disponible : ' + stock;
    });

    btnAjouter.addEventListener('click', function () {
        const idProduit = selectProduit.value;
        const quantite = parseInt(inputQuantite.value);
        const option = selectProduit.options[selectProduit.selectedIndex];

        if (!idProduit || quantite < 1) {
            alert('Veuillez sélectionner un produit et une quantité valide.');
            return;
        }

        const stock = parseInt(option.getAttribute('data-stock') || '0');
        const quantiteDejaDansPanier = panier
            .filter(item => item.id_produit === idProduit)
            .reduce((total, item) => total + item.quantite, 0);

        if ((quantiteDejaDansPanier + quantite) > stock) {
            alert('Stock insuffisant pour ce produit.');
            return;
        }

        const nom = option.getAttribute('data-nom');
        const prix = parseFloat(option.getAttribute('data-prix'));

        const itemExistant = panier.find(item => item.id_produit === idProduit);

        if (itemExistant) {
            itemExistant.quantite += quantite;
            itemExistant.total = itemExistant.quantite * itemExistant.prix;
        } else {
            panier.push({
                id_produit: idProduit,
                nom: nom,
                quantite: quantite,
                prix: prix,
                total: prix * quantite
            });
        }

        selectProduit.value = '';
        inputQuantite.value = 1;
        stockInfo.textContent = 'Sélectionnez un produit pour voir le stock.';
        mettreAJourAffichage();
    });

    btnVider.addEventListener('click', function () {
        if (panier.length === 0) {
            return;
        }

        if (confirm('Vider le panier en cours ?')) {
            panier = [];
            mettreAJourAffichage();
        }
    });

    function supprimerLigne(index) {
        panier.splice(index, 1);
        mettreAJourAffichage();
    }

    function mettreAJourAffichage() {
        tbody.innerHTML = '';
        hiddenPanier.innerHTML = '';

        if (panier.length === 0) {
            tbody.innerHTML = `
                <tr id="ligne-vide">
                    <td colspan="5">
                        <div class="empty-state">Aucun produit ajouté pour le moment.</div>
                    </td>
                </tr>
            `;
        }

        panier.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${escapeHtml(item.nom)}</td>
                <td>${item.quantite}</td>
                <td>${formatMontant(item.prix)} Ar</td>
                <td><strong>${formatMontant(item.total)} Ar</strong></td>
                <td>
                    <button type="button" class="btn btn-danger-light btn-small" onclick="supprimerLigne(${index})">Supprimer</button>
                </td>
            `;
            tbody.appendChild(tr);

            hiddenPanier.insertAdjacentHTML('beforeend', `
                <input class="produit-input" type="hidden" name="produits[${index}][id_produit]" value="${item.id_produit}">
                <input class="produit-input" type="hidden" name="produits[${index}][quantite]" value="${item.quantite}">
                <input class="produit-input" type="hidden" name="produits[${index}][prix_unitaire]" value="${item.prix}">
            `);
        });

        const total = panier.reduce((somme, item) => somme + item.total, 0);
        totalGeneral.textContent = formatMontant(total) + ' Ar';
        btnCloturer.disabled = panier.length === 0;
        btnVider.disabled = panier.length === 0;
    }

    document.getElementById('form-cloture').addEventListener('submit', function (event) {
        if (panier.length === 0) {
            event.preventDefault();
            alert('Aucun produit à clôturer.');
            return;
        }

        if (!confirm('Clôturer cet achat pour ' + nomAcheteur + ' ?')) {
            event.preventDefault();
        }
    });

    function formatMontant(montant) {
        return montant.toLocaleString('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>

</body>
</html>
