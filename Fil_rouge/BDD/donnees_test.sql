USE green_village;

INSERT INTO `commercial` (`nom`,`prenom`,`email`,`pass_commercial`,`telephone`)
VALUES
  ("Slade","Gallegos","lacus@google.net","YDS82WNO3JH","03 21 97 78 28"),
  ("May","Humphrey","libero.et@yahoo.net","PWT33ZHB5BS","02 92 57 33 27"),
  ("Uriah","Cross","sed@icloud.ca","KLJ75XDR1FV","06 67 68 12 54"),
  ("Idola","Mcmillan","hendrerit.consectetuer@aol.ca","DHK01UQM0XT","08 06 36 41 64"),
  ("Rogan","Matthews","quis.urna@outlook.net","YVT22JHE4IW","07 08 33 68 25");

  INSERT INTO `client` (`ref_client`,`nom`,`prenom`,`telephone`,`email`,`pass_client`,`type_client`,`coefficient`,`adresse_livraison`,`adresse_facturation`,`id_commercial`)
VALUES
 ("X1E 1W5","Max","Dumont","05 31 54 36 92","non.vestibulum@aol.couk","VEQ49HFF1LW","1",36,"574-7795 Feugiat. Ave","142-6725 Purus Ave",4),
  ("L4W 7Z1","Louise","Lachapelle","03 56 03 37 23","in.hendrerit@aol.edu","IUG33HBG6ZX","1",4,"977-2015 Aenean Street","8423 Porttitor Ave",2),
  ("F2E 3C9","Pauline","Brisbois","02 25 77 18 26","volutpat.ornare@protonmail.org","VVN81YLP2EX","0",39,"Ap #677-495 Dis Rd.","7109 Parturient Av.",5),
  ("K1J 9B5","Mégane","Victor","08 43 21 87 71","tincidunt.vehicula@yahoo.net","YSR38JWS2XH","1",33,"P.O. Box 968, 3684 Pede Ave","416-6028 Tempor Ave",2),
  ("X6Y 6N4","Glenn","Plamondon","02 67 13 46 68","dapibus@icloud.edu","DLN43WYT9YR","1",11,"P.O. Box 696, 7739 Tempus, Rd.","508-8238 Tortor Av.",2),
  ("T3V 8F3","Clémentine","Borde","07 61 31 42 82","morbi@outlook.couk","QIN36STO3AM","0",16,"942-1792 Adipiscing St.","Ap #624-4752 Tortor. Avenue",3),
  ("O3G 6N7","Alison","Vincent","04 63 85 76 54","facilisis.vitae@icloud.net","WCJ67TGV5BX","0",49,"Ap #232-733 Proin Road","1498 Vivamus Avenue",2),
  ("C6N 8V2","Adrien","Vincent","06 38 65 39 56","elit.dictum@outlook.org","YCR59GPJ1NL","1",40,"831-5034 Ipsum Ave","586-3968 Ipsum. Rd.",1),
  ("J5U 8G7","Ben","Peerenboom","02 36 59 71 88","orci.lobortis@icloud.org","LVO54XDC1EW","1",36,"329-6249 Metus. Avenue","286-1970 Egestas Rd.",4),
  ("M5R 1T2","Mélanie","Van Alphen","05 35 63 76 24","sed.eu.eros@hotmail.edu","BDC24WWO2SU","0",36,"504-1946 Magna. Ave","248-9843 Consectetuer Avenue",2),
  ("U1L 8X7","Stéphane","Haak","03 76 60 54 45","pellentesque.massa@protonmail.edu","BIW85WSR5LM","0",49,"148 Nam Rd.","495-8844 Diam St.",5),
  ("E8L 6D7","Ali","Jonker","04 43 36 41 82","magnis.dis@outlook.edu","PHF59EAQ6IN","0",10,"Ap #901-3058 Nunc, Rd.","691-3892 Nisl St.",2),
  ("J5Q 5Q4","Emile","Baardwijk","05 84 60 71 21","erat.in@icloud.ca","UUY38CGG4HV","0",33,"P.O. Box 936, 4826 Est Ave","P.O. Box 124, 652 Aliquam, Road",2),
  ("J4L 8L6","Jean","Peeters","06 75 28 65 01","ornare.in@hotmail.org","TWN66JYV5AS","1",9,"678-3549 Vivamus Rd.","969-8424 Mauris St.",3),
  ("E6U 8Q3","Mélanie","Cloutier","05 48 28 41 87","sodales@aol.net","KBB23YSC6LD","0",19,"Ap #661-3173 Facilisis Rd.","8728 Dolor St.",4);

  INSERT INTO `fournisseur` (`nom`,`email`,`telephone`,`adresse`,`id_commercial`)
