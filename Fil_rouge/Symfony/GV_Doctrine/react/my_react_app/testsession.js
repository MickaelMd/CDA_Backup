import React from "react";
import ReactDOM from "react-dom/client";
import Testsession from "./jsx/Testsession.jsx";

const el = document.getElementById("testsession-react");

if (el) {
  const userId = el.dataset.userId ?? null;
  const userEmail = el.dataset.userEmail ?? null;
  const monTruc = el.dataset.test ?? null;

  ReactDOM.createRoot(el).render(
    <React.StrictMode>
      <Testsession userId={userId} userEmail={userEmail} monTruc={monTruc} />
    </React.StrictMode>
  );
}
