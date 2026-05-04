# Shop-Project-
It's a model small website with database mainly to manage a shop. This is a school project. 
# Plateforme de Gestion - Vente

Projet PHP/MySQL de gestion de ventes développé sur mobile.

## Technologies
- PHP 8
- MySQL
- phpMyAdmin
- aWebServer (Android)

## Installation

1. Cloner le repo :
git clone https://github.com/kamalsanens-sketch/Shop-Project.git

2. Importer la base de données :
- Ouvrir phpMyAdmin
- Créer une base nommée `Vente`
- Onglet SQL → importer le fichier `Vente.sql`

3. Configurer la connexion dans `connexion.php` :
- host : localhost
- user : root
- password : (vide ou root selon votre config)
- dbname : Vente

4. Lancer un serveur Apache + MySQL local (XAMPP, aWebServer...)

5. Ouvrir : http://localhost/accueil1.html

## Pages disponibles
- accueil1.html — Page d'accueil
- liste_utilisateur.php — Liste des utilisateurs
- liste_client.php — Liste et ajout de clients
- liste_article.php — Liste et ajout d'articles
- liste_vente.php — Liste des ventes par client
- effectuer_vente.php — Enregistrement d'une vente
