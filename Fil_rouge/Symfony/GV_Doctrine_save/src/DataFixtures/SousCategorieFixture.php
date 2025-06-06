<?php

namespace App\DataFixtures;

use App\Entity\SousCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Categorie;


class SousCategorieFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sousCategoriesData = [
            ['nom' => 'Guitares Electriques', 'image' => 'image/souscategorie/guitares-electriques.jpg', 'categorie_reference' => 'categorie-guitares-bases', 'reference' => 'souscat-guitares-electriques'],
            ['nom' => 'Guitares Acoustiques', 'image' => 'image/souscategorie/guitares-acoustiques.jpg', 'categorie_reference' => 'categorie-guitares-bases', 'reference' => 'souscat-guitares-acoustiques'],
            ['nom' => 'Basses Electriques', 'image' => 'image/souscategorie/basses-electriques.jpg', 'categorie_reference' => 'categorie-guitares-bases', 'reference' => 'souscat-basses-electriques'],

            ['nom' => 'Batteries Acoustiques', 'image' => 'image/souscategorie/batteries-acoustiques.jpg', 'categorie_reference' => 'categorie-batteries-percussions', 'reference' => 'souscat-batteries-acoustiques'],
            ['nom' => 'Batteries Electriques', 'image' => 'image/souscategorie/batteries-electriques.jpg', 'categorie_reference' => 'categorie-batteries-percussions', 'reference' => 'souscat-batteries-electriques'],

            ['nom' => 'Claviers Maîtres', 'image' => 'image/souscategorie/claviers-maitres.jpg', 'categorie_reference' => 'categorie-pianos-claviers', 'reference' => 'souscat-claviers-maitres'],
            ['nom' => 'Pianos de Scène', 'image' => 'image/souscategorie/pianos-scene.jpg', 'categorie_reference' => 'categorie-pianos-claviers', 'reference' => 'souscat-pianos-scene'],

            ['nom' => 'Interfaces Audio', 'image' => 'image/souscategorie/interfaces-audio.jpg', 'categorie_reference' => 'categorie-studio-enregistrement', 'reference' => 'souscat-interfaces-audio'],
            ['nom' => 'Microphones', 'image' => 'image/souscategorie/microphones.jpg', 'categorie_reference' => 'categorie-studio-enregistrement', 'reference' => 'souscat-microphones'],

            ['nom' => 'Saxophones', 'image' => 'image/souscategorie/saxophones.jpg', 'categorie_reference' => 'categorie-instruments-vent', 'reference' => 'souscat-saxophones'],
            ['nom' => 'Trompettes', 'image' => 'image/souscategorie/trompettes.jpg', 'categorie_reference' => 'categorie-instruments-vent', 'reference' => 'souscat-trompettes'],

            ['nom' => 'Violons Acoustiques', 'image' => 'image/souscategorie/violons-acoustiques.jpg', 'categorie_reference' => 'categorie-instruments-traditionnels', 'reference' => 'souscat-violons-acoustiques'],
            ['nom' => 'Violons Electriques', 'image' => 'image/souscategorie/violons-electriques.jpg', 'categorie_reference' => 'categorie-instruments-traditionnels', 'reference' => 'souscat-violons-electriques'],

            ['nom' => 'Câbles pour Instruments', 'image' => 'image/souscategorie/cables-instruments.jpg', 'categorie_reference' => 'categorie-cables-connectique', 'reference' => 'souscat-cables-instruments'],
            ['nom' => 'Câbles pour Microphones', 'image' => 'image/souscategorie/cables-microphones.jpg', 'categorie_reference' => 'categorie-cables-connectique', 'reference' => 'souscat-cables-microphones'],

            ['nom' => 'Casques Audio', 'image' => 'image/souscategorie/casques-audio.jpg', 'categorie_reference' => 'categorie-accessoires', 'reference' => 'souscat-casques-audio'],
            ['nom' => 'Bijoux pour Musiciens', 'image' => 'image/souscategorie/bijoux-musiciens.jpg', 'categorie_reference' => 'categorie-accessoires', 'reference' => 'souscat-bijoux-musiciens'],

            ['nom' => 'Séquenceurs et Studios Virtuels', 'image' => 'image/souscategorie/sequenceurs-studios.jpg', 'categorie_reference' => 'categorie-logiciels-musicaux', 'reference' => 'souscat-sequenceurs-studios'],
            ['nom' => 'Plug-Ins & Effets Audio', 'image' => 'image/souscategorie/plugins-effets.jpg', 'categorie_reference' => 'categorie-logiciels-musicaux', 'reference' => 'souscat-plugins-effets'],

            ['nom' => 'Enceintes', 'image' => 'image/souscategorie/enceintes.jpg', 'categorie_reference' => 'categorie-sonorisation', 'reference' => 'souscat-enceintes'],
            ['nom' => 'Accessoires Sonorisation', 'image' => 'image/souscategorie/accessoires-sonorisation.jpg', 'categorie_reference' => 'categorie-sonorisation', 'reference' => 'souscat-accessoires-sonorisation'],
        ];

        foreach ($sousCategoriesData as $data) {
            $sousCategorie = new SousCategorie();
            $sousCategorie->setNom($data['nom']);
            $sousCategorie->setImage($data['image']);
            $sousCategorie->setActive(true); // tu peux ajuster si nécessaire
            $sousCategorie->setCategorie($this->getReference($data['categorie_reference'], Categorie::class));

            $manager->persist($sousCategorie);
            $this->addReference($data['reference'], $sousCategorie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixture::class,
        ];
    }
}