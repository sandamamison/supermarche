# Todo list — Projet Caisse d’un supermarché

## Contexte du projet

Projet : **Caisse d’un supermarché**  
Technologies demandées : **PHP — CodeIgniter — SQLite**

Objectif : créer une application simple permettant à un utilisateur de se connecter, de choisir une caisse, de saisir les achats d’un client, puis de clôturer l’achat.

---

## 1. Préparation de la base de données

- [x] Créer la base de données SQLite.
- [x] Créer le fichier `tables.sql`.
- [x] Créer le fichier `insertion_donnees.sql`.
- [x] Créer la table `produit`.
- [x] Créer la table `caisse`.
- [x] Créer la table `achat`.
- [ ] Insérer 5 produits dans la table `produit`.
- [ ] Insérer 2 caisses dans la table `caisse`.
- [ ] Tester si les données sont bien insérées.

---

## 2. Initialisation du projet CodeIgniter

- [x] Créer le projet CodeIgniter.
- [x] Vérifier que le projet fonctionne dans le navigateur.
- [x] Configurer la base SQLite dans CodeIgniter.
- [-] Créer les dossiers nécessaires :
  - [x] Controllers
  - [x] Models
  - [-] Views
- [-] Préparer la structure MVC du projet.

---

## 3. Création du template

- [ ] Récupérer le fichier template fourni.
- [ ] Créer une vue `header.php`.
- [ ] Créer une vue `menu.php`.
- [ ] Créer une vue `footer.php`.
- [ ] Créer une vue principale pour afficher le contenu.
- [ ] Appliquer le template sur toutes les pages.

---

## 4. Création de l’écran de login

- [ ] Créer la page de connexion.
- [ ] Créer un formulaire avec :
  - [ ] Nom d’utilisateur
  - [ ] Mot de passe
- [ ] Vérifier les informations de connexion.
- [ ] Créer une session après connexion réussie.
- [ ] Rediriger vers la page de choix de caisse.
- [ ] Empêcher l’accès aux pages si l’utilisateur n’est pas connecté.

---

## 5. Création de l’écran de choix de caisse

- [x] Afficher la liste des caisses disponibles.
- [ ] Enregistrer la caisse choisie dans la session.
- [ ] Rediriger vers la page de saisie des achats.
- [ ] Afficher le numéro ou le nom de la caisse choisie en haut de la page.

---

## 6. Création de la page de saisie des achats

- [ ] Créer la page de saisie des achats.
- [ ] Afficher la caisse choisie en haut de la page.
- [ ] Afficher la liste des produits.
- [ ] Créer un champ pour choisir un produit.
- [ ] Créer un champ pour saisir la quantité.
- [ ] Ajouter un bouton **Ajouter**.
- [ ] Vérifier si la quantité saisie est correcte.
- [ ] Vérifier si le stock est suffisant.
- [ ] Ajouter le produit dans l’achat en cours.

---

## 7. Affichage de l’achat en cours

- [ ] Afficher les produits ajoutés dans un tableau.
- [ ] Afficher les colonnes :
  - [ ] Désignation
  - [ ] Prix unitaire
  - [ ] Quantité
  - [ ] Montant total
- [ ] Calculer le total de chaque ligne.
- [ ] Calculer le total général de l’achat.
- [ ] Mettre à jour l’affichage après chaque ajout de produit.

---

## 8. Gestion du stock

- [ ] Diminuer la quantité en stock après l’ajout d’un produit.
- [ ] Empêcher l’achat si le stock est insuffisant.
- [ ] Afficher un message d’erreur si la quantité demandée dépasse le stock.
- [ ] Tester la mise à jour du stock.

---

## 9. Clôture de l’achat

- [ ] Ajouter un bouton **Clôturer achat**.
- [ ] Finaliser l’achat du client.
- [ ] Enregistrer l’achat terminé dans la base.
- [ ] Vider la liste de l’achat en cours.
- [ ] Préparer une nouvelle liste vide pour le prochain client.
- [ ] Afficher un message de confirmation.

---

## 10. Tests du projet

- [ ] Tester la connexion.
- [ ] Tester le choix de caisse.
- [ ] Tester l’ajout d’un produit.
- [ ] Tester l’ajout de plusieurs produits.
- [ ] Tester le calcul du total.
- [ ] Tester le stock insuffisant.
- [ ] Tester la clôture de l’achat.
- [ ] Tester la session.
- [ ] Tester la déconnexion.

---

## 11. Fichiers importants du projet

- [ ] `tables.sql`
- [ ] `insertion_donnees.sql`
- [ ] `database.php`
- [ ] `LoginController.php`
- [ ] `CaisseController.php`
- [ ] `AchatController.php`
- [ ] `ProduitModel.php`
- [ ] `CaisseModel.php`
- [ ] `AchatModel.php`
- [ ] `login.php`
- [ ] `choix_caisse.php`
- [ ] `saisie_achat.php`
- [ ] `header.php`
- [ ] `footer.php`

---

## 12. Ordre conseillé de réalisation

1. Créer la base de données.
2. Créer les tables.
3. Insérer les données de test.
4. Initialiser CodeIgniter.
5. Configurer SQLite.
6. Créer le template.
7. Créer le login.
8. Créer le choix de caisse.
9. Créer la saisie des achats.
10. Afficher l’achat en cours.
11. Ajouter la clôture d’achat.
12. Tester tout le projet.

