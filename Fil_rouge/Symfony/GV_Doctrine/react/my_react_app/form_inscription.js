import React from "react";
import ReactDOM from "react-dom/client";
import FormInscription from "./jsx/FormInscription.jsx";

const ell = document.getElementById("form-inscription-react");

if (ell) {
  const token_csrf = ell.dataset.csrfToken ?? null;

  ReactDOM.createRoot(ell).render(
    <React.StrictMode>
      <FormInscription token_csrf={token_csrf} />
    </React.StrictMode>
  );
}
