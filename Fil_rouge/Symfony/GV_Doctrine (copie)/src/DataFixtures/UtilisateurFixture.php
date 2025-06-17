<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $utilisateursData = [
            // Commerciaux
            [
                'email' => 'commercial1@example.com',
                'nom' => 'Dupont',
                'prenom' => 'Michel',
                'roles' => ['ROLE_COMMERCIAL'],
                'telephone' => '0101010101',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => null,
            ],
            [
                'email' => 'commercial2@example.com',
                'nom' => 'Lemoine',
                'prenom' => 'Claire',
                'roles' => ['ROLE_COMMERCIAL'],
                'telephone' => '0202020202',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => null,
            ],
            [
                'email' => 'commercial3@example.com',
                'nom' => 'Moreau',
                'prenom' => 'Julien',
                'roles' => ['ROLE_COMMERCIAL'],
                'telephone' => '0303030303',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => null,
            ],

            // Clients
            [
                'email' => 'client1@example.com',
                'nom' => 'Martin',
                'prenom' => 'Sophie',
                'roles' => ['ROLE_CLIENT'],
                'telephone' => '0404040404',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => 'commercial1@example.com',
                'adresseLivraison' => '12 rue de la Paix, 75002 Paris',
                'adresseFacturation' => '45 avenue des Champs, 75008 Paris',
            ],
            [
                'email' => 'client2@example.com',
                'nom' => 'Bernard',
                'prenom' => 'Paul',
                'roles' => ['ROLE_CLIENT'],
                'telephone' => '0505050505',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => 'commercial2@example.com',
                'adresseLivraison' => '5 place de la République, 75003 Paris',
                'adresseFacturation' => '5 place de la République, 75003 Paris',
            ],
            [
                'email' => 'client3@example.com',
                'nom' => 'Dubois',
                'prenom' => 'Claire',
                'roles' => ['ROLE_CLIENT'],
                'telephone' => '0606060606',
                'coefficient' => null,
                'password' => 'pass1234',
                'commercialEmail' => 'commercial3@example.com',
                'adresseLivraison' => '8 rue Lafayette, 75009 Paris',
                'adresseFacturation' => '8 rue Lafayette, 75009 Paris',
            ],

            // Clients pros
            [
                'email' => 'clientpro1@example.com',
                'nom' => 'Faure',
                'prenom' => 'Anne',
                'roles' => ['ROLE_CLIENT_PRO'],
                'telephone' => '0707070707',
                'coefficient' => '1.30',
                'password' => 'pass1234',
                'commercialEmail' => 'commercial1@example.com',
                'adresseLivraison' => '9 boulevard Saint-Michel, 75005 Paris',
                'adresseFacturation' => '9 boulevard Saint-Michel, 75005 Paris',
            ],
            [
                'email' => 'clientpro2@example.com',
                'nom' => 'Roussel',
                'prenom' => 'Marc',
                'roles' => ['ROLE_CLIENT_PRO'],
                'telephone' => '0808080808',
                'coefficient' => '1.25',
                'password' => 'pass1234',
                'commercialEmail' => 'commercial2@example.com',
                'adresseLivraison' => '14 rue de Rivoli, 75004 Paris',
                'adresseFacturation' => '14 rue de Rivoli, 75004 Paris',
            ],
            [
                'email' => 'clientpro3@example.com',
                'nom' => 'Gautier',
                'prenom' => 'Isabelle',
                'roles' => ['ROLE_CLIENT_PRO'],
                'telephone' => '0909090909',
                'coefficient' => '1.28',
                'password' => 'pass1234',
                'commercialEmail' => 'commercial3@example.com',
                'adresseLivraison' => '20 avenue Victor Hugo, 75116 Paris',
                'adresseFacturation' => '20 avenue Victor Hugo, 75116 Paris',
            ],
        ];

        // Création des commerciaux d'abord
        $utilisateurs = [];
        foreach ($utilisateursData as $data) {
            if ($data['commercialEmail'] === null) {
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($data['email'])
                    ->setNom($data['nom'])
                    ->setPrenom($data['prenom'])
                    ->setRoles($data['roles'])
                    ->setTelephone($data['telephone'])
                    ->setCoefficient($data['coefficient']);

                $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $data['password']);
                $utilisateur->setPassword($hashedPassword);

                $manager->persist($utilisateur);
                $utilisateurs[$data['email']] = $utilisateur;
                $this->addReference($data['email'], $utilisateur);
            }
        }

        // Création des clients et clients pros, en liant à leur commercial
        foreach ($utilisateursData as $data) {
            if ($data['commercialEmail'] !== null) {
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($data['email'])
                    ->setNom($data['nom'])
                    ->setPrenom($data['prenom'])
                    ->setRoles($data['roles'])
                    ->setTelephone($data['telephone'])
                    ->setCoefficient($data['coefficient'])
                    ->setCommercial($utilisateurs[$data['commercialEmail']])
                    ->setAdresseLivraison($data['adresseLivraison'] ?? null)
                    ->setAdresseFacturation($data['adresseFacturation'] ?? null);

                $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $data['password']);
                $utilisateur->setPassword($hashedPassword);

                $manager->persist($utilisateur);
                $utilisateurs[$data['email']] = $utilisateur;
                $this->addReference($data['email'], $utilisateur);
            }
        }

        $manager->flush();
    }
}