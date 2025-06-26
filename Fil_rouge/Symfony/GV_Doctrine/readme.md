# Fil Rouge CDA - Projet E-commerce Green Village

<img src="public/assets/img/brand/header_project.png" width="500">

## Conception et mise en place d'une base de données relationnelle

### Base de données :

- [ ] Élaboration du dictionnaire de données
- [ ] Répertorisation des règles de gestion avec identifiants
- [ ] Construction du schéma entité-association (validation formateur requise)
- [ ] Génération du modèle physique de données optimisé
- [ ] Création du script de génération de la base de données

### Structure et contraintes :

- [ ] Création de la base de données (contraintes, index, droits)
- [ ] Script d'insertion des données de test (données cohérentes)
- [ ] Mise en place des procédures de sauvegarde-restauration
- [ ] Test de restauration

## Développement des composants d'accès aux données SQL et NoSQL

### Requêtes et procédures :

- [ ] Scripts SQL pour les interrogations du tableau de bord
- [ ] Procédure stockée : sélection des commandes non soldées
- [ ] Procédure stockée : calcul du délai moyen commande/facturation

### Gestion des vues :

- [ ] Vue jointure Produits - Fournisseurs
- [ ] Vue jointure Produits - Catégorie/Sous-catégorie

## Analyse des besoins et maquettage d'une application

### Maquettes Web (Mockflow/Figma) :

- [ ] Fenêtre de démarrage (liste des catégories)
- [ ] Page liste des sous-catégories
- [ ] Page liste des produits d'une sous-catégorie
- [ ] Page détails produit + ajout panier
- [ ] Page contenu du panier
- [ ] Page d'inscription
- [ ] Page de connexion
- [ ] Page changement de mot de passe

### Maquettes Mobile :

- [ ] Écran de démarrage (liste des catégories)
- [ ] Page sous-catégories d'une catégorie
- [ ] Page produits d'une sous-catégorie
- [ ] Page détails du produit sélectionné

## Architecture logicielle d'une application

### Diagrammes UML :

- [ ] Diagramme des cas d'utilisation complet
- [ ] Scénario détaillé : création d'une commande (flux principal + alternatifs)
- [ ] Diagramme de séquences pour le scénario de commande
- [ ] Diagramme d'activité : processus de saisie d'une commande
- [ ] Diagramme des classes entités (modèle de données)

## Installation et configuration de l'environnement

### Conteneurs Docker :

- [ ] Fichier `compose.yaml` et Dockerfile
- [ ] Conteneur PHP pour l'exécution du site
- [ ] Conteneur pour la base de données
- [ ] Conteneur pour la gestion des emails
- [ ] Documentation des conteneurs de développement

## Développement des interfaces utilisateur

### Pages web statiques (HTML/CSS) :

#### Front Office :

- [ ] Page d'accueil (intégration charte graphique)
- [ ] Liste des catégories
- [ ] Liste des sous-catégories
- [ ] Liste des produits
- [ ] Détails d'un produit
- [ ] Contenu du panier
- [ ] Page d'inscription
- [ ] Page de connexion

#### Back Office :

- [ ] Interface d'administration
- [ ] Gestion des produits
- [ ] Gestion des commandes

### Scripts clients (JavaScript) :

- [ ] Formulaire d'inscription avec validation
- [ ] Gestion des erreurs utilisateur
- [ ] Prévention des soumissions erronées

## Développement des composants métier

### Composants web d'accès aux données :

#### Front Office :

- [ ] Création de commande (panier + inscription + validation)
- [ ] Ajout de produits au panier
- [ ] Processus d'inscription et connexion
- [ ] Validation et enregistrement de commande

#### Back Office :

- [ ] Gestion CRUD sur la table produit
- [ ] Interface liste/ajout/modification/suppression
- [ ] Menu d'accueil administrateur

### Architecture :

- [ ] Mise en place de l'architecture MVC
- [ ] Organisation en couches
- [ ] Mise en place d'une API sécurisée (JWT)
- [ ] Configuration du module JWT (désactivé pour tests)

## Application mobile

### Fonctionnalités :

- [ ] Consultation du catalogue
- [ ] Navigation dans les rubriques
- [ ] Consultation des produits
- [ ] Connexion via API
- [ ] Package distribuable de l'application

## Tests et déploiement

### Tests :

- [ ] Mise en place des tests unitaires
- [ ] Exécution des plans de tests

### Déploiement :

- [ ] Documentation du déploiement
- [ ] Diagramme de déploiement UML
- [ ] Publication sur l'espace attribué (sans erreur)
- [ ] Application mobile sous forme de package

### DevOps :

- [ ] Contribution à la mise en production
- [ ] Démarche DevOps
