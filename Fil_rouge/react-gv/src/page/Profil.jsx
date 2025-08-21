import { useState } from "react";
import { jwtDecode } from "jwt-decode";
import axios from "axios";

function Profil() {
  const server = "https://127.0.0.1:8000/";
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  if (!localStorage.getItem("token")) {
    console.log("pas token");
  } else {
    const decoded = jwtDecode(localStorage.getItem("token"));
    console.log(decoded);

    axios
      .get(server + "api/utilisateurs/" + decoded.id, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then((res) => {
        console.log("Données utilisateur :", res.data);
      })
      .catch((err) => {
        if (err.response?.status === 401) {
          console.error("Token invalide ou expiré");
          localStorage.removeItem("token");
        } else {
          console.error(err.response?.data || err.message);
        }
      });
  }

  const SeConnecer = (e) => {
    e.preventDefault();

    console.log(email, password);

    axios
      .post(
        server + "api/login_check",
        {
          email: email,
          password: password,
        },
        {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        }
      )
      .then((response) => {
        console.log("Réponse :", response.data);
        localStorage.setItem("token", response.data.token);
      })
      .catch((error) => {
        console.error("Erreur :", error.response?.data || error.message);
      });
  };

  return (
    <>
      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">Connection</h1>
      </div>

      <form className="flex flex-col items-center mt-15 gap-5" action="">
        <div className="max-w-sm">
          <label
            htmlFor="email"
            className="block text-sm font-medium text-gray-700 mb-2"
          >
            Adresse e-mail
          </label>
          <input
            type="email"
            name="email"
            id="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full px-4 py-3 bg-white border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
            placeholder="votre@email.com"
          />
        </div>

        <div className="max-w-sm">
          <label
            htmlFor="password"
            className="block text-sm font-medium text-gray-700 mb-2"
          >
            Mot de passe
          </label>
          <input
            type="password"
            name="password"
            id="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="w-full px-4 py-3 bg-white border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
            placeholder="Votre mot de passe"
          />
        </div>
        <button
          onClick={SeConnecer}
          type="submit"
          className="w-auto mt-4 px-4 py-3 bg-green-600 text-white font-medium rounded-2xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors cursor-pointer"
        >
          Se connecter
        </button>
      </form>

      {/* --------- */}

      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">Profil</h1>
      </div>

      <section className="mt-15 flex flex-col items-center">
        <h1 className="text-center text-xl">Informations personelles</h1>
        <div className="mt-5">
          <p>Nom : </p>
          <p>Prénom : </p>
          <p>Email : </p>
        </div>

        <button
          type="submit"
          className="w-auto mt-4 px-4 py-3 bg-red-600 text-white font-medium rounded-2xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors cursor-pointer
"
        >
          Se déconnecter
        </button>
      </section>
      {/* --------- */}
    </>
  );
}

export default Profil;
