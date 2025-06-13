import "./footer.css";

const Footer = () => {
  const handleClickLogo = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  return (
    <>
      <footer className="color-fond">
        <div className="footer-content">
          <img
            id="nav-logo-up"
            className="color-fond"
            src="/image/logo/interface/arrow_up.svg"
            alt="Logo intéractif"
            onClick={handleClickLogo}
          />

          <div className="footer-info">
            <h1 className="color-logo-text font-title">Green Village</h1>
            <p>Green village magasin de musique</p>
            <p>30 Rue de Poulainville, 80000 Amiens</p>
            <a href="mailto:contact@greenvillage.com">
              contact@greenvillage.com
            </a>
            <p>0303030303</p>
          </div>

          <div className="footer-nav">
            <h3 className="font-title">Navigation</h3>
            <ul>
              <li>
                <a href="/">Acceuil</a>
              </li>
              <li>
                <a href="/categorie">Catégories</a>
              </li>
              <li>
                <a href="/panier">Panier</a>
              </li>
              <li>
                <a href="/connexion">Connexion</a>
              </li>
            </ul>
          </div>

          <div className="footer-legal">
            <h3 className="font-title">Légal</h3>
            <ul>
              <li>
                <a href="/politiquedeconfidentialite">
                  Politique de confidentialité
                </a>
              </li>
              <li>
                <a href="/mentionslegales">Mentions légales</a>
              </li>
              <li>
                <a href="/apropos">À propos</a>
              </li>
            </ul>
          </div>
          <div className="footer-paiement-reseau">
            <div className="footer-paiement">
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

            <div className="footer-reseau">
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
