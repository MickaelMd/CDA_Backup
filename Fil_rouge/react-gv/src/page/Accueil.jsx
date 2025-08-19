import { useState, useEffect } from "react";
import axios from "axios";
import CategorieCard from "../components/CardCategorie";
import ProduitCard from "../components/CardProduit";

function Accueil() {
  const server = "https://127.0.0.1:8000/";

  const [categories, setCategories] = useState([]);
  const [produits, setProduit] = useState([]);

  useEffect(() => {
    axios
      .get(server + "api/categories")
      .then((response) => {
        setCategories(response.data);
      })
      .catch((error) => {
        console.error(error);
      });
  }, []);

  useEffect(() => {
    axios
      .get(server + "api/produits")
      .then((response) => {
        setProduit(response.data.slice(0, 5));
      })
      .catch((error) => {
        console.error(error);
      });
  }, []);

  return (
    <>
      <header className="mt-15 bg-white flex flex-col justify-center items-center text-center py-20 px-4">
        <div>
          <h2 className="m-0 text-4xl text-green-600">Bienvenue chez,</h2>
          <h1 className="m-0 text-6xl text-green-600">Green Village</h1>
        </div>
      </header>

      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">Nos Catégories</h1>
      </div>

      <section className="flex mt-15 mx-10 justify-center flex-wrap gap-4">
        {categories.length > 0 ? (
          categories.map((categorie) => (
            <CategorieCard
              key={categorie.id}
              nomCategorie={categorie.nom}
              lienImg={server + categorie.image}
              categorieId={categorie.id}
            />
          ))
        ) : (
          <h1>Erreur de chargement</h1>
        )}
      </section>

      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">Nos produits populaires</h1>
      </div>

      <section className="flex mt-15 mx-10 justify-center flex-wrap gap-4 mb-30">
        {produits.length > 0 ? (
          produits.map((produit) => (
            <ProduitCard
              key={produit.id}
              produitId={produit.id}
              nomProduit={produit.libelleCourt}
              lienImg={server + produit.image}
              nomCategorie={produit.sousCategorie.Categorie.nom}
              lienCategorie={produit.sousCategorie.Categorie.id}
              prix={produit.prixHt}
            />
          ))
        ) : (
          <h1>Erreur de chargement</h1>
        )}
      </section>
    </>
  );
}

export default Accueil;
