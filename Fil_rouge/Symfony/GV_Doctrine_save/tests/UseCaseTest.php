<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UseCaseTest extends WebTestCase
{
    public function testSomething(): void
    {

         // 1.  Le client accède à la page d’accueil du site.

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Bienvenue chez,');

        // 2.  Le client sélectionne une catégorie de produits (ex : guitares, claviers...).

        $link = $crawler->filter('a.card-categorie-link')->first()->link();
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful();

        // 3.  Le client choisit une sous-catégorie (ex : guitares électriques, pianos numériques...).

        $link = $crawler->filter('a.card-categorie-link')->first()->link();
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful();

        // 4.  Le client consulte la fiche produit d’un article qui l’intéresse.

        $link = $crawler->filter('a.card-produit-btn')->first()->link();
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful();

        // 5.  Le client ajoute l’article au panier.

        $form = $crawler->selectButton('Ajouter au panier')->form();
        $form['quantite'] = 1;
        $crawler = $client->submit($form);
        $this->assertResponseRedirects();

        // 6.  Le client accède à son panier d’achat.

        $crawler = $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();

        // 7.  Le client vérifie les articles et les quantités sélectionnées.

        $this->assertSelectorTextContains('div.mt-12.text-center', "Nombre d'articles : 1");
        $this->assertResponseIsSuccessful();

        // 8.  Le client se connecte à son compte client ou crée un compte si c'est un nouveau client (React), le système envoie un mail de confirmation.

        $crawler = $client->request('GET', '/inscription');
        $this->assertResponseIsSuccessful();

        $csrfToken = $crawler->filter('#form-inscription-react')->attr('data-csrf-token');

        $formData = [
            'registration_form' => [
                'email' => 'test@gvtest.com',
                'nom' => 'Test',
                'prenom' => 'Test',
                'telephone' => '0706070607',
                'adresseLivraison' => '8 boulevard des Instruments, 80000 Village',
                'adresseFacturation' => '',
                'plainPassword' => 'password123',
                'agreeTerms' => true,
                '_token' => $csrfToken,
            ],
        ];

        $client->request('POST', '/inscription', $formData);
        $this->assertResponseRedirects();

        // 9. Le client retourne sur le panier et accéde a la page de paiement.

        $crawler = $client->request('GET', '/panier');
        $this->assertResponseIsSuccessful();

        $link = $crawler->selectLink('Valider la commande')->link();
        $crawler = $client->click($link);
        $this->assertResponseIsSuccessful();

         // 10. Le client accepte les cgv et valide la commande, la commande est enregistrée dans le système et un mail de confirmation est envoyé.

        $form = $crawler->filter('form#form-paiement')->form();
        $form['cgv'] = 'on'; 
        $client->submit($form);

        $client->followRedirect();
        $this->assertResponseIsSuccessful();

    }  
}