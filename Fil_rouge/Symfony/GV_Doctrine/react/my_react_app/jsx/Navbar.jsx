import { useState, useEffect } from "react";
import "./nav.css";

const Navbar = () => {
  const [searchValue, setSearchValue] = useState("");
  const [results, setResults] = useState([]);
  const [isFocused, setIsFocused] = useState(false);

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
          setResults(activeProducts);
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
    setIsFocused(false);
  };

  const handleInputBlur = () => {
    setTimeout(() => setIsFocused(false), 150);
  };

  const handleSearchMobile = () => {
    console.log("clique !!");
  };

  const handleMenuMobile = () => {
    console.log("menu clique !");
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
              <a className="link-nav" href="">
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
                onFocus={() => setIsFocused(true)}
                onBlur={handleInputBlur}
              />
              <img
                src="./image/logo/interface/loupe.svg"
                alt="Rechercher"
                className="search-icon"
              />
            </div>
            <ul
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
                display: isFocused && results.length > 0 ? "block" : "none",
              }}
            >
              {results.map((produit) => (
                <li
                  key={produit.id}
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
            src="./image/logo/interface/loupe.svg"
            alt="Rechercher"
            className="search-icon-mobile nav-icon"
            onClick={handleSearchMobile}
          />

          <a href="">
            <img
              className="nav-icon"
              src="./image/logo/interface/panier.svg"
              alt="Logo Panier"
            />
          </a>
          <a href="">
            <img
              className="nav-icon"
              src="./image/logo/interface/user.svg"
              alt="Logo Utilisateur"
            />
          </a>
          <img
            src="./image/logo/interface/menu.svg"
            alt="Rechercher"
            className=" nav-icon nav-hamb"
            onClick={handleMenuMobile}
          />
        </div>
      </nav>
    </>
  );
};

export default Navbar;
