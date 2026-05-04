<?php
session_start();
include 'connexion.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])) {
        try {
            $sql = $pdo->prepare("INSERT INTO customer (nom, prenom, age, adresse, ville, email) 
                                  VALUES (:nom, :prenom, :age, :adresse, :ville, :email)");
            $sql->execute([
                ':nom'     => $_POST['nom'],
                ':prenom'  => $_POST['prenom'],
                ':age'     => $_POST['age'],
                ':adresse' => $_POST['adresse'],
                ':ville'   => $_POST['ville'],
                ':email'   => $_POST['email']
            ]);
            $message = "<p style='color:#00ffcc;font-size:13px'>Client enregistré avec succès !</p>";
        } catch (PDOException $e) {
            $message = "<p style='color:red;font-size:13px'>Erreur : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color:red;font-size:13px'>Nom, prénom et email obligatoires.</p>";
    }
}

$result = $pdo->query("SELECT id_cust, nom, prenom, age, adresse, ville, email FROM customer");
$clients = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste Clients</title>
  <!--<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Exo+2:wght@300;400;600&display=swap" rel="stylesheet">-->
  <style>
    :root {
      --bg:rgba(0,23,56,67);
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

   /* body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(0,220,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,220,255,0.04) 1px, transparent 1px);
      background-size: 40px 40px;
      z-index: 0;
      animation: gridMove 20s linear infinite;
    }*/

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

    /* Formulaire */
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

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
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

    .form-group input {
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

    .form-group input:focus {
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
      margin-top: 4px;
    }

    .submit-btn:active { transform: scale(0.98); }

    .count {
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 14px;
      letter-spacing: 1px;
    }

    .count span {
      color: var(--cyan);
      font-weight: 600;
    }

    .user-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      margin-bottom: 14px;
      backdrop-filter: blur(6px);
      animation: fadeUp 0.5s ease both;
      transition: all 0.3s;
    }

    .user-card:hover {
      border-color: var(--cyan);
      box-shadow: var(--glow);
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .user-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }

   /* .avatar {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(0,220,255,0.2), rgba(0,100,150,0.3));
      border: 1px solid var(--cyan);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      flex-shrink: 0;
    }*/

    .user-name {
      font-weight: 600;
      font-size: 15px;
      color: var(--cyan);
    }

    .user-id {
      font-size: 11px;
      color: var(--muted);
      margin-top: 2px;
    }

    .user-info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    .info-item {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .info-label {
      font-size: 10px;
      color: var(--muted);
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .info-value {
      font-size: 13px;
      color: var(--text);
      word-break: break-all;
    }

    .info-item.full { grid-column: 1 / -1; }

    .empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
      font-size: 14px;
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
    <span class="brand-name">CLIENTS</span>
    <a href="accueil1.html" class="back-btn">Retour</a>
  </header>

  <div class="hero">
    <h1>Liste des Clients</h1>
    <p>Tous les clients enregistrés</p>
    <div class="divider"></div>
  </div>

  <div class="content">

    <div class="form-card">
      <p class="form-title">+ NOUVEAU CLIENT</p>
      <?php echo $message; ?>
      <form method="POST">
        <div class="form-row">
          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom">
          </div>
          <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" placeholder="Prénom">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Âge</label>
            <input type="number" name="age" placeholder="Âge">
          </div>
          <div class="form-group">
            <label>Ville</label>
            <input type="text" name="ville" placeholder="Ville">
          </div>
        </div>
        <div class="form-group">
          <label>Adresse</label>
          <input type="text" name="adresse" placeholder="Adresse complète">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="email@exemple.com">
        </div>
        <button type="submit" name="btn" class="submit-btn">Enregistrer le client</button>
      </form>
    </div>

    <?php if (count($clients) > 0): ?>
      <p class="count"><span><?php echo count($clients); ?></span> client(s) trouvé(s)</p>
      <?php foreach ($clients as $index => $client): ?>
        <div class="user-card" style="animation-delay: <?php echo $index * 0.08; ?>s">
          <div class="user-header">
            <div class="avatar"></div>
            <div>
              <div class="user-name"><?php echo htmlspecialchars($client['nom']); ?> <?php echo htmlspecialchars($client['prenom']); ?></div>
              <div class="user-id">ID : #<?php echo $client['id_cust']; ?></div>
            </div>
          </div>
          <div class="user-info">
            <div class="info-item full">
              <span class="info-label">Email</span>
              <span class="info-value"><?php echo htmlspecialchars($client['email']); ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Âge</span>
              <span class="info-value"><?php echo htmlspecialchars($client['age']); ?> ans</span>
            </div>
            <div class="info-item">
              <span class="info-label">Ville</span>
              <span class="info-value"><?php echo htmlspecialchars($client['ville']); ?></span>
            </div>
            <div class="info-item full">
              <span class="info-label">Adresse</span>
              <span class="info-value"><?php echo htmlspecialchars($client['adresse']); ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty">Aucun client trouvé.</div>
    <?php endif; ?>

  </div>

  <footer> 2026 — Plateforme de gestion</footer>

</div>
</body>
</html>