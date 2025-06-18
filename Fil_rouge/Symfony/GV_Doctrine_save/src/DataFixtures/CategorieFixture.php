<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $categoriesData = [
                ['nom' => 'Guitares et Bases', 'image' => 'image/categorie/GuitaresBases.jpg', 'reference' => 'categorie-guitares-bases'],
                ['nom' => 'Batteries et Percussions', 'image' => 'image/categorie/batteries.jpg', 'reference' => 'categorie-batteries-percussions'],
                ['nom' => 'Pianos et Claviers', 'image' => 'image/categorie/pianos.jpg', 'reference' => 'categorie-pianos-claviers'],
                ['nom' => 'Studio et Enregistrement', 'image' => 'image/categorie/studio.jpg', 'reference' => 'categorie-studio-enregistrement'],
                ['nom' => 'Instruments à Vent', 'image' => 'image/categorie/instruments-vent.jpg', 'reference' => 'categorie-instruments-vent'],
                ['nom' => 'Instruments Traditionnels', 'image' => 'image/categorie/instruments-traditionnels.jpg', 'reference' => 'categorie-instruments-traditionnels'],
                ['nom' => 'Câbles et Connectique', 'image' => 'image/categorie/cables.jpg', 'reference' => 'categorie-cables-connectique'],
                ['nom' => 'Accessoires pour Musiciens', 'image' => 'image/categorie/accessoires.jpg', 'reference' => 'categorie-accessoires'],
                ['nom' => 'Logiciels Musicaux', 'image' => 'image/categorie/logiciels.jpg', 'reference' => 'categorie-logiciels-musicaux'],
                ['nom' => 'Sonorisation', 'image' => 'image/categorie/sonorisation.jpg', 'reference' => 'categorie-sonorisation'],
            ];

        // ['nom' => '', 'image' => 'image/categorie/', 'reference' => 'categorie-'],

        foreach ($categoriesData as $data) {
            $categorie = (new Categorie())
                ->setActive(true)
                ->setNom($data['nom'])
                ->setImage($data['image']);

            $manager->persist($categorie);
            $this->addReference($data['reference'], $categorie);
        }

        $manager->flush();
    }
}