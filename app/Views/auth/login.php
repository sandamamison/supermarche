<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Supermarché</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/supermarche.css') ?>">
</head>
<body class="auth-page">

    <main class="auth-card">
        <div class="brand brand-center">
            <div class="brand-icon">🛒</div>
            <div>
                <h1 class="brand-title">Caisse Supermarché</h1>
                <p class="brand-subtitle">Connectez-vous pour commencer un achat</p>
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

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Nom de l’acheteur</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    placeholder="Exemple : Carlos"
                    required
                    autocomplete="username"
                >
            </div>

            <button type="submit" class="btn btn-full">
                Se connecter
            </button>
        </form>
    </main>

</body>
</html>