VALUES
  ("Duis LLP","rhoncus.donec@outlook.edu","03 42 12 53 88","P.O. Box 238, 3921 Sed St.",5),
  ("Quam Curabitur Vel PC","faucibus.leo@protonmail.net","06 72 05 22 58","984-5251 Arcu. Rd.",2),
  ("Magnis Dis Corp.","eget.lacus@hotmail.org","07 64 32 82 18","Ap #470-9080 Et Road",5),
  ("Erat Neque Foundation","nulla@google.net","07 22 56 47 62","8486 Fringilla. Street",3),
  ("Aliquam Fringilla Inc.","vulputate@protonmail.net","03 17 54 56 25","P.O. Box 185, 1734 Cras Ave",4);

  INSERT INTO `categorie` (`nom`, `image_cat`, `active_cat`)
  VALUES
  ("Guitare","/image/categorie/","1"),
  ("Bass","/image/categorie/","0"),
  ("Batteries","/image/categorie/","1"),
  ("Clavier","/image/categorie/","1"),
  ("Studio","/image/categorie/","1");

  INSERT INTO `sous_categorie` (`nom`, `image_sous_cat`, `active_sous_cat`, `id_categorie`)
  VALUES
  ("Guitare Electriques","/image/sous_categorie/","1",1),
  ("Guitare Acoustiques","/image/sous_categorie/","0",1),
  ("Basses Electriques","/image/sous_categorie/","1",2),
  ("Basses Acoustiques","/image/sous_categorie/","1",2),
  ("Batteries Acoustiques","/image/sous_categorie/","1",3),
  ("Batteries Electriques","/image/sous_categorie/","1",3),
  ("Pianos Numériques","/image/sous_categorie/","0",4),
  ("Pianos Droits","/image/sous_categorie/","0",4),
  ("Interfaces AUdio","/image/sous_categorie/","1",5),
  ("Microphones","/image/sous_categorie/","0",5);

  INSERT INTO `produit` (`libelle_court`, `libelle_long`, `image_produit`, `prix_ht`, `prix_fournisseur`, `stock`, `active_produit`, `id_fournisseur`, `id_sous_categorie`)
VALUES
  ("Stratocaster", "Guitare électrique type Stratocaster avec micros simple bobinage", "/image/produit/stratocaster.jpg", 699.99, 450.00, 15, 1, 1, 1),
  ("Folk Yamaha", "Guitare acoustique Yamaha idéale pour débutants et intermédiaires", "/image/produit/folk.jpg", 299.90, 180.00, 25, 1, 2, 2),
  ("Jazz Bass", "Basse électrique avec micros passifs et manche érable", "/image/produit/jazzbass.jpg", 749.00, 500.00, 10, 1, 3, 3),
  ("Basse Acoustique Ibanez", "Basse acoustique Ibanez à caisse jumbo", "/image/produit/basse_acoustique.jpg", 349.99, 220.00, 8, 1, 4, 4),
  ("Yamaha Stage Custom", "Batterie acoustique complète 5 fûts + cymbales", "/image/produit/stage_custom.jpg", 899.00, 600.00, 5, 1, 5, 5),
  ("Alesis Nitro Mesh", "Batterie électronique compacte avec pads maillés", "/image/produit/nitro_mesh.jpg", 399.00, 250.00, 12, 1, 1, 6),
  ("Yamaha P-125", "Piano numérique 88 touches lestées avec sons réalistes", "/image/produit/p125.jpg", 599.00, 400.00, 9, 1, 2, 7),
  ("Upright Kawai", "Piano droit Kawai avec mécanique précise", "/image/produit/upright.jpg", 2999.00, 2000.00, 2, 1, 3, 8),
  ("Focusrite Scarlett 2i2", "Interface audio USB 2 entrées/2 sorties très populaire", "/image/produit/scarlett_2i2.jpg", 159.00, 100.00, 20, 1, 4, 9),
  ("Shure SM58", "Microphone dynamique cardioïde idéal pour la voix", "/image/produit/sm58.jpg", 109.00, 70.00, 30, 1, 5, 10);


