<?php

namespace App\DataFixtures;

use App\Entity\Fournisseur;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FournisseurFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $fournisseursData = [
            [
                'nom' => 'Thomann GmbH',
                'email' => 'contact@thomann.de',
                'telephone' => '+49 9546 92230',
                'adresse' => 'Hans-Thomann-Strasse 1, 96138 Burgebrach, Allemagne',
                'commercial' => 'commercial1@example.com',
                'reference' => 'fournisseur-thomann',
            ],
            [
                'nom' => 'Woodbrass',
                'email' => 'service-client@woodbrass.com',
                'telephone' => '01 80 39 38 38',
                'adresse' => '182 avenue Jean Jaurès, 75019 Paris, France',
                'commercial' => 'commercial1@example.com',
                'reference' => 'fournisseur-woodbrass',
            ],
            [
                'nom' => 'Musikhaus Kirstein',
                'email' => 'info@kirstein.de',
                'telephone' => '+49 8861 9094940',
                'adresse' => 'Bernbeurener Straße 11, 86956 Schongau, Allemagne',
                'commercial' => 'commercial2@example.com',
                'reference' => 'fournisseur-kirstein',
            ],
            [
                'nom' => 'Star’s Music',
                'email' => 'contact@stars-music.fr',
                'telephone' => '01 81 930 900',
                'adresse' => '11 rue du Port, 92100 Boulogne-Billancourt, France',
                'commercial' => 'commercial2@example.com',
                'reference' => 'fournisseur-starsmusic',
            ],
            [
                'nom' => 'Bax Music',
                'email' => 'service@bax-shop.fr',
                'telephone' => '03 66 88 00 23',
                'adresse' => 'Rue du Textile 5, 59115 Leers, France',
                'commercial' => 'commercial3@example.com',
                'reference' => 'fournisseur-baxmusic',
            ],
            [
                'nom' => 'Gear4music',
                'email' => 'info@gear4music.com',
                'telephone' => '+44 330 365 4444',
                'adresse' => 'Holgate Park Drive, York YO26 4GN, Royaume-Uni',
                'commercial' => 'commercial3@example.com',
                'reference' => 'fournisseur-gear4music',
            ],
        ];

        foreach ($fournisseursData as $data) {
            $fournisseur = new Fournisseur();
            $fournisseur
                ->setNom($data['nom'])
                ->setEmail($data['email'])
                ->setTelephone($data['telephone'])
                ->setAdresse($data['adresse'])
                ->setCommercial($this->getReference($data['commercial'], Utilisateur::class));

            $manager->persist($fournisseur);
            $this->addReference($data['reference'], $fournisseur);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixture::class,
        ];
    }
}