import { useState, useEffect } from "react";
import "./footer.css";

const Footer = () => {
  return (
    <>
      <footer className="color-fond">
        <img src="/image/logo/interface/arrow_up.svg" alt="Logo intéractif" />
        <div className="">
          <h1 className="color-logo-text font-title">Green Village</h1>
          <p>Green village magasin de musique</p>
          <p>10 Rue de la république, 80100 Amiens</p>
          <p>contact@greenvillage.com</p>
          <p>0322032210</p>
        </div>

        <div>
          <h3 className="font-title">Navigation</h3>
          <ul>
            <li>
              <a href="#">Acceuil</a>
            </li>
            <li>
              <a href="#">Catégories</a>
            </li>
            <li>
              <a href="#">Panier</a>
            </li>
            <li>
              <a href="#">Connexion</a>
            </li>
          </ul>
        </div>

        <div>
          <h3 className="font-title">Légal</h3>
          <ul>
            <li>
              <a href="#">Politique de confidentialité</a>
            </li>
            <li>
              <a href="#">Mentions légales</a>
            </li>
            <li>
              <a href="#">À propos</a>
            </li>
          </ul>

          <div className="section-paiement">
            <div>
              <img
                src="/image/logo/paiement/visa.svg"
                alt="Logo de paiement Visa"
              />
              <img
                src="/image/logo/paiement/cb.svg"
                alt="Logo de paiement carte bancaire"
              />
            </div>
            <div>
              <img
                src="/image/logo/paiement/paypal.svg"
                alt="Logo de paiement paypal"
              />
              <img
                src="/image/logo/paiement/mastercard.svg"
                alt="Logo de paiement mastercard"
              />
            </div>
          </div>

          <div className="section-reseau">
            <a href="">
              <img
                src="/image/logo/reseau/facebook.svg"
                alt="Logo du reseau social facebook"
              />
            </a>
            <a href="">
              <img
                src="/image/logo/reseau/youtube.svg"
                alt="Logo du reseau social youtube"
              />
            </a>
            <a href="">
              <img
                src="/image/logo/reseau/instagram.svg"
                alt="Logo du reseau social instagram"
              />
            </a>
            <a href="">
              <img
                src="/image/logo/reseau/tiktok.svg"
                alt="Logo du reseau social tiktok"
              />
            </a>
            <a href="">
              <img
                src="/image/logo/reseau/x.svg"
                alt="Logo du reseau social X"
              />
            </a>
          </div>
        </div>

        <hr
          style={{
            marginTop: "20px",
            maxWidth: "60%",
            height: "1px",
            border: "none",
            backgroundColor: "rgba(255, 255, 255, 0.445)",
            margin: "10px auto",
          }}
        />
        <p
          style={{
            textAlign: "center",
            color: "grey",
            fontStyle: "italic",
          }}
        >
          © 2025 Green Village. Tous droits réservés.
        </p>
      </footer>
    </>
  );
};

export default Footer;
