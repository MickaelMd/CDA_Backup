<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\SousCategorie;
use App\Entity\Fournisseur;

class ProduitFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $produitsData = [

            // Guitare Electrique

            [
                'libelleCourt' => 'Gibson Les Paul Standard 50s TB',
                'libelleLong' => 'Il n’y a que très peu de modèles de guitares qui ont marqué des générations de musiciens et l’histoire-même de la musique. La Les Paul de Gibson en fait partie, définitivement. Bien sûr, depuis son apparition il y a 70 ans, le modèle d’origine a connu de nombreuses variations. Mais au final, les musiciens reviennent toujours vers les instruments fabriqués selon les méthodes des années 50 et du début des années 60. C’est exactement cette part d’histoire de la guitare électrique qu’ils obtiennent avec ce modèle – bien entendu de la meilleure qualité et fabriqué aux USA.',
                'image' => 'image/produit/Gibson_Les_Paul_Standard_50s_TB.jpg',
                'prixHt' => '2000.00',
                'prixFournisseur' => '1500.00',
                'stock' => 8,
                'active' => true,
                'sousCategorie' => 'souscat-guitares-electriques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
            [
                'libelleCourt' => 'Fender AV II 61 STRAT RW OWT',
                'libelleLong' => 'La Fender American Vintage II 1961 Stratocaster avec touche en palissandre (Rosewood) et finition Olympic White est une guitare électrique emblématique recréant fidèlement le modèle légendaire des années 60. Fabriquée aux USA, elle offre un confort de jeu exceptionnel, un son clair et précis typique des Stratocaster vintage, et une esthétique intemporelle.',
                'image' => 'image/produit/Fender_AV_II_61_STRAT_RW_OWT.jpg',
                'prixHt' => '1840.00',
                'prixFournisseur' => '1500.00',
                'stock' => 5,
                'active' => true,
                'sousCategorie' => 'souscat-guitares-electriques',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Guitare Acoustique
                  [
                'libelleCourt' => 'Taylor 512ce 12-Fret Urban Ironbark',
                'libelleLong' => 'La Taylor 512ce 12-Fret Urban Ironbark est une guitare acoustique électro-acoustique de qualité supérieure, conçue avec une table en épicéa Sitka et un dos/éclisses en Urban Ironbark, un bois australien durable et dense. Son manche 12 frettes offre une sonorité riche et une jouabilité confortable, idéale pour les musiciens exigeants en quête d’un son clair et puissant, avec un look unique et moderne.',
                'image' => 'image/produit/Taylor_512ce_12-Fret_Urban_Ironbark.jpg',
                'prixHt' => '1840.00',
                'prixFournisseur' => '1500.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-guitares-acoustiques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
                    [
                'libelleCourt' => 'Fender Acoustasonic Standard Tele AGN',
                'libelleLong' => 'La Fender Acoustasonic Standard Telecaster en finition Antique Olive Green combine la polyvalence d’une guitare acoustique et électrique avec une qualité de fabrication exceptionnelle. Elle offre un son riche et dynamique grâce à son système de micros innovant et une jouabilité confortable, idéale pour les musiciens recherchant un instrument hybride haut de gamme.',
                'image' => 'image/produit/Fender_Acoustasonic_Standard_Tele_AGN.jpg',
                'prixHt' => '540.99',
                'prixFournisseur' => '500.00',
                'stock' => 6,
                'active' => true,
                'sousCategorie' => 'souscat-guitares-acoustiques',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Basse Electrique
                       [
                'libelleCourt' => 'Sadowsky MasterBuilt 21 MJ LTD 4 NTS',
                'libelleLong' => 'La Sadowsky MasterBuilt 21 MJ LTD est une basse électrique haut de gamme, fabriquée à la main avec des matériaux nobles. Son corps en noyer (NTS) offre une résonance profonde et un son clair, parfait pour les bassistes exigeants. Cette édition limitée est une pièce d’exception alliant tradition et innovation.',
                'image' => 'image/produit/Sadowsky_MasterBuilt_21_MJ_LTD_4_NTS.jpg',
                'prixHt' => '5900.99',
                'prixFournisseur' => '4500.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-basses-electriques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
                       [
                'libelleCourt' => 'Squier Affinity P Bass MN PJ OW',
                'libelleLong' => 'La Squier Affinity P Bass MN PJ en finition Olympic White est une basse électrique abordable et fiable, idéale pour les débutants comme pour les joueurs intermédiaires. Son manche en érable et son électronique PJ offrent un son polyvalent, couvrant un large spectre de styles musicaux avec aisance.',
                'image' => 'image/produit/Squier_Affinity_P_Bass_MN_PJ_OW.jpg',                'prixHt' => '190.00',
                'prixFournisseur' => '140.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-basses-electriques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
            // Batteries Acoustiques
            [
                'libelleCourt' => 'Pearl Export EXX725SBR/C31',
                'libelleLong' => 'Le Pearl Export EXX725SBR est un kit acoustique 5 fûts complet, idéal pour les batteurs en quête d’un son puissant et équilibré. Fabriqué avec un mélange de peuplier et d’acajou asiatique, il offre une excellente résonance et durabilité. Ce kit est livré avec un hardware robuste et des finitions élégantes.',
                'image' => 'image/produit/Pearl_Export_EXX725SBR.jpg',
                'prixHt' => '749.00',
                'prixFournisseur' => '620.00',
                'stock' => 3,
                'active' => true,
                'sousCategorie' => 'souscat-batteries-acoustiques',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Yamaha Stage Custom Birch Shell Set HB',
                'libelleLong' => 'Le Yamaha Stage Custom Birch est un kit de batterie acoustique 5 fûts reconnu pour sa projection claire et sa réponse dynamique grâce à sa conception 100% bouleau. Il est idéal pour les batteurs en studio ou sur scène à la recherche de précision sonore et de fiabilité.',
                'image' => 'image/produit/Yamaha_Stage_Custom_Birch_HB.jpg',
                'prixHt' => '829.00',
                'prixFournisseur' => '700.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-batteries-acoustiques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],

            // Batteries Électriques
            [
                'libelleCourt' => 'Roland TD-17KVX V-Drums',
                'libelleLong' => 'La Roland TD-17KVX est une batterie électronique haut de gamme qui offre une sensation de jeu réaliste grâce à sa technologie de capteurs avancée et ses peaux maillées. Son module TD-17 propose des sons dynamiques et personnalisables, parfaits pour la scène comme pour l’entraînement.',
                'image' => 'image/produit/Roland_TD-17KVX.jpg',
                'prixHt' => '1399.00',
                'prixFournisseur' => '1180.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-batteries-electriques',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Alesis Nitro Max Kit',
                'libelleLong' => 'L’Alesis Nitro Max est un kit de batterie électronique accessible et complet, idéal pour les débutants comme pour les musiciens confirmés. Il comprend des pads réactifs, un module puissant avec de nombreux sons et connexions USB/MIDI pour l’enregistrement et le jeu.',
                'image' => 'image/produit/Alesis_Nitro_Max.jpg',
                'prixHt' => '399.00',
                'prixFournisseur' => '350.00',
                'stock' => 5,
                'active' => true,
                'sousCategorie' => 'souscat-batteries-electriques',
                'fournisseur' => 'fournisseur-woodbrass',
            ],

            // Clavier Maitre

            [
                'libelleCourt' => 'Arturia KeyLab Essential 61',
                'libelleLong' => 'Le Arturia KeyLab Essential 61 est un clavier maître USB/MIDI de 61 touches semi-lestées, parfait pour la production musicale. Il inclut des pads, des faders, des potentiomètres assignables, ainsi que l’accès à Analog Lab, un logiciel regroupant des sons issus des synthétiseurs vintage.',
                'image' => 'image/produit/Arturia_KeyLab_Essential_61.jpg',
                'prixHt' => '239.00',
                'prixFournisseur' => '199.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-claviers-maitres',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Native Instruments Komplete Kontrol S49 MK2',
                'libelleLong' => 'Le Native Instruments Komplete Kontrol S49 MK2 est un clavier maître de 49 touches Fatar semi-lestées, conçu pour une intégration parfaite avec Komplete et les DAWs. Il dispose de deux écrans couleur, de molettes tactiles, et d’un éclairage intelligent des touches.',
                'image' => 'image/produit/NI_Komplete_Kontrol_S49_MK2.jpg',
                'prixHt' => '599.00',
                'prixFournisseur' => '510.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-claviers-maitres',
                'fournisseur' => 'fournisseur-woodbrass',
            ],

            // Piano Scene

            [
                'libelleCourt' => 'Yamaha CP88',
                'libelleLong' => 'Le Yamaha CP88 est un piano de scène professionnel doté de 88 touches avec mécanique à marteaux graduée (GHS), d’échantillons de pianos acoustiques exceptionnels, et d’une interface intuitive pour le live. Il est conçu pour la scène, le studio et les performances exigeantes.',
                'image' => 'image/produit/Yamaha_CP88.jpg',
                'prixHt' => '1999.00',
                'prixFournisseur' => '1750.00',
                'stock' => 1,
                'active' => true,
                'sousCategorie' => 'souscat-pianos-scene',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Nord Stage 4 88',
                'libelleLong' => 'Le Nord Stage 4 88 est un piano de scène haut de gamme avec 88 touches lestées et aftertouch, intégrant les moteurs Nord Piano, Organ et Synth. Sa polyvalence, ses sons de qualité exceptionnelle et son interface ergonomique en font un choix de prédilection pour les musiciens professionnels.',
                'image' => 'image/produit/Nord_Stage_4_88.jpg',
                'prixHt' => '4599.00',
                'prixFournisseur' => '3850.00',
                'stock' => 1,
                'active' => true,
                'sousCategorie' => 'souscat-pianos-scene',
                'fournisseur' => 'fournisseur-woodbrass',
            ],

            // Interface audio

            [
                'libelleCourt' => 'Focusrite Scarlett 2i2 4th Gen',
                'libelleLong' => 'L’interface audio Focusrite Scarlett 2i2 4e génération offre une qualité d’enregistrement professionnelle avec deux entrées combo XLR/jack, une conversion jusqu’à 24 bits/192 kHz, et une faible latence. Compatible Mac/PC, elle est idéale pour les home studios.',
                'image' => 'image/produit/Focusrite_Scarlett_2i2_4th_Gen.jpg',
                'prixHt' => '139.00',
                'prixFournisseur' => '119.00',
                'stock' => 5,
                'active' => true,
                'sousCategorie' => 'souscat-interfaces-audio',
                'fournisseur' => 'fournisseur-baxmusic',
            ],
            [
                'libelleCourt' => 'Universal Audio Volt 276',
                'libelleLong' => 'L’Universal Audio Volt 276 est une interface audio USB avec préamplis vintage, compresseur analogique intégré, et convertisseurs 24 bits / 192 kHz. Parfaite pour les créateurs cherchant une qualité de studio dans un format compact.',
                'image' => 'image/produit/UA_Volt_276.jpg',
                'prixHt' => '299.00',
                'prixFournisseur' => '255.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-interfaces-audio',
                'fournisseur' => 'fournisseur-kirstein',
            ],

            // Micro

            [
                'libelleCourt' => 'Shure SM7B',
                'libelleLong' => 'Le Shure SM7B est un microphone dynamique cardioïde emblématique, largement utilisé pour la voix, la radio, le podcast et même les instruments. Il offre un son chaud et naturel avec un excellent rejet des bruits ambiants.',
                'image' => 'image/produit/Shure_SM7B.jpg',
                'prixHt' => '419.00',
                'prixFournisseur' => '349.00',
                'stock' => 3,
                'active' => true,
                'sousCategorie' => 'souscat-microphones',
                'fournisseur' => 'fournisseur-starsmusic',
            ],
            [
                'libelleCourt' => 'Rode NT1 5th Generation',
                'libelleLong' => 'Le Rode NT1 5th Gen est un micro statique à large membrane très silencieux avec connectique XLR + USB-C, idéal pour le studio à la maison. Il est livré avec une suspension antichoc et un filtre anti-pop.',
                'image' => 'image/produit/Rode_NT1_5G.jpg',
                'prixHt' => '275.00',
                'prixFournisseur' => '229.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-microphones',
                'fournisseur' => 'fournisseur-gear4music',
            ],

            // Saxophone 

            [
                'libelleCourt' => 'Yamaha YAS-280 Alto',
                'libelleLong' => 'Le Yamaha YAS-280 est un saxophone alto parfait pour les débutants. Il est léger, bien équilibré, avec une mécanique fluide et une excellente justesse. Livré avec étui, bec, ligature et sangle.',
                'image' => 'image/produit/Yamaha_YAS-280.jpg',
                'prixHt' => '799.00',
                'prixFournisseur' => '689.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-saxophones',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Selmer Axos Alto',
                'libelleLong' => 'Le Selmer Axos est un saxophone alto fabriqué en France. Il combine l’ergonomie des modèles professionnels avec un son riche et centré, parfait pour les étudiants avancés et les amateurs exigeants.',
                'image' => 'image/produit/Selmer_Axos.jpg',
                'prixHt' => '2499.00',
                'prixFournisseur' => '2120.00',
                'stock' => 1,
                'active' => true,
                'sousCategorie' => 'souscat-saxophones',
                'fournisseur' => 'fournisseur-starsmusic',
            ],

            // Trompette

            [
                'libelleCourt' => 'Bach TR650',
                'libelleLong' => 'La Bach TR650 est une trompette d’étude très populaire, offrant une bonne réponse, une justesse correcte et un confort de jeu idéal pour les débutants. Livrée avec étui rigide et embouchure.',
                'image' => 'image/produit/Bach_TR650.jpg',
                'prixHt' => '349.00',
                'prixFournisseur' => '299.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-trompettes',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
            [
                'libelleCourt' => 'Yamaha YTR-4335GS II',
                'libelleLong' => 'La Yamaha YTR-4335GSII est une trompette intermédiaire en finition argentée. Elle offre une excellente jouabilité et une grande durabilité, idéale pour les étudiants avancés ou les amateurs passionnés.',
                'image' => 'image/produit/Yamaha_YTR-4335GSII.jpg',
                'prixHt' => '729.00',
                'prixFournisseur' => '619.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-trompettes',
                'fournisseur' => 'fournisseur-kirstein',
            ],

            // Violon Acoustique

            [
                'libelleCourt' => 'Stentor Student I 1/2',
                'libelleLong' => 'Le Stentor Student I est un violon parfait pour les jeunes débutants. Il est livré avec archet, colophane et un étui léger. Fabrication solide, bonne sonorité pour l’apprentissage.',
                'image' => 'image/produit/Stentor_Student_I.jpg',
                'prixHt' => '139.00',
                'prixFournisseur' => '119.00',
                'stock' => 3,
                'active' => true,
                'sousCategorie' => 'souscat-violons-acoustiques',
                'fournisseur' => 'fournisseur-baxmusic',
            ],
            [
                'libelleCourt' => 'Yamaha V3SKA 4/4',
                'libelleLong' => 'Le Yamaha V3SKA 4/4 est un violon d’étude tout équipé : archet, colophane et étui rigide. Parfait pour les débutants cherchant un instrument fiable et prêt à jouer.',
                'image' => 'image/produit/Yamaha_V3SKA.jpg',
                'prixHt' => '229.00',
                'prixFournisseur' => '199.00',
                'stock' => 2,
                'active' => true,
                'sousCategorie' => 'souscat-violons-acoustiques',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Violon Electrique

            [
                'libelleCourt' => 'Harley Benton HBV 870BK',
                'libelleLong' => 'Le HBV 870BK est un violon électrique à petit prix, idéal pour s’exercer silencieusement avec casque. Livré avec archet, colophane, câble et étui rigide.',
                'image' => 'image/produit/HarleyBenton_HBV_870BK.jpg',
                'prixHt' => '119.00',
                'prixFournisseur' => '99.00',
                'stock' => 4,
                'active' => true,
                'sousCategorie' => 'souscat-violons-electriques',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Yamaha YEV-104',
                'libelleLong' => 'Le Yamaha YEV-104 est un violon électrique 4 cordes en bois naturel avec un design moderne et un excellent confort de jeu. Compatible amplis et pédales d’effet.',
                'image' => 'image/produit/Yamaha_YEV104.jpg',
                'prixHt' => '589.00',
                'prixFournisseur' => '499.00',
                'stock' => 1,
                'active' => true,
                'sousCategorie' => 'souscat-violons-electriques',
                'fournisseur' => 'fournisseur-gear4music',
            ],

            // Cables Pour Instruments 


            [
                'libelleCourt' => 'Cordial CFI 3 PP',
                'libelleLong' => 'Le Cordial CFI 3 PP est un câble instrument de 3 m avec connecteurs jack 6.35 mm mono plaqués or. Excellente qualité sonore et durabilité, fabriqué en Allemagne.',
                'image' => 'image/produit/Cordial_CFI3PP.jpg',
                'prixHt' => '12.90',
                'prixFournisseur' => '9.90',
                'stock' => 10,
                'active' => true,
                'sousCategorie' => 'souscat-cables-instruments',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'Fender Deluxe Series 3m',
                'libelleLong' => 'Le câble Fender Deluxe Series est un câble pour guitare de 3 m avec des connecteurs plaqués or et un blindage haute densité pour limiter les interférences. Robuste et fiable.',
                'image' => 'image/produit/Fender_Deluxe_Cable.jpg',
                'prixHt' => '22.00',
                'prixFournisseur' => '18.50',
                'stock' => 6,
                'active' => true,
                'sousCategorie' => 'souscat-cables-instruments',
                'fournisseur' => 'fournisseur-starsmusic',
            ],

            // Cable Microphone

            [
                'libelleCourt' => 'Sommer Cable Galileo 5m',
                'libelleLong' => 'Le Sommer Cable Galileo est un câble micro XLR mâle/femelle de 5 m. Conducteurs en cuivre OFC, blindage efficace, conçu pour une restitution claire du signal.',
                'image' => 'image/produit/Sommer_Cable_Galileo.jpg',
                'prixHt' => '18.90',
                'prixFournisseur' => '15.00',
                'stock' => 5,
                'active' => true,
                'sousCategorie' => 'souscat-cables-microphones',
                'fournisseur' => 'fournisseur-kirstein',
            ],
            [
                'libelleCourt' => 'Pro Snake TPM 10',
                'libelleLong' => 'Le Pro Snake TPM 10 est un câble XLR de 10 m à prix abordable, idéal pour la scène ou le studio. Connecteurs robustes, qualité de transmission correcte.',
                'image' => 'image/produit/ProSnake_TPM10.jpg',
                'prixHt' => '12.50',
                'prixFournisseur' => '9.90',
                'stock' => 7,
                'active' => true,
                'sousCategorie' => 'souscat-cables-microphones',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Casque audio

            [
                'libelleCourt' => 'Audio-Technica ATH-M50x',
                'libelleLong' => 'Le casque Audio-Technica ATH-M50x est un modèle professionnel de monitoring audio, offrant une excellente isolation et une restitution sonore précise, apprécié par les musiciens et ingénieurs du son.',
                'image' => 'image/produit/Audio_Technica_ATH-M50x.jpg',
                'prixHt' => '140.00',
                'prixFournisseur' => '120.00',
                'stock' => 12,
                'active' => true,
                'sousCategorie' => 'souscat-casques-audio',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
            [
                'libelleCourt' => 'Beyerdynamic DT 770 Pro 80 Ohm',
                'libelleLong' => 'Le Beyerdynamic DT 770 Pro est un casque fermé de studio, connu pour son confort et sa qualité sonore, idéal pour le mixage et l’écoute critique en environnement professionnel.',
                'image' => 'image/produit/Beyerdynamic_DT770Pro.jpg',
                'prixHt' => '150.00',
                'prixFournisseur' => '130.00',
                'stock' => 9,
                'active' => true,
                'sousCategorie' => 'souscat-casques-audio',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Bijoux

            [
                'libelleCourt' => 'Bracelet médiator cuir noir',
                'libelleLong' => 'Bracelet en cuir noir véritable, orné d’un médiator en métal argenté. Accessoire stylé et discret pour guitaristes et fans de musique.',
                'image' => 'image/produit/Bracelet_Mediator_Cuir_Noir.jpg',
                'prixHt' => '25.00',
                'prixFournisseur' => '18.00',
                'stock' => 15,
                'active' => true,
                'sousCategorie' => 'souscat-bijoux-musiciens',
                'fournisseur' => 'fournisseur-starsmusic',
            ],
            [
                'libelleCourt' => 'Collier clé de sol argentée',
                'libelleLong' => 'Collier délicat avec pendentif clé de sol en métal argenté, parfait pour les amateurs de musique souhaitant afficher leur passion avec élégance.',
                'image' => 'image/produit/Collier_Cle_de_Sol.jpg',
                'prixHt' => '30.00',
                'prixFournisseur' => '22.00',
                'stock' => 10,
                'active' => true,
                'sousCategorie' => 'souscat-bijoux-musiciens',
                'fournisseur' => 'fournisseur-baxmusic',
            ],
            // Séquenceurs et Studios Virtuels

            [
                'libelleCourt' => 'Ableton Live Suite 11',
                'libelleLong' => 'Logiciel de production musicale complet avec séquenceur, instruments virtuels et effets avancés, idéal pour la composition et le live.',
                'image' => 'image/produit/Ableton_Live_Suite_11.jpg',
                'prixHt' => '399.00',
                'prixFournisseur' => '320.00',
                'stock' => 20,
                'active' => true,
                'sousCategorie' => 'souscat-sequenceurs-studios',
                'fournisseur' => 'fournisseur-thomann',
            ],
            [
                'libelleCourt' => 'FL Studio Producer Edition',
                'libelleLong' => 'Studio de création musicale complet avec séquenceur multi-pistes, synthétiseurs intégrés et support VST.',
                'image' => 'image/produit/FL_Studio_Producer.jpg',
                'prixHt' => '299.00',
                'prixFournisseur' => '250.00',
                'stock' => 18,
                'active' => true,
                'sousCategorie' => 'souscat-sequenceurs-studios',
                'fournisseur' => 'fournisseur-baxmusic',
            ],

            // Plug-Ins & Effets Audio

            [
                'libelleCourt' => 'Waves SSL E-Channel',
                'libelleLong' => 'Plugin de mixage audio modélisant la célèbre console SSL, avec égaliseur et compresseur pour un son professionnel.',
                'image' => 'image/produit/Waves_SSL_E_Channel.jpg',
                'prixHt' => '150.00',
                'prixFournisseur' => '120.00',
                'stock' => 25,
                'active' => true,
                'sousCategorie' => 'souscat-plugins-effets',
                'fournisseur' => 'fournisseur-gear4music',
            ],
            [
                'libelleCourt' => 'FabFilter Pro-Q 3',
                'libelleLong' => 'Égaliseur paramétrique avancé avec interface intuitive, idéal pour le mixage et le mastering audio.',
                'image' => 'image/produit/FabFilter_ProQ3.jpg',
                'prixHt' => '180.00',
                'prixFournisseur' => '140.00',
                'stock' => 22,
                'active' => true,
                'sousCategorie' => 'souscat-plugins-effets',
                'fournisseur' => 'fournisseur-kirstein',
            ],

            // Enceintes

            [
                'libelleCourt' => 'Yamaha HS8 Studio Monitor',
                'libelleLong' => 'Enceinte de monitoring active 8 pouces, fidèle et précise, parfaite pour le mixage en studio.',
                'image' => 'image/produit/Yamaha_HS8.jpg',
                'prixHt' => '350.00',
                'prixFournisseur' => '300.00',
                'stock' => 10,
                'active' => true,
                'sousCategorie' => 'souscat-enceintes',
                'fournisseur' => 'fournisseur-woodbrass',
            ],
            [
                'libelleCourt' => 'KRK Rokit 5 G4',
                'libelleLong' => 'Enceinte de monitoring 5 pouces avec son clair et puissant, idéale pour home studio et production musicale.',
                'image' => 'image/produit/KRK_Rokit_5_G4.jpg',
                'prixHt' => '250.00',
                'prixFournisseur' => '210.00',
                'stock' => 14,
                'active' => true,
                'sousCategorie' => 'souscat-enceintes',
                'fournisseur' => 'fournisseur-thomann',
            ],

            // Accessoires Sonorisation

            [
                'libelleCourt' => 'Pied de Microphone Réglable',
                'libelleLong' => 'Pied robuste et réglable pour microphone, avec bras orientable, idéal pour studio ou scène.',
                'image' => 'image/produit/Pied_Microphone.jpg',
                'prixHt' => '40.00',
                'prixFournisseur' => '30.00',
                'stock' => 30,
                'active' => true,
                'sousCategorie' => 'souscat-accessoires-sonorisation',
                'fournisseur' => 'fournisseur-starsmusic',
            ],
            [
                'libelleCourt' => 'Multiprise Audio 4 Ports',
                'libelleLong' => 'Multiprise de qualité avec 4 ports pour brancher plusieurs équipements audio simultanément.',
                'image' => 'image/produit/Multiprise_Audio_4_Ports.jpg',
                'prixHt' => '35.00',
                'prixFournisseur' => '28.00',
                'stock' => 25,
                'active' => true,
                'sousCategorie' => 'souscat-accessoires-sonorisation',
                'fournisseur' => 'fournisseur-baxmusic',
            ],

        ];


        foreach ($produitsData as $data) {
            $produit = new Produit();
            $produit->setLibelleCourt($data['libelleCourt']);
            $produit->setLibelleLong($data['libelleLong']);
            $produit->setImage($data['image']);
            $produit->setPrixHt($data['prixHt']);
            $produit->setPrixFournisseur($data['prixFournisseur']);
            $produit->setStock($data['stock']);
            $produit->setActive($data['active']);

            $produit->setSousCategorie($this->getReference($data['sousCategorie'], SousCategorie::class));
            $produit->setFournisseur($this->getReference($data['fournisseur'], Fournisseur::class));

            $manager->persist($produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SousCategorieFixture::class,
            FournisseurFixture::class,
        ];
    }
}