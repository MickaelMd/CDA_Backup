import { useState, useEffect } from "react";
import "./navbar.css";

const Navbar = () => {
  const [searchValue, setSearchValue] = useState("");
  const [results, setResults] = useState([]);
  const [isFocusedDesktop, setIsFocusedDesktop] = useState(false);
  const [isFocusedMobile, setIsFocusedMobile] = useState(false);
  const [showSearchMobile, setShowSearchMobile] = useState(false);
  const [showMenuMobile, setShowMenuMobile] = useState(false);

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth > 711) {
        setShowSearchMobile(false);
      }
      if (window.innerWidth > 530) {
        setShowMenuMobile(false);
      }
    };

    window.addEventListener("resize", handleResize);

    return () => {
      window.removeEventListener("resize", handleResize);
    };
  }, []);

  useEffect(() => {
    if (searchValue.trim() === "") {
      setResults([]);
      return;
    }

    const timeoutId = setTimeout(() => {
      const controller = new AbortController();
      const fetchProduits = async () => {
        try {
          const response = await fetch(
            `/api/produits?libelleCourt=${encodeURIComponent(searchValue)}`,
            { signal: controller.signal }
          );
          const data = await response.json();

          const activeProducts = (data.member || []).filter(
            (produit) => produit.active === true
          );
          setResults(activeProducts.slice(0, 5));
        } catch (error) {
          if (error.name !== "AbortError") {
          }
          setResults([]);
        }
      };

      fetchProduits();
      return () => controller.abort();
    }, 300);

    return () => clearTimeout(timeoutId);
  }, [searchValue]);

  const handleResultClick = (produit) => {
    setSearchValue(produit.libelleCourt);
    setIsFocusedDesktop(false);
    setIsFocusedMobile(false);
  };

  const handleSearchMobile = () => {
    setShowSearchMobile((prev) => !prev);
  };

  const handleMenuMobile = () => {
    setShowMenuMobile((prev) => !prev);
  };

  return (
    <>
      <nav className="color-fond2">
        <h1>
          <a className="nav-logo font-title color-logo-text" href="/">
            Green Village
          </a>
        </h1>

        <div className="nav-center">
          <ul>
            <li>
              <a className="link-nav" href="/categorie">
                Catégories
              </a>
            </li>

            <li>
              <a className="link-nav" href="">
                À propos
              </a>
            </li>
          </ul>

          <div className="search-container" style={{ position: "relative" }}>
            <div className="search-bar">
              <input
                type="text"
                placeholder="Rechercher un produit..."
                value={searchValue}
                onChange={(e) => setSearchValue(e.target.value)}
                onFocus={() => setIsFocusedDesktop(true)}
                onBlur={() => setTimeout(() => setIsFocusedDesktop(false), 150)}
              />

              <img
                src="/image/logo/interface/loupe.svg"
                alt="Rechercher"
                className="search-icon"
              />
            </div>
            <ul
              role="listbox"
              aria-label="Recherche de produit"
              style={{
                background: "#fff",
                color: "black",
                position: "absolute",
                top: "100%",
                left: 0,
                right: 0,
                zIndex: 1000,
                maxHeight: "300px",
                overflowY: "auto",
                border: "1px solid #ccc",
                borderRadius: "4px",
                boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
                margin: "5px 0px 0px 0px",
                padding: 0,
                listStyle: "none",
                display:
                  isFocusedDesktop && results.length > 0 ? "block" : "none",
              }}
            >
              {results.map((produit) => (
                <li
                  key={produit.id}
                  role="option"
                  aria-selected={false}
                  style={{
                    padding: "10px",
                    borderBottom: "1px solid #eee",
                    cursor: "pointer",
                    transition: "background-color 0.2s",
                  }}
                  className="result"
                  onClick={() => handleResultClick(produit)}
                  onMouseDown={(e) => e.preventDefault()}
                  onMouseEnter={(e) =>
                    (e.target.style.backgroundColor = "#f5f5f5")
                  }
                  onMouseLeave={(e) =>
                    (e.target.style.backgroundColor = "transparent")
                  }
                >
                  <a href={"/produit/" + produit.id}>{produit.libelleCourt}</a>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="nav-icons">
          <img
            src="/image/logo/interface/loupe.svg"
            alt="Rechercher"
            className={`search-icon-mobile nav-icon ${
              showSearchMobile ? "active" : ""
            }`}
            onClick={handleSearchMobile}
          />

          <a href="">
            <img
              className="nav-icon"
              src="/image/logo/interface/panier.svg"
              alt="Logo Panier"
            />
          </a>
          <a href="/profil">
            <img
              className="nav-icon"
              src="/image/logo/interface/user.svg"
              alt="Logo Utilisateur"
            />
          </a>
          <img
            src={
              showMenuMobile
                ? "/image/logo/interface/cross.svg"
                : "/image/logo/interface/menu.svg"
            }
            alt="Menu"
            className={`nav-icon nav-hamb transition ${
              showMenuMobile ? "rotate-in active" : "rotate-out"
            }`}
            onClick={handleMenuMobile}
          />
        </div>
      </nav>

      <div className={`menu-mobile-wrapper ${showMenuMobile ? "show" : ""}`}>
        <a className="link-nav-mobile" href="/categorie">
          Catégories
        </a>
        <a className="link-nav-mobile" href="">
          À propos
        </a>
      </div>

      <div
        className="search-container-mobile"
        style={{
          position: "absolute",
          top: "63px",
          left: 0,
          right: 0,
          zIndex: 1001,
          justifyContent: "center",
          display: "flex",
          maxHeight: showSearchMobile ? "500px" : "0px",
          overflow: showSearchMobile ? "visible" : "hidden",
          transition: "max-height 0.3s ease-in-out, opacity 0.3s ease-in-out",
          opacity: showSearchMobile ? 1 : 0,
        }}
      >
        <div
          className="search-bar-mobile"
          style={{
            transform: showSearchMobile ? "translateY(0)" : "translateY(-20px)",
            transition: "transform 0.3s ease-in-out",
          }}
        >
          <input
            type="text"
            placeholder="Rechercher un produit..."
            value={searchValue}
            onChange={(e) => setSearchValue(e.target.value)}
            onFocus={() => setIsFocusedMobile(true)}
            onBlur={() => setTimeout(() => setIsFocusedMobile(false), 150)}
          />
        </div>
        <ul
          role="listbox"
          aria-label="recherche de produit"
          style={{
            background: "#fff",
            color: "black",
            position: "absolute",
            top: "100%",
            left: "50%",
            transform: "translateX(-50%)",
            zIndex: 1002,
            maxHeight: "300px",
            overflowY: "auto",
            border: "1px solid #ccc",
            fontSize: "16px",
            borderRadius: "4px",
            boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
            margin: "5px 0 0 0",
            padding: 0,
            listStyle: "none",
            maxWidth: "90%",
            width: "100%",
            display: isFocusedMobile && results.length > 0 ? "block" : "none",
          }}
        >
          {results.map((produit) => (
            <li
              key={produit.id}
              role="option"
              aria-selected={false}
              style={{
                padding: "10px",
                borderBottom: "1px solid #eee",
                cursor: "pointer",
                transition: "background-color 0.2s",
              }}
              className="result"
              onClick={() => handleResultClick(produit)}
              onMouseDown={(e) => e.preventDefault()}
              onMouseEnter={(e) => (e.target.style.backgroundColor = "#f5f5f5")}
              onMouseLeave={(e) =>
                (e.target.style.backgroundColor = "transparent")
              }
            >
              <a href={"/produit/" + produit.id}>{produit.libelleCourt}</a>
            </li>
          ))}
        </ul>
      </div>
    </>
  );
};

export default Navbar;
