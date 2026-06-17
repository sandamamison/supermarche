<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie d'achat - Caisse <?= esc($caisse['numero_caisse']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
            color: #334155;
        }
        .header-bar {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        .caisse-info h2 {
            margin: 0;
            color: #0f172a;
            font-size: 24px;
        }
        .caisse-info p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 14px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }
        .card-title {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #475569;
            font-size: 14px;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        select:focus, input[type="number"]:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }
        th {
            font-weight: 600;
            color: #64748b;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            font-size: 15px;
            color: #334155;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
            font-size: 15px;
        }
        .alert {
            max-width: 1000px;
            margin: 0 auto 20px auto;
            padding: 14px 18px;
            border-radius: 8px;
            font-weight: 600;
        }
        .alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="header-bar">
        <div class="caisse-info">
            <h2>Caisse N° <?= esc($caisse['numero_caisse'] ?? '--') ?></h2>
            <p><?= esc($caisse['libelle'] ?? '') ?></p>
        </div>
        <div>
            <!-- Bouton pour quitter la caisse -->
            <a href="<?= base_url('/') ?>" style="color: #ef4444; text-decoration: none; font-weight: 600; font-size: 14px; padding: 8px 16px; border-radius: 6px; background: #fef2f2; transition: background 0.2s;">
                Fermer & Quitter
            </a>
        </div>
    </div>

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

    <div class="container">
        <!-- Colonne Gauche : Formulaire d'ajout -->
        <div class="card">
            <h3 class="card-title">Ajouter un produit</h3>
            <form id="form-ajout">
                <div class="form-group">
                    <label for="id_produit">Sélectionner un produit</label>
                    <select name="id_produit" id="id_produit" required>
                        <option value="" data-prix="0" data-nom="">-- Choisissez un produit --</option>
                        <?php if (!empty($produits) && is_array($produits)): ?>
                            <?php foreach ($produits as $produit): ?>
                                <option value="<?= esc($produit['id_produit']) ?>" 
                                        data-prix="<?= esc($produit['prix']) ?>"
                                        data-nom="<?= esc($produit['designation']) ?>">
                                    <?= esc($produit['designation']) ?> 
                                    (<?= number_format($produit['prix'], 2, ',', ' ') ?> Ar)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité</label>
                    <input type="number" name="quantite" id="quantite" min="1" value="1" required>
                </div>

                <button type="button" id="btn-ajouter" class="btn">Ajouter au panier</button>
            </form>
        </div>

        <!-- Colonne Droite : Récapitulatif du panier en cours -->
        <div class="card">
            <h3 class="card-title">Panier de la caisse</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Qté</th>
                        <th>Prix U.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="table-panier">
                    <!-- Les produits s'ajouteront ici via JavaScript -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: 600; font-size: 16px; padding-top: 20px;">Total Général :</td>
                        <td style="font-weight: 700; font-size: 18px; color: #3b82f6; padding-top: 20px;" id="total-general">
                            0,00 Ar
                        </td>
                    </tr>
                </tfoot>
            </table>
            
            <div style="margin-top: 20px; text-align: right;">
                <form action="<?= base_url('achats/cloturer') ?>" method="POST" id="form-cloture">
                    <!-- Les inputs cachés du panier s'ajouteront ici -->
                    <button type="submit" class="btn" style="background: #10b981; width: auto;" id="btn-cloturer" disabled>Clôturer l'achat</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let panier = [];
        let totalPanier = 0;

        document.getElementById('btn-ajouter').addEventListener('click', function() {
            const selectProduit = document.getElementById('id_produit');
            const inputQuantite = document.getElementById('quantite');

            const id_produit = selectProduit.value;
            const quantite = parseInt(inputQuantite.value);
            
            if (!id_produit || quantite < 1) {
                alert('Veuillez sélectionner un produit et une quantité valide.');
                return;
            }

            const optionSelectionnee = selectProduit.options[selectProduit.selectedIndex];
            const nom = optionSelectionnee.getAttribute('data-nom');
            const prix = parseFloat(optionSelectionnee.getAttribute('data-prix'));
            const totalLigne = prix * quantite;

            // Ajouter au tableau JS
            panier.push({
                id_produit: id_produit,
                nom: nom,
                quantite: quantite,
                prix: prix,
                total: totalLigne
            });

            totalPanier += totalLigne;

            mettreAJourAffichage();

            // Remettre la quantité à 1 et le select à 0
            selectProduit.value = '';
            inputQuantite.value = 1;
        });

        function mettreAJourAffichage() {
            const tbody = document.getElementById('table-panier');
            const formCloture = document.getElementById('form-cloture');
            tbody.innerHTML = '';
            
            // Nettoyer les anciens inputs cachés (garder juste le bouton)
            const inputsCaches = formCloture.querySelectorAll('input.produit-input');
            inputsCaches.forEach(input => input.remove());

            panier.forEach((item, index) => {
                // Ajouter la ligne au tableau visuel
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.nom}</td>
                    <td>${item.quantite}</td>
                    <td>${item.prix.toLocaleString('fr-FR', {minimumFractionDigits: 2})} Ar</td>
                    <td><strong>${item.total.toLocaleString('fr-FR', {minimumFractionDigits: 2})} Ar</strong></td>
                `;
                tbody.appendChild(tr);

                // Ajouter les inputs cachés pour l'envoi au backend
                formCloture.insertAdjacentHTML('beforeend', `
                    <input class="produit-input" type="hidden" name="produits[${index}][id_produit]" value="${item.id_produit}">
                    <input class="produit-input" type="hidden" name="produits[${index}][quantite]" value="${item.quantite}">
                    <input class="produit-input" type="hidden" name="produits[${index}][prix_unitaire]" value="${item.prix}">
                `);
            });

            // Mettre à jour le total général
            document.getElementById('total-general').innerText = totalPanier.toLocaleString('fr-FR', {minimumFractionDigits: 2}) + ' Ar';

            // Activer ou désactiver le bouton clôturer
            document.getElementById('btn-cloturer').disabled = (panier.length === 0);
        }


        document.getElementById('form-cloture').addEventListener('submit', function(event) {
            if (panier.length === 0) {
                event.preventDefault();
                alert('Aucun produit à clôturer.');
                return;
            }

            if (!confirm('Clôturer cet achat et enregistrer le ticket ?')) {
                event.preventDefault();
            }
        });
    </script>

</body>
</html>
