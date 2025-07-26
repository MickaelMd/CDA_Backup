<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UseCaseTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}




    // 1.  Le client accède à la page d’accueil du site.
    // 2.  Il sélectionne une catégorie de produits (ex : guitares, claviers...).
    // 3.  Il choisit une sous-catégorie (ex : guitares électriques, pianos numériques...).
    // 4.  Il consulte la fiche produit d’un article qui l’intéresse.
    // 5.  Il ajoute l’article au panier.
    // 6.  Il accède à son panier d’achat.
    // 7.  Il vérifie les articles et les quantités sélectionnées.
    // 8.  Il se connecte à son compte client ou crée un compte si c'est un nouveau client.
    // 9.  Il ajoute/modifie ses informations de livraison et de facturation.
    // 10. Il choisit un mode de paiement (CB, PayPal, etc.).
    // 11. La commande est enregistrée dans le système.
    // 12. Une facture est automatiquement générée.
    // 13. Un bon de livraison est également généré.
    // 14. La commande est facturée.
    // 15. La commande est expédiée au client.