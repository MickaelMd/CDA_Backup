import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";
import ProduitCard from "../components/CardProduit";

function CategorieProduit() {
  const { id } = useParams();
  const server = import.meta.env.VITE_SERVER_IP;

  const [produits, setProduits] = useState([]);

  useEffect(() => {
    axios
      .get(server + "api/produits?page=1&itemsPerPage=200")
      .then((response) => {
        const produitsFiltres = response.data.filter(
          (produit) => String(produit.sousCategorie.Categorie.id) === id
        );
        setProduits(produitsFiltres);
      })
      .catch((error) => {
        console.error(error);
      });
  }, [id, server]);

  return (
    <div>
      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">
          Produits de la catégorie :{" "}
          {produits.length > 0 ? produits[0].sousCategorie.Categorie.nom : ""}
        </h1>
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
          <p>Aucun produit trouvé dans cette catégorie.</p>
        )}
      </section>
    </div>
  );
}

export default CategorieProduit;
