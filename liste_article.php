<?php
session_start();
include 'connexion.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    if (!empty($_POST['id_article']) && !empty($_POST['design']) && !empty($_POST['prix']) && !empty($_POST['categorie'])) {
        try {
            $sql = $pdo->prepare("INSERT INTO Article (id_article, design, prix, categorie) 
                                  VALUES (:id_article, :design, :prix, :categorie)");
            $sql->execute([
                ':id_article' => $_POST['id_article'],
                ':design'     => $_POST['design'],
                ':prix'       => $_POST['prix'],
                ':categorie'  => $_POST['categorie']
            ]);
            $message = "<p style='color:#00ffcc;font-size:13px'>Article enregistré avec succès !</p>";
        } catch (PDOException $e) {
            $message = "<p style='color:red;font-size:13px'>Erreur : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color:red;font-size:13px'>Veuillez remplir tous les champs.</p>";
    }
}

$result = $pdo->query("SELECT * FROM Article");
$articles = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste Articles</title>
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

    .submit-btn:active {
      transform: scale(0.98);
      box-shadow: 0 0 16px rgba(0,255,180,0.3);
    }

    /* Compteur */
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

    /* Tableau */
    .table-wrap {
      overflow-x: auto;
      border-radius: 16px;
      border: 1px solid var(--border);
      backdrop-filter: blur(6px);
      animation: fadeUp 0.5s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    thead {
      background: rgba(0, 220, 255, 0.08);
    }

    thead th {
      padding: 12px 14px;
      text-align: left;
      font-size: 10px;
      color: var(--cyan);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      border-bottom: 1px solid var(--border);
      white-space: nowrap;
    }

    tbody tr {
      border-bottom: 1px solid rgba(0,220,255,0.08);
      transition: background 0.2s;
    }

    tbody tr:last-child { border-bottom: none; }

    tbody tr:hover {
      background: rgba(0,220,255,0.05);
    }

    tbody td {
      padding: 12px 14px;
      color: var(--text);
      white-space: nowrap;
    }

    tbody td:first-child {
      color: var(--muted);
      font-size: 11px;
    }

    .prix-cell {
      color: var(--cyan2);
      font-weight: 600;
    }

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
    <span class="brand-name">ARTICLES</span>
    <a href="accueil1.html" class="back-btn">Retour</a>
  </header>

  <div class="hero">
    <h1>Liste des Articles</h1>
    <p>Enregistrez et consultez les articles</p>
    <div class="divider"></div>
  </div>

  <div class="content">

    <!-- Formulaire -->
    <div class="form-card">
      <p class="form-title">+ NOUVEL ARTICLE</p>
      <?php echo $message; ?>
      <form method="POST">
        <div class="form-group">
          <label>ID Article</label>
          <input type="text" name="id_article" placeholder="Ex: ART001">
        </div>
        <div class="form-group">
          <label>Désignation</label>
          <input type="text" name="design" placeholder="Nom de l'article">
        </div>
        <div class="form-group">
          <label>Prix (€)</label>
          <input type="number" name="prix" placeholder="0.00" step="0.01">
        </div>
        <div class="form-group">
          <label>Catégorie</label>
          <input type="text" name="categorie" placeholder="Catégorie">
        </div>
        <button type="submit" name="btn" class="submit-btn">Enregistrer</button>
      </form>
    </div>

    <!-- Tableau articles -->
    <?php if (count($articles) > 0): ?>

      <p class="count"><span><?php echo count($articles); ?></span> article(s) en stock</p>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Désignation</th>
              <th>Prix</th>
              <th>Catégorie</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($articles as $article): ?>
              <tr>
                <td>#<?php echo htmlspecialchars($article['id_article']); ?></td>
                <td><?php echo htmlspecialchars($article['design']); ?></td>
                <td class="prix-cell"><?php echo htmlspecialchars($article['prix']); ?> €</td>
                <td><?php echo htmlspecialchars($article['categorie']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <?php else: ?>
      <div class="empty">Aucun article enregistré.</div>
    <?php endif; ?>

  </div>

  <footer> 2026 — Plateforme de gestion</footer>

</div>
</body>
</html>