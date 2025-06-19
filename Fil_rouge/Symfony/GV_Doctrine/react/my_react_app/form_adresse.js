import React from "react";
import ReactDOM from "react-dom/client";
import FormAdresse from "./jsx/FormAdresse.jsx";

const el = document.getElementById("form-adresse-react");

if (el) {
  const adresseLivraison = el.dataset.adresselivraison;

  ReactDOM.createRoot(el).render(
    <React.StrictMode>
      <FormAdresse adresseLivraison={adresseLivraison} />
    </React.StrictMode>
  );
}
