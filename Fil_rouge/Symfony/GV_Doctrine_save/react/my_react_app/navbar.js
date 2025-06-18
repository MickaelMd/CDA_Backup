import React from "react";
import ReactDOM from "react-dom/client";
import Navbar from "./jsx/Navbar.jsx";

const ell = document.getElementById("navbar-react");

if (ell) {
  const panier = ell.dataset.panier ?? null;

  ReactDOM.createRoot(ell).render(
    <React.StrictMode>
      <Navbar panier={panier} />
    </React.StrictMode>
  );
}
