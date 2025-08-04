import { useState, useEffect } from "react";
import axios from "axios";
import Card from "./Card.jsx";

function App() {
  const [movies, setMovies] = useState([]);
  const [value, setValue] = useState("John Wick");

  useEffect(() => {
    axios
      .get("https://api.themoviedb.org/3/search/movie", {
        params: {
          api_key: "f33cd318f5135dba306176c13104506a",
          query: value,
          language: "fr-FR",
          page: 1,
        },
      })
      .then((response) => {
        const result = response.data.results.slice(0, 10);
        setMovies(result);
        // console.log(result);
      })
      .catch((error) => {
        console.error("Erreur API TMDb :", error);
      });
  }, [value]);

  const handleChange = (e) => {
    setValue(e.target.value);
  };

  return (
    <>
      <div className="flex items-center justify-center mt-[30px]">
        <input
          type="text"
          name="recherche"
          id="input_recherche"
          value={value}
          onChange={handleChange}
          className="bg-white border rounded-2xl w-60 h-8 px-3"
        />
      </div>
      <section className="mt-10 flex flex-col items-center gap-4 justify-center px-4">
        {movies.length === 0 ? (
          <p className="text-gray-500">
            Aucun film trouvé pour votre recherche.
          </p>
        ) : (
          movies.map((movie) => (
            <Card
              key={movie.id}
              title={movie.title}
              image={
                movie.poster_path
                  ? "http://image.tmdb.org/t/p/w185" + movie.poster_path
                  : "https://placehold.co/600x400"
              }
              desc={movie.overview || "Pas de résumé disponible."}
              date={movie.release_date || "Pas encore de date de sortie"}
            />
          ))
        )}
      </section>
    </>
  );
}

export default App;
