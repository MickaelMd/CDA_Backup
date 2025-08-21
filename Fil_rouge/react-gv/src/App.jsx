// App.jsx
import { Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Accueil from "./page/Accueil";
import Categories from "./page/Categories";
import CategorieProduit from "./page/CategorieProduit";
import Produit from "./page/Produit";
import Page404 from "./page/404";
import Profil from "./page/Profil";

export default function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/categories" element={<Categories />} />
        <Route path="/categorie/:id" element={<CategorieProduit />} />
        <Route path="/produit/:id" element={<Produit />} />
        <Route path="/profil" element={<Profil />} />
        <Route path="*" element={<Page404 />} />
      </Routes>
    </>
  );
}
