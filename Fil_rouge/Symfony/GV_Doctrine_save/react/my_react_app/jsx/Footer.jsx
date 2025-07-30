const Footer = ({ userId }) => {
  const handleClickLogo = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  const isActive = (path) => window.location.pathname === path;

  return (
    <footer className="color-fond mt-[50px] pb-[10px] text-white py-[30px] px-0 relative">
      <div className="footer-content flex flex-col items-center text-center gap-[30px] px-[10px] md:flex-wrap md:max-w-[1400px] md:mx-auto md:justify-around md:flex-row">
        <img
          id="nav-logo-up"
          className="color-fond absolute top-[-20px] left-1/2 transform -translate-x-1/2 w-[40px] h-[40px] rounded-full p-[6px] cursor-pointer transition-transform duration-200 ease-in-out hover:-translate-y-[5px]
             md:top-[-30px] md:right-[30px] md:left-auto md:translate-x-0 md:w-[40px] md:h-[40px] md:p-[8px] md:hover:-translate-y-[5px]"
          src="/image/logo/interface/arrow_up.svg"
          alt="Logo intéractif"
          onClick={handleClickLogo}
        />

        <div className="footer-info">
          <h1 className="color-logo-text font-title">Green Village</h1>
          <p className="my-[3px]">Green village magasin de musique</p>
          <p className="my-[3px]">30 Rue de Poulainville, 80000 Amiens</p>
          <a
            href="mailto:contact@greenvillage.com"
            className="text-white hover:text-[#369354] transition-colors duration-200"
          >
            contact@greenvillage.com
          </a>
          <p className="my-[3px]">0303030303</p>
        </div>

        <div className="footer-nav flex flex-col">
          <h3 className="font-title mb-[10px]">Navigation</h3>
          <ul className="flex flex-row flex-wrap justify-center gap-[10px] md:flex-col">
            <li>
              <a
                href="/"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/") ? "active-link font-bold underline" : ""
                }`}
              >
                Accueil
              </a>
            </li>
            <li>
              <a
                href="/categorie"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/categorie")
                    ? "active-link font-bold underline"
                    : ""
                }`}
              >
                Catégories
              </a>
            </li>
            <li>
              <a
                href="/panier"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/panier") ? "active-link font-bold underline" : ""
                }`}
              >
                Panier
              </a>
            </li>
            <li>
              <a
                href="/profil"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/profil") ? "active-link font-bold underline" : ""
                }`}
              >
                Profil
              </a>
            </li>
            <li>
              <a
                href={userId ? "/deconnexion" : "/connexion"}
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive(userId ? "/deconnexion" : "/connexion")
                    ? "active-link font-bold underline"
                    : ""
                }`}
              >
                {userId ? "Déconnexion" : "Connexion"}
              </a>
            </li>
          </ul>
        </div>

        <div className="footer-legal flex flex-col">
          <h3 className="font-title mb-[10px]">Légal</h3>
          <ul className="flex flex-row flex-wrap justify-center gap-[10px] md:flex-col">
            <li>
              <a
                href="/politiquedeconfidentialite"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/politiquedeconfidentialite")
                    ? "active-link font-bold underline"
                    : ""
                }`}
              >
                Politique de confidentialité
              </a>
            </li>
            <li>
              <a
                href="/mentionslegales"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/mentionslegales")
                    ? "active-link font-bold underline"
                    : ""
                }`}
              >
                Mentions légales
              </a>
            </li>
            <li>
              <a
                href="/apropos"
                className={`text-white no-underline transition-colors duration-200 p-[3px] hover:text-[#369354] text-[14px] md:p-[5px] md:text-base ${
                  isActive("/apropos") ? "active-link font-bold underline" : ""
                }`}
              >
                À propos
              </a>
            </li>
          </ul>
        </div>

        <div className="footer-paiement-reseau flex flex-col items-center">
          <div className="footer-paiement flex flex-col items-center">
            <div className="flex flex-row justify-center">
              <img
                src="/image/logo/paiement/visa.svg"
                alt="Logo de paiement Visa"
                className="m-[5px] transition-all duration-200"
              />
              <img
                src="/image/logo/paiement/cb.svg"
                alt="Logo de paiement carte bancaire"
                className="m-[5px] transition-all duration-200"
              />
            </div>

            <div className="flex flex-row justify-center">
              <img
                src="/image/logo/paiement/paypal.svg"
                alt="Logo de paiement paypal"
                className="m-[5px] transition-all duration-200"
              />
              <img
                src="/image/logo/paiement/mastercard.svg"
                alt="Logo de paiement mastercard"
                className="m-[5px] transition-all duration-200"
              />
            </div>
          </div>

          <div className="footer-reseau">
            <a href="#" className="group">
              <img
                src="/image/logo/reseau/facebook.svg"
                alt="Logo du reseau social facebook"
                className="m-[5px] transition-all duration-200 group-hover:filter  group-hover:invert-[44%] group-hover:sepia-[36%] group-hover:saturate-[1347%] group-hover:hue-rotate-88 group-hover:brightness-[95%] group-hover:contrast-[89%]"
              />
            </a>
            <a href="#" className="group">
              <img
                src="/image/logo/reseau/youtube.svg"
                alt="Logo du reseau social youtube"
                className="m-[5px] transition-all duration-200 group-hover:filter  group-hover:invert-[44%] group-hover:sepia-[36%] group-hover:saturate-[1347%] group-hover:hue-rotate-88 group-hover:brightness-[95%] group-hover:contrast-[89%]"
              />
            </a>
            <a href="#" className="group">
              <img
                src="/image/logo/reseau/instagram.svg"
                alt="Logo du reseau social instagram"
                className="m-[5px] transition-all duration-200 group-hover:filter  group-hover:invert-[44%] group-hover:sepia-[36%] group-hover:saturate-[1347%] group-hover:hue-rotate-88 group-hover:brightness-[95%] group-hover:contrast-[89%]"
              />
            </a>
            <a href="#" className="group">
              <img
                src="/image/logo/reseau/tiktok.svg"
                alt="Logo du reseau social tiktok"
                className="m-[5px] transition-all duration-200 group-hover:filter  group-hover:invert-[44%] group-hover:sepia-[36%] group-hover:saturate-[1347%] group-hover:hue-rotate-88 group-hover:brightness-[95%] group-hover:contrast-[89%]"
              />
            </a>
            <a href="#" className="group">
              <img
                src="/image/logo/reseau/x.svg"
                alt="Logo du reseau social X"
                className="m-[5px] transition-all duration-200 group-hover:filter  group-hover:invert-[44%] group-hover:sepia-[36%] group-hover:saturate-[1347%] group-hover:hue-rotate-88 group-hover:brightness-[95%] group-hover:contrast-[89%]"
              />
            </a>
          </div>
        </div>
      </div>

      <hr className="mt-[20px] max-w-[60%] h-[1px] border-none bg-[rgba(255,255,255,0.445)] my-[10px] mx-auto" />

      <p className="text-center text-gray-300 italic">
        © 2025 Green Village. Tous droits réservés.
      </p>
    </footer>
  );
};

export default Footer;
