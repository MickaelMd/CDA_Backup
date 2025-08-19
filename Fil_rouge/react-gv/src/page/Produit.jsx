import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";

function Produit() {
  const { id } = useParams();
  const server = "https://127.0.0.1:8000/";

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

  if (produit.libelleCourt == null) {
    return (
      <>
        <h1 className="text-red-600 text-3xl text-center mt-15">
          Produit introuvable !
        </h1>
      </>
    );
  }

  return (
    <>
      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">
          Produit : {produit.libelleCourt}
        </h1>
      </div>

      <section className="bg-white flex flex-col mt-15 items-center">
        <h1 className="text-xl m-5">{produit.libelleCourt}</h1>
        <a
          className="text-gray-500"
          href={"/categorie/" + produit.sousCategorie?.Categorie?.id}
        >
          {produit.sousCategorie?.Categorie?.nom}
        </a>

        <div className="m-5 h-[200px] w-[200px] overflow-hidden">
          <img
            className="w-full h-full object-cover"
            src={server + produit.image}
            alt={produit.libelleCourt}
          />
        </div>
        <p className="px-10 max-w-5xl">{produit.libelleLong}</p>

        <p>{produit.prix}</p>
        <button className="mt-5 text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-1.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
          Acheter le produit
        </button>
      </section>
    </>
  );
}

export default Produit;
