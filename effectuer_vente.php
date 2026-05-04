<?php
session_start();
include 'connexion.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    if (!empty($_POST['id_cust']) && !empty($_POST['id_comm']) && !empty($_POST['date']) && !empty($_POST['id_article']) && !empty($_POST['quantite']) && !empty($_POST['prix_unitaire'])) {
        try {
            // Insertion dans commande
            $sql1 = $pdo->prepare("INSERT INTO commande (id_comm, id_cust, date) 
                                   VALUES (:id_comm, :id_cust, :date)");
            $sql1->execute([
                ':id_comm' => $_POST['id_comm'],
                ':id_cust' => $_POST['id_cust'],
                ':date'    => $_POST['date']
            ]);

            // Insertion dans contenir
            $sql2 = $pdo->prepare("INSERT INTO contenir (id_cust, id_comm, quantite, prix_unitaire) 
                                   VALUES (:id_cust, :id_comm, :quantite, :prix_unitaire)");
            $sql2->execute([
                ':id_cust'      => $_POST['id_cust'],
                ':id_comm'      => $_POST['id_comm'],
                ':quantite'     => $_POST['quantite'],
                ':prix_unitaire'=> $_POST['prix_unitaire']
            ]);

            $message = "<p style='color:#00ffcc;font-size:13px'>Vente enregistrée avec succès !</p>";
        } catch (PDOException $e) {
            $message = "<p style='color:red;font-size:13px'>Erreur : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color:red;font-size:13px'>Veuillez remplir tous les champs.</p>";
    }
}

// Charger les clients pour le select
$clients = $pdo->query("SELECT id_cust, nom, prenom FROM customer")->fetchAll(PDO::FETCH_ASSOC);

// Charger les articles pour le select
$articles = $pdo->query("SELECT id_article, design, prix FROM Article")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Effectuer une Vente</title>
  <style>
    :root {
      --bg: rgba(0,23,56,67);
      --card: rgba(0, 200, 255, 0.05);
      --border: rgba(0, 220, 255, 0.2);
      --cyan: #00dcff;
      --cyan2: #00ffcc;
      --text: #cdf0ff;
      --muted: #5a8fa8;
      --glow: 0 0 18px rgba(0, 220, 255, 0.4);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg);
      font-family: 'Exo 2', sans-serif;
      color: var(--text);
      min-height: 100vh;
    }

    @keyframes gridMove {
      0% { background-position: 0 0; }
      100% { background-position: 40px 40px; }
    }

    .wrapper { position: relative; z-index: 1; }

    header {
      padding: 20px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      background: rgba(0, 20, 40, 0.6);
      backdrop-filter: blur(12px);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .brand-name {
      font-family: 'Orbitron', monospace;
      font-size: 14px;
      color: var(--cyan);
      letter-spacing: 2px;
      text-shadow: var(--glow);
    }

    .back-btn {
      text-decoration: none;
      color: var(--cyan);
      font-size: 13px;
      border: 1px solid var(--border);
      padding: 6px 14px;
      border-radius: 20px;
      transition: all 0.3s;
    }

    .back-btn:hover {
      background: rgba(0,220,255,0.1);
      box-shadow: var(--glow);
    }

    .hero {
      text-align: center;
      padding: 36px 20px 24px;
    }

    .hero h1 {
      font-family: 'Orbitron', monospace;
      font-size: clamp(16px, 4vw, 22px);
      color: var(--cyan);
      text-shadow: var(--glow);
      letter-spacing: 3px;
    }

    .hero p {
      margin-top: 8px;
      font-size: 12px;
      color: var(--muted);
    }

    .divider {
      width: 60px;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--cyan), transparent);
      margin: 14px auto 0;
    }

    .content {
      padding: 16px;
      max-width: 600px;
      margin: 0 auto;
    }

    .form-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      margin-bottom: 24px;
      backdrop-filter: blur(6px);
    }

    .form-title {
      font-family: 'Orbitron', monospace;
      font-size: 12px;
      color: var(--cyan2);
      letter-spacing: 2px;
      margin-bottom: 14px;
      text-shadow: 0 0 10px rgba(0,255,180,0.4);
    }

    .form-section {
      font-size: 10px;
      color: var(--cyan);
      letter-spacing: 1px;
      text-transform: uppercase;
      margin: 16px 0 10px;
      padding-bottom: 6px;
      border-bottom: 1px solid var(--border);
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 12px;
    }

    .form-group label {
      font-size: 10px;
      color: var(--muted);
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .form-group input,
    .form-group select {
      background: rgba(0,220,255,0.05);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 10px 14px;
      color: var(--text);
      font-size: 14px;
      outline: none;
      transition: border-color 0.3s;
      width: 100%;
    }

    .form-group select option {
      background: #021428;
      color: var(--text);
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: var(--cyan);
      box-shadow: var(--glow);
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, rgba(0,255,180,0.1), rgba(0,220,255,0.1));
      border: 1px solid var(--cyan2);
      border-radius: 10px;
      color: var(--cyan2);
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 8px;
    }

    .submit-btn:active {
      transform: scale(0.98);
      box-shadow: 0 0 16px rgba(0,255,180,0.3);
    }

    footer {
      text-align: center;
      padding: 16px;
      font-size: 11px;
      color: var(--muted);
      border-top: 1px solid var(--border);
      letter-spacing: 1px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="wrapper">

  <header>
    <span class="brand-name">VENTE</span>
    <a href="accueil1.html" class="back-btn">Retour</a>
  </header>

  <div class="hero">
    <h1>Effectuer une Vente</h1>
    <p>Enregistrez une nouvelle commande</p>
    <div class="divider"></div>
  </div>

  <div class="content">
    <div class="form-card">
      <p class="form-title">🛒 NOUVELLE VENTE</p>
      <?php echo $message; ?>

      <form method="POST">

        <p class="form-section">Commande</p>

        <div class="form-group">
          <label>ID Commande</label>
          <input type="text" name="id_comm" placeholder="Ex: CMD001">
        </div>

        <div class="form-group">
          <label>Date</label>
          <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <p class="form-section">Client</p>

        <div class="form-group">
          <label>Sélectionner le client</label>
          <select name="id_cust">
            <option value="">-- Choisir un client --</option>
            <?php foreach ($clients as $client): ?>
              <option value="<?php echo $client['id_cust']; ?>">
                #<?php echo $client['id_cust']; ?> — <?php echo htmlspecialchars($client['nom']); ?> <?php echo htmlspecialchars($client['prenom']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <p class="form-section">Article</p>

        <div class="form-group">
          <label>Sélectionner l'article</label>
          <select name="id_article">
            <option value="">-- Choisir un article --</option>
            <?php foreach ($articles as $article): ?>
              <option value="<?php echo $article['id_article']; ?>">
                <?php echo htmlspecialchars($article['design']); ?> — <?php echo $article['prix']; ?> €
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label>Quantité</label>
          <input type="number" name="quantite" placeholder="1" min="1">
        </div>

        <div class="form-group">
          <label>Prix unitaire (€)</label>
          <input type="number" name="prix_unitaire" placeholder="0.00" step="0.01">
        </div>

        <button type="submit" name="btn" class="submit-btn">Valider la vente</button>

      </form>
    </div>
  </div>

  <footer>© 2026 — Plateforme de gestion</footer>

</div>
</body>
</html>