INSERT INTO `commande` (`ref_commande`, `mode_paiement`, `statut`, `tva`, `reduction`, `total`, `total_ht`, `ref_facture`, `ref_client`)
VALUES
  ("CMD001", "Carte bancaire", "Payée", 20, 0.00, 839.99, 699.99, "FACT001", "X1E 1W5"),
  ("CMD002", "PayPal", "En attente", 20, 10.00, 839.90, 699.90, "FACT002", "L4W 7Z1"),
  ("CMD003", "Virement", "Payée", 20, 0.00, 898.80, 749.00, "FACT003", "F2E 3C9"),
  ("CMD004", "Virement", "En attente", 20, 10.00, 6932.00, 5785.00, "FACT004", "O3G 6N7"),
  ("CMD005", "Carte bancaire", "En attente", 20, 5.00, 290.20, 246.00, "FACT005", "M5R 1T2"),
  ("CMD006", "PayPal", "En attente", 20, 0.00, 2426.40, 2022.00, "FACT006", "T3V 8F3"),
  ("CMD007", "PayPal", "En attente", 20, 5.00, 2536.60, 2118.00, "FACT007", "X6Y 6N4"),
  ("CMD008", "Virement", "En attente", 20, 10.00, 5703.20, 4761.00, "FACT008", "K1J 9B5"),
  ("CMD009", "PayPal", "En attente", 20, 10.00, 2902.40, 2427.00, "FACT009", "X1E 1W5"),
  ("CMD010", "Virement", "Préparée", 20, 10.00, 2780.00, 2325.00, "FACT010", "K1J 9B5"),
  ("CMD011", "Virement", "En attente", 20, 0.00, 3963.60, 3303.00, "FACT011", "C6N 8V2"),
  ("CMD012", "PayPal", "Payée", 20, 10.00, 114.80, 104.00, "FACT012", "M5R 1T2"),
  ("CMD013", "PayPal", "Payée", 20, 0.00, 3151.20, 2626.00, "FACT013", "X1E 1W5");

INSERT INTO `detail_commande` (`quantite`, `prix`, `id_produit`, `ref_commande`)
VALUES
  (1, 699.99, 1, "CMD001"),
  (1, 299.90, 2, "CMD002"),
  (1, 749.00, 3, "CMD003"),
  (3, 839, 2, "CMD004"),
  (2, 959, 10, "CMD004"),
  (3, 450, 6, "CMD004"),
  (2, 123, 7, "CMD005"),
  (3, 674, 3, "CMD006"),
  (1, 538, 10, "CMD007"),
  (1, 827, 8, "CMD007"),
  (1, 753, 6, "CMD007"),
  (3, 846, 6, "CMD008"),
  (3, 741, 7, "CMD008"),
  (3, 159, 2, "CMD009"),
  (2, 975, 8, "CMD009"),
  (3, 775, 6, "CMD010"),
  (3, 499, 10, "CMD011"),
  (3, 602, 9, "CMD011"),
  (1, 104, 2, "CMD012"),
  (1, 526, 9, "CMD013"),
  (2, 601, 4, "CMD013"),
  (1, 898, 10, "CMD013");
  

INSERT INTO `livraison` (`etat`, `date_livraison`, `ref_commande`)
VALUES
  ("Livrée", '2025-01-15', "CMD001"),
  ("En cours", '2025-04-25', "CMD002"),
  ("Préparée", '2025-04-28', "CMD003"),
  ("Préparée", '2025-04-28', "CMD004"),
  ("En cours", '2025-04-26', "CMD005"),
  ("Préparée", '2025-04-29', "CMD006"),
  ("Livrée", '2025-02-20', "CMD007"),
  ("Préparée", '2025-04-29', "CMD008"),
  ("Livrée", '2025-03-10', "CMD009"),
  ("Préparée", '2025-04-27', "CMD010"),
  ("Livrée", '2025-03-28', "CMD011"),
  ("Payée", '2025-04-15', "CMD012"),
  ("Payée", '2025-04-16', "CMD013");

INSERT INTO `achemine` (`id_produit`, `id_livraison`, `quantite_livree`)
VALUES
  (1, 1, 1),
  (2, 2, 1),
  (3, 3, 1),
  (6, 4, 2),
  (4, 4, 1),
  (9, 4, 2),
  (2, 5, 1),
  (7, 5, 2),
  (6, 5, 2),
  (10, 6, 2),
  (2, 7, 1),
  (10, 7, 2),
  (2, 8, 1),
  (2, 9, 2),
  (6, 9, 1),
  (1, 9, 2),
  (7, 10, 2),
  (6, 11, 2),
  (7, 11, 1),
  (5, 12, 1),
  (6, 13, 1);
