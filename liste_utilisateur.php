<?php
session_start();
include 'connexion.php';

$result = $pdo->query("SELECT id_client, nom, adress, email, city FROM Client");
$clients = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste Utilisateurs</title>
  <!--<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Exo+2:wght@300;400;600&display=swap" rel="stylesheet">-->
  <style>
    :root {
      --bg:rgba(0,23,56,67);
      --card: rgba(0, 200, 255, 0.05);
      --border: rgba(0, 220, 255, 0.2);
      --cyan: #00dcff;
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

    /* Carte utilisateur */
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

    .info-item.full {
      grid-column: 1 / -1;
    }

    /* Vide */
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
    <span class="brand-name">UTILISATEURS</span>
    <a href="accueil1.html" class="back-btn">Retour</a>
  </header>

  <div class="hero">
    <h1>Liste des Utilisateurs</h1>
    <p>Tous les comptes enregistrés</p>
    <div class="divider"></div>
  </div>

  <div class="content">

    <?php if (count($clients) > 0): ?>

      <p class="count"><span><?php echo count($clients); ?></span> utilisateur(s) trouvé(s)</p>

      <?php foreach ($clients as $index => $client): ?>
        <div class="user-card" style="animation-delay: <?php echo $index * 0.08; ?>s">
          <div class="user-header">
            <div class="avatar"></div>
            <div>
              <div class="user-name"><?php echo htmlspecialchars($client['nom']); ?></div>
              <div class="user-id">ID : #<?php echo $client['id_client']; ?></div>
            </div>
          </div>
          <div class="user-info">
            <div class="info-item full">
              <span class="info-label">Email</span>
              <span class="info-value"><?php echo htmlspecialchars($client['email']); ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Ville</span>
              <span class="info-value"><?php echo htmlspecialchars($client['city']); ?></span>
            </div>
            <div class="info-item">
              <span class="info-label">Adresse</span>
              <span class="info-value"><?php echo htmlspecialchars($client['adress']); ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    <?php else: ?>
      <div class="empty">Aucun utilisateur trouvé.</div>
    <?php endif; ?>

  </div>

  <footer> 2026 — Plateforme de gestion</footer>

</div>
</body>
</html>