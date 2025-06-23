import React from "react";
import ReactDOM from "react-dom/client";
import FormAdresse from "./jsx/FormAdresse.jsx";

const elements = document.querySelectorAll('[id^="form-adresse-"]');

elements.forEach((el) => {
  const adresseLivraison = el.dataset.adresselivraison;
  const titre = el.dataset.titre;

  ReactDOM.createRoot(el).render(
    <React.StrictMode>
      <FormAdresse adresseLivraison={adresseLivraison} titre={titre} />
    </React.StrictMode>
  );
});
