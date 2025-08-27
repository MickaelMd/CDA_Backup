import { useState, useEffect } from "react";
import { jwtDecode } from "jwt-decode";
import axios from "axios";

function Profil() {
  const server = import.meta.env.VITE_SERVER_IP;
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      setLoading(false);
      return;
    }

    try {
      const decoded = jwtDecode(token);
      axios
        .get(server + "api/utilisateurs/" + decoded.id, {
          headers: { Authorization: `Bearer ${token}` },
        })
        .then((res) => {
          setUser(res.data);
        })
        .catch((err) => {
          if (err.response?.status === 401) {
            console.error("Token invalide ou expiré");
            localStorage.removeItem("token");
          }
        })
        .finally(() => setLoading(false));
    } catch (e) {
      console.error("Erreur décodage token", e);
      setLoading(false);
    }
  }, [server]);

  const SeConnecter = (e) => {
    e.preventDefault();

    axios
      .post(
        server + "api/login_check",
        { email, password },
        {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        }
      )
      .then((response) => {
        localStorage.setItem("token", response.data.token);
        window.location.reload();
      })
      .catch((error) => {
        console.error("Erreur :", error.response?.data || error.message);
      });
  };

  const SeDeconnecter = () => {
    localStorage.removeItem("token");
    setUser(null);
  };

  if (loading) return <p className="text-center mt-25">Chargement...</p>;

  if (user) {
    return (
      <>
        <div className="flex justify-center mt-15 p-6 bg-white">
          <h1 className="text-2xl text-center">Profil</h1>
        </div>

        <section className="mt-15 flex flex-col items-center">
          <h1 className="text-center text-xl">Informations personnelles</h1>
          <div className="mt-5">
            <p>Nom : {user.nom}</p>
            <p>Prénom : {user.prenom}</p>
            <p>Email : {user.email}</p>
          </div>

          <button
            onClick={SeDeconnecter}
            className="w-auto mt-4 px-4 py-3 bg-red-600 text-white font-medium rounded-2xl hover:bg-red-700 transition-colors cursor-pointer"
          >
            Se déconnecter
          </button>
        </section>
      </>
    );
  }

  return (
    <>
      <div className="flex justify-center mt-15 p-6 bg-white">
        <h1 className="text-2xl text-center">Connexion</h1>
      </div>

      <form
        className="flex flex-col items-center mt-15 gap-5"
        onSubmit={SeConnecter}
      >
        <div className="max-w-sm">
          <label
            htmlFor="email"
            className="block text-sm font-medium text-gray-700 mb-2"
          >
            Adresse e-mail
          </label>
          <input
            type="email"
            id="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-green-500"
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
            id="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-green-500"
            placeholder="Votre mot de passe"
          />
        </div>

        <button
          type="submit"
          className="w-auto mt-4 px-4 py-3 bg-green-600 text-white font-medium rounded-2xl hover:bg-green-700 transition-colors cursor-pointer"
        >
          Se connecter
        </button>
      </form>
    </>
  );
}

export default Profil;
