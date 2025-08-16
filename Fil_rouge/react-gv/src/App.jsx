// App.jsx
import { Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import Accueil from "./page/Accueil";
import Categories from "./page/Categories";

export default function App() {
  return (
    <>
      <Navbar />
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/categories" element={<Categories />} />
      </Routes>
    </>
  );
}
