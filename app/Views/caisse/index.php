<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix de la caisse - Supermarché</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/supermarche.css') ?>">
</head>
<body>

<div class="app-shell">
    <header class="topbar">
        <div class="brand">
            <div class="brand-icon">🛒</div>
            <div>
                <h1 class="brand-title">Caisse Supermarché</h1>
                <p class="brand-subtitle">Sélection de la caisse</p>
            </div>
        </div>

        <div class="topbar-actions">
            <span class="user-badge">
                Acheteur : <?= esc(session()->get('username') ?? 'Non connecté') ?>
            </span>
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
        <h2 class="page-title">Choisir une caisse</h2>
        <p class="page-subtitle">Choisissez le numéro de caisse avant de commencer la saisie des achats.</p>
    </section>

    <section class="card">
        <h3 class="card-title">Caisse disponible</h3>

        <?php if (!empty($caisses) && is_array($caisses)): ?>
            <form action="<?= base_url('caisse/choisir') ?>" method="post" class="caisse-form">
                <?= csrf_field() ?>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="id_caisse">Numéro de caisse</label>
                    <select name="id_caisse" id="id_caisse" required>
                        <option value="">-- Choisissez une caisse --</option>
                        <?php foreach ($caisses as $caisse): ?>
                            <option value="<?= esc($caisse['id_caisse']) ?>">
                                Caisse N° <?= esc($caisse['numero_caisse']) ?> - <?= esc($caisse['libelle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn">Valider</button>
            </form>
        <?php else: ?>
            <div class="empty-state">
                Aucune caisse n’est disponible pour le moment.
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>
