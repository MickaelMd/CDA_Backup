import React from "react";
import ReactDOM from "react-dom/client";
import Footer from "./jsx/Footer.jsx";

const el = document.getElementById("footer-react");

if (el) {
  const userId = el.dataset.userId ?? null;

  ReactDOM.createRoot(el).render(
    <React.StrictMode>
      <Footer userId={userId} />
    </React.StrictMode>
  );
}
