<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection de Caisse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
        }
        .caisse-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .caisse-card {
            background: #fff;
            border: 2px solid #eef2f5;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .caisse-card:hover {
            border-color: #007bff;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            transform: translateY(-4px);
        }
        .caisse-number {
            font-size: 36px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 8px;
        }
        .caisse-name {
            font-size: 16px;
            color: #555;
            font-weight: 600;
        }
        .caisse-status {
            margin-top: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            background: #e8f5e9;
            color: #2e7d32;
            text-transform: uppercase;
        }
        .caisse-status.fermee {
            background: #ffebee;
            color: #c62828;
        }
        .empty-message {
            text-align: center;
            color: #888;
            grid-column: 1 / -1;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Sélectionnez votre caisse</h1>
    
    <div class="caisse-list">
        <?php if (!empty($caisses) && is_array($caisses)): ?>
            <form action="<?= base_url('caisse/choisir') ?>" method="POST">
                <select name="id_caisse" id="">
                    <option value="">--Choisissez une caisse--</option>
            <?php foreach ($caisses as $caisse): ?>
                <option value="<?= $caisse['id_caisse'] ?>"><?= $caisse['numero_caisse'] ?> - <?= $caisse['libelle'] ?></option>
            <?php endforeach; ?>
            </select>
            <button type="submit">Valider</button>
        </form>
        <?php else: ?>
            <div class="empty-message">
                Aucune caisse n'est disponible pour le moment.
            </div>
        <?php endif; ?>
       
    </div>
</div>

</body>
</html>
