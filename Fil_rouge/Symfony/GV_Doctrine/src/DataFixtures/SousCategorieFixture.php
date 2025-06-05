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

            ['nom' => 'Batteries Acoustiques', 'image' => 'image/souscategorie/default1.jpg', 'categorie_reference' => 'categorie-batteries-percussions', 'reference' => 'souscat-batteries-acoustiques'],
            ['nom' => 'Batteries Electriques', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-batteries-percussions', 'reference' => 'souscat-batteries-electriques'],

            ['nom' => 'Claviers Maîtres', 'image' => 'image/souscategorie/default1.jpg', 'categorie_reference' => 'categorie-pianos-claviers', 'reference' => 'souscat-claviers-maitres'],
            ['nom' => 'Pianos de Scène', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-pianos-claviers', 'reference' => 'souscat-pianos-scene'],

            ['nom' => 'Interfaces Audio', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-studio-enregistrement', 'reference' => 'souscat-interfaces-audio'],
            ['nom' => 'Microphones', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-studio-enregistrement', 'reference' => 'souscat-microphones'],

            ['nom' => 'Saxophones', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-instruments-vent', 'reference' => 'souscat-saxophones'],
            ['nom' => 'Trompettes', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-instruments-vent', 'reference' => 'souscat-trompettes'],

            ['nom' => 'Violons Acoustiques', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-instruments-traditionnels', 'reference' => 'souscat-violons-acoustiques'],
            ['nom' => 'Violons Electriques', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-instruments-traditionnels', 'reference' => 'souscat-violons-electriques'],

            ['nom' => 'Câbles pour Instruments', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-cables-connectique', 'reference' => 'souscat-cables-instruments'],
            ['nom' => 'Câbles pour Microphones', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-cables-connectique', 'reference' => 'souscat-cables-microphones'],

            ['nom' => 'Casques Audio', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-accessoires', 'reference' => 'souscat-casques-audio'],
            ['nom' => 'Bijoux pour Musiciens', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-accessoires', 'reference' => 'souscat-bijoux-musiciens'],

            ['nom' => 'Séquenceurs et Studios Virtuels', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-logiciels-musicaux', 'reference' => 'souscat-sequenceurs-studios'],
            ['nom' => 'Plug-Ins & Effets Audio', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-logiciels-musicaux', 'reference' => 'souscat-plugins-effets'],

            ['nom' => 'Enceintes', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-sonorisation', 'reference' => 'souscat-enceintes'],
            ['nom' => 'Accessoires Sonorisation', 'image' => 'image/souscategorie/default2.jpg', 'categorie_reference' => 'categorie-sonorisation', 'reference' => 'souscat-accessoires-sonorisation'],
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