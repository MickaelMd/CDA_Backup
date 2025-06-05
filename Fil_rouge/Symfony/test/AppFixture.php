<?php
namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\Utilisateur;
use App\Entity\Fournisseur;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Livraison;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Catégories
        $categories = [];
        $categories[] = (new Categorie())->setActive(true)->setNom('Guitares')->setImage('guitares.jpg');
        $categories[] = (new Categorie())->setActive(true)->setNom('Claviers')->setImage('claviers.jpg');

        foreach ($categories as $categorie) {
            $manager->persist($categorie);
        }

        // Sous-catégories
        $sousCategories = [];
        $sousCategories[] = (new SousCategorie())->setCategorie($categories[0])->setActive(true)->setNom('Guitares électriques')->setImage('g_electriques.jpg');
        $sousCategories[] = (new SousCategorie())->setCategorie($categories[1])->setActive(true)->setNom('Pianos numériques')->setImage('pianos_num.jpg');

        foreach ($sousCategories as $sc) {
            $manager->persist($sc);
        }

        // Utilisateurs
        $utilisateurs = [];
        $utilisateurs[] = (new Utilisateur())
            ->setEmail('client1@exampleee.com')
            ->setRoles(['ROLE_CLIENT'])
            ->setPassword('passwordhash1')
            ->setNom('Dupont')
            ->setPrenom('Jean')
            ->setTelephone('0123456789')
            ->setAdresseLivraison('1 rue Client')
            ->setAdresseFacturation('1 rue Client');

        $utilisateurs[] = (new Utilisateur())
            ->setEmail('commercial1@exampleee.com')
            ->setRoles(['ROLE_COMMERCIAL'])
            ->setPassword('passwordhash2')
            ->setNom('Martin')
            ->setPrenom('Paul')
            ->setTelephone('0987654321')
            ->setCoefficient(1.5)
            ->setAdresseLivraison('10 avenue Com')
            ->setAdresseFacturation('10 avenue Com');

        foreach ($utilisateurs as $user) {
            $manager->persist($user);
        }

        // Fournisseurs
        $fournisseurs = [];
        $fournisseurs[] = (new Fournisseur())
            ->setCommercial($utilisateurs[1])
            ->setNom('Fournisseur A')
            ->setEmail('contact@fournisseura.com')
            ->setTelephone('0147852369')
            ->setAdresse('123 rue Fournisseur');

        $fournisseurs[] = (new Fournisseur())
            ->setCommercial($utilisateurs[1])
            ->setNom('Fournisseur B')
            ->setEmail('contact@fournisseurb.com')
            ->setTelephone('0178542369')
            ->setAdresse('456 avenue Fournisseur');

        foreach ($fournisseurs as $fournisseur) {
            $manager->persist($fournisseur);
        }

        // Produits
        $produits = [];
        $produits[] = (new Produit())
            ->setSousCategorie($sousCategories[0])
            ->setStock(10)
            ->setActive(true)
            ->setLibelleCourt('Guitare Strat')
            ->setLibelleLong('Guitare électrique Stratocaster')
            ->setImage('strat.jpg')
            ->setPrixHt(1200.00)
            ->setPrixFournisseur(800.00)
            ->setFournisseur($fournisseurs[0]);

        $produits[] = (new Produit())
            ->setSousCategorie($sousCategories[1])
            ->setStock(5)
            ->setActive(true)
            ->setLibelleCourt('Piano Yamaha')
            ->setLibelleLong('Piano numérique Yamaha')
            ->setImage('yamaha.jpg')
            ->setPrixHt(1500.00)
            ->setPrixFournisseur(1000.00)
            ->setFournisseur($fournisseurs[1]);

        foreach ($produits as $produit) {
            $manager->persist($produit);
        }

        // Commandes
        $commandes = [];
        $commandes[] = (new Commande())
            ->setClient($utilisateurs[0])
            ->setCommercial($utilisateurs[1])
            ->setDateCommande(new \DateTimeImmutable())
            ->setModePaiement('Carte bancaire')
            ->setStatu('En cours')
            ->setTva(20.00)
            ->setReduction(0.00)
            ->setTotal(1440.00)
            ->setTotalHt(1200.00);

        $commandes[] = (new Commande())
            ->setClient($utilisateurs[0])
            ->setCommercial($utilisateurs[1])
            ->setDateCommande(new \DateTimeImmutable())
            ->setModePaiement('PayPal')
            ->setStatu('Livrée')
            ->setTva(20.00)
            ->setReduction(100.00)
            ->setTotal(1360.00)
            ->setTotalHt(1133.33);

        foreach ($commandes as $commande) {
            $manager->persist($commande);
        }

        // Détails commande
        $detailsCommande = [];
        $detailsCommande[] = (new DetailCommande())
            ->setProduit($produits[0])
            ->setCommande($commandes[0])
            ->setQuantite(1)
            ->setPrix(1200.00);

        $detailsCommande[] = (new DetailCommande())
            ->setProduit($produits[1])
            ->setCommande($commandes[1])
            ->setQuantite(1)
            ->setPrix(1133.33);

        foreach ($detailsCommande as $detail) {
            $manager->persist($detail);
        }

        // Livraisons
        $livraisons = [];
        $livraisons[] = (new Livraison())
            ->setCommande($commandes[0])
            ->setDate(new \DateTimeImmutable())
            ->setEtat('En préparation');

        $livraisons[] = (new Livraison())
            ->setCommande($commandes[1])
            ->setDate(new \DateTimeImmutable())
            ->setEtat('Livrée');

        foreach ($livraisons as $livraison) {
            $manager->persist($livraison);
        }

        $manager->flush();
    }
}