import { useState, useEffect } from "react";
import axios from "axios";
import CategorieCard from "../components/CardCategorie";

function Categories() {
  const server = "https://127.0.0.1:8000/";

  const [categories, setCategories] = useState([]);

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

  return (
    <div>
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
    </div>
  );
}

export default Categories;
