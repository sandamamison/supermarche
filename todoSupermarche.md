# Todo list — Projet Caisse d’un supermarché

## 1. Préparation de la base de données

- [x] Créer la base de données SQLite.
- [x] Créer le fichier `tables.sql`.
- [x] Créer le fichier `insertion_donnees.sql`.
- [x] Créer la table `produit`.
- [x] Créer la table `caisse`.
- [x] Créer la table `achat`.
- [x] Insérer 5 produits dans la table `produit`.
- [x] Insérer 2 caisses dans la table `caisse`.
- [x] Tester si les données sont bien insérées.

---

## 2. Initialisation du projet CodeIgniter

- [x] Créer le projet CodeIgniter.
- [x] Vérifier que le projet fonctionne dans le navigateur.
- [x] Configurer la base SQLite dans CodeIgniter.
- [x] Créer les dossiers nécessaires :
  - [x] Controllers
  - [x] Models
  - [x] Views
- [x] Préparer la structure MVC du projet.

---

## 3. Création du template

- [x] Récupérer le fichier template fourni.
- [x] Créer une vue `header.php`.
- [x] Créer une vue `menu.php`.
- [x] Créer une vue `footer.php`.
- [x] Créer une vue principale pour afficher le contenu.
- [x] Appliquer le template sur toutes les pages.

---

## 4. Création de l’écran de login

- [x] Créer la page de connexion.
- [x] Créer un formulaire avec :
  - [x] Nom d’utilisateur
  - [x] Mot de passe
- [x] Vérifier les informations de connexion.
- [x] Créer une session après connexion réussie.
- [x] Rediriger vers la page de choix de caisse.
- [x] Empêcher l’accès aux pages si l’utilisateur n’est pas connecté.

---

## 5. Création de l’écran de choix de caisse

- [x] Afficher la liste des caisses disponibles.
- [x] Enregistrer la caisse choisie dans la session.
- [x] Rediriger vers la page de saisie des achats.
- [x] Afficher le numéro ou le nom de la caisse choisie en haut de la page.

---

## 6. Création de la page de saisie des achats

- [x] Créer la page de saisie des achats.
- [x] Afficher la caisse choisie en haut de la page.
- [x] Afficher la liste des produits.
- [x] Créer un champ pour choisir un produit.
- [x] Créer un champ pour saisir la quantité.
- [x] Ajouter un bouton **Ajouter**.
- [x] Vérifier si la quantité saisie est correcte.
- [x] Vérifier si le stock est suffisant.
- [x] Ajouter le produit dans l’achat en cours.

---

## 7. Affichage de l’achat en cours

- [x] Afficher les produits ajoutés dans un tableau.
- [x] Afficher les colonnes :
  - [x] Désignation
  - [x] Prix unitaire
  - [x] Quantité
  - [x] Montant total
- [x] Calculer le total de chaque ligne.
- [x] Calculer le total général de l’achat.
- [x] Mettre à jour l’affichage après chaque ajout de produit.

---

## 8. Gestion du stock

- [x] Diminuer la quantité en stock après l’ajout d’un produit.
- [x] Empêcher l’achat si le stock est insuffisant.
- [x] Afficher un message d’erreur si la quantité demandée dépasse le stock.
- [x] Tester la mise à jour du stock.

---

## 9. Clôture de l’achat

- [x] Ajouter un bouton **Clôturer achat**.
- [x] Finaliser l’achat du client.
- [x] Enregistrer l’achat terminé dans la base.
- [x] Vider la liste de l’achat en cours.
- [x] Préparer une nouvelle liste vide pour le prochain client.
- [x] Afficher un message de confirmation.

---

