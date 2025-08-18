import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";
import Categories from "./Categories";

function Produit() {
  const { id } = useParams();
  const server = "https://gv.mickaelmd.fr/";

  const [produit, setProduit] = useState([]);

  useEffect(() => {
    axios
      .get(server + "api/produits/" + id)
      .then((response) => {
        setProduit(response.data);
      })
      .catch((error) => {
        console.error(error);
      });
  }, [id, server]);

  return (
    <>
      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">
          Produit : {produit.libelleCourt}
        </h1>
      </div>

      <section className="bg-white flex flex-col mt-15 items-center">
        <h1>{produit.libelleCourt}</h1>

        <div className="h-[200px] w-[200px] overflow-hidden">
          <img
            className="w-full h-full object-cover"
            src={server + produit.image}
            alt={produit.libelleCourt}
          />
        </div>
        <p>{produit.libelleLong}</p>
        <a href="/">{produit.sousCategorie?.Categorie?.nom}</a>
        <p>{produit.prix}</p>
        <button>Acheter le produit</button>
      </section>
    </>
  );
}

export default Produit;
