document.addEventListener("DOMContentLoaded", function () {
  function showError(idChamp, message) {
    const champ = document.getElementById(idChamp);
    if (!champ) return;

    if (
      champ.previousElementSibling &&
      champ.previousElementSibling.classList.contains("form-error")
    ) {
      champ.previousElementSibling.remove();
    }

    const erreur = document.createElement("p");
    erreur.className = "form-error";
    erreur.style.color = "red";
    erreur.style.margin = "0 0 4px 0";
    erreur.textContent = message;

    champ.insertAdjacentElement("beforebegin", erreur);
    champ.style.border = "1px solid red";
  }

  function clearError(idChamp) {
    const champ = document.getElementById(idChamp);
    if (!champ) return;

    if (
      champ.previousElementSibling &&
      champ.previousElementSibling.classList.contains("form-error")
    ) {
      champ.previousElementSibling.remove();
    }

    champ.style.border = "1px solid green";
  }

  // ---------------- Fournisseur -----------------

  const selectFournisseur = document.getElementById("fournisseur-select");
  const selectCommercial = document.querySelector("select#select-commercial");

  if (selectFournisseur) {
    selectFournisseur.addEventListener("change", function () {
      const selectedOption =
        selectFournisseur.options[selectFournisseur.selectedIndex];

      const id = selectedOption.dataset.userId;
      const nom = selectedOption.dataset.userNom;
      const email = selectedOption.dataset.userEmail;
      const telephone = selectedOption.dataset.userTelephone;
      const adresse = selectedOption.dataset.userAdresse;
      const commercialId = selectedOption.dataset.userCommercial;

      document.getElementById("fourni-id").value = id || "";
      document.getElementById("fourni-nom").value = nom || "";
      document.getElementById("fourni-email").value = email || "";
      document.getElementById("fourni-telephone").value = telephone || "";
      document.getElementById("fourni-adresse").value = adresse || "";

      if (selectCommercial) {
        selectCommercial.value = commercialId || "";
      }
    });
  }

  // ---------------- Produit Select -----------------

  const selectProduit = document.getElementById("produit-select");

  if (selectProduit) {
    selectProduit.addEventListener("change", function () {
      const selectedOption = selectProduit.options[selectProduit.selectedIndex];

      if (selectedOption.value === "") {
        document.getElementById("produit-id").value = "";
        document.getElementById("produit-libelle_court").value = "";
        document.getElementById("produit_libelle_long").value = "";
        document.getElementById("produit-stock").value = "";
        document.getElementById("produit-prixht").value = "";
        document.getElementById("produit-prixFournisseur").value = "";
        document.getElementById("produit-promotion").value = "";
        document.getElementById("produit-select-fournisseur").value = "";
        document.getElementById("produit-categorie").value = "";
        document.getElementById("produit-sous-categorie").value = "";
        document.getElementById("produit-sous-categorie").disabled = true;
        document.getElementById("produit-active").checked = false;
        document.getElementById("produit-image-preview").src =
          "./image/logo/interface/placeholder.svg";
        document.getElementById("produit-image").value = "";
        return;
      }

      const id = selectedOption.value;
      const nom = selectedOption.dataset.userNom;
      const description = selectedOption.dataset.userDesc;
      const stock = selectedOption.dataset.userStock;
      const prixHt = selectedOption.dataset.userPrixht;
      const prixFourni = selectedOption.dataset.userPrixfourni;
      const promotion = selectedOption.dataset.userPromo;
      const fournisseurId = selectedOption.dataset.userFourni;
      const sousCategorieId = selectedOption.dataset.userCat;
      const active = selectedOption.dataset.userActive;
      const imageUrl = selectedOption.dataset.userImage;

      // Remplir les champs du formulaire
      document.getElementById("produit-id").value = id || "";
      document.getElementById("produit-libelle_court").value = nom || "";
      document.getElementById("produit_libelle_long").value = description || "";
      document.getElementById("produit-stock").value = stock || "";
      document.getElementById("produit-prixht").value = prixHt || "";
      document.getElementById("produit-prixFournisseur").value =
        prixFourni || "";
      document.getElementById("produit-promotion").value = promotion || "";
      document.getElementById("produit-select-fournisseur").value =
        fournisseurId || "";
      document.getElementById("produit-active").checked = active === "1";

      const imagePreview = document.getElementById("produit-image-preview");
      if (imageUrl && imageUrl !== "") {
        imagePreview.src = imageUrl;
      } else {
        imagePreview.src = "./image/logo/interface/placeholder.svg";
      }

      if (sousCategorieId) {
        const categorieSelect = document.getElementById("produit-categorie");
        const sousCategorieSelect = document.getElementById(
          "produit-sous-categorie"
        );

        for (let i = 0; i < categorieSelect.options.length; i++) {
          const option = categorieSelect.options[i];
          const sousCategories = option.getAttribute("data-sous-categories");

          if (sousCategories && sousCategories !== "null") {
            try {
              const decodedJson = sousCategories.replace(/&quot;/g, '"');
              const sousCategoriesData = JSON.parse(decodedJson);

              const sousCategorieFound = sousCategoriesData.find(
                (sc) => sc.id == sousCategorieId
              );

              if (sousCategorieFound) {
                categorieSelect.value = option.value;

                const event = new Event("change");
                categorieSelect.dispatchEvent(event);

                setTimeout(() => {
                  sousCategorieSelect.value = sousCategorieId;
                }, 0);

                break;
              }
            } catch (error) {
              console.error(
                "Erreur lors du parsing des sous-catégories:",
                error
              );
            }
          }
        }
      }
    });
  }

  // -------------------- verif fournisseur --------------------

  const fournisseurInput = {
    nom: document.getElementById("fourni-nom"),
    email: document.getElementById("fourni-email"),
    telephone: document.getElementById("fourni-telephone"),
    adresse: document.getElementById("fourni-adresse"),
    commercial: document.getElementById("select-commercial"),
  };

  const fournisseurIds = {
    nom: "fourni-nom",
    email: "fourni-email",
    telephone: "fourni-telephone",
    adresse: "fourni-adresse",
    commercial: "select-commercial",
  };

  const regex = {
    nom: /^[a-zA-Z0-9\s'*.,-]+$/,
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    telephone: /^\+?[0-9\s\-]+$/,
    adresse: /^[\p{L}0-9\s,'\-]+$/u,
    commercial: /^.+$/,
  };

  const erreur = {
    nom: "Le nom du fournisseur ne doit être valide.",
    email: "L'adresse e-mail que vous avez saisie n'est pas valide.",
    telephone: "Le numéro de téléphone doit être valide.",
    adresse: "Veuillez entrer une adresse valide.",
    commercial: "Veuillez sélectionner un commercial.",
  };

  const submit = document.getElementById("submit_btn_fournisseur");

  function verifFournisseur() {
    let isValid = true;

    for (let i = 0; i < Object.keys(fournisseurInput).length; i++) {
      const key = Object.keys(fournisseurInput)[i];
      const input = Object.values(fournisseurInput)[i];
      const idChamp = Object.values(fournisseurIds)[i];

      if (!input || !input.value.trim()) {
        showError(idChamp, `Le champ ${key} est requis.`);
        isValid = false;
      } else if (!regex[key].test(input.value.trim())) {
        showError(idChamp, Object.values(erreur)[i]);
        isValid = false;
      } else {
        clearError(idChamp);
      }
    }

    return isValid;
  }

  function realTimeCheckFournisseur() {
    for (let i = 0; i < Object.keys(fournisseurInput).length; i++) {
      if (Object.values(fournisseurInput)[i]) {
        Object.values(fournisseurInput)[i].addEventListener("input", (e) => {
          verifFournisseur(e);
        });
      }
    }
  }

  if (submit) {
    submit.addEventListener("click", (e) => {
      const isValid = verifFournisseur();
      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  function validateFournisseurForm() {
    verifFournisseur();
    realTimeCheckFournisseur();
  }

  // ---------------- Produit catégorie -----------------

  const categorieSelect = document.getElementById("produit-categorie");
  const sousCategorieSelect = document.getElementById("produit-sous-categorie");

  if (categorieSelect && sousCategorieSelect) {
    categorieSelect.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      const sousCategories = selectedOption.getAttribute(
        "data-sous-categories"
      );

      sousCategorieSelect.innerHTML = "";
      if (this.value === "") {
        sousCategorieSelect.innerHTML =
          '<option value="">Choisir d\'abord une catégorie</option>';
        sousCategorieSelect.disabled = true;
      } else {
        sousCategorieSelect.disabled = false;
        sousCategorieSelect.innerHTML =
          '<option value="">Choisir une sous-catégorie</option>';

        if (sousCategories && sousCategories !== "null") {
          try {
            const decodedJson = sousCategories.replace(/&quot;/g, '"');
            const sousCategoriesData = JSON.parse(decodedJson);

            sousCategoriesData.forEach(function (sousCategorie) {
              const option = document.createElement("option");
              option.value = sousCategorie.id;
              option.textContent = sousCategorie.nom;
              sousCategorieSelect.appendChild(option);
            });
          } catch (error) {
            console.error(
              "Erreur lors du chargement des sous-catégories:",
              error
            );
          }
        }
      }
    });
  }

  // ---------------- Produit Image -----------------

  const imagefile = document.getElementById("produit-image");
  const imagePreview = document.getElementById("produit-image-preview");

  if (imagefile && imagePreview) {
    imagefile.addEventListener("change", (e) => {
      const file = e.target.files[0];
      if (file) {
        if (file.size > 1048576) {
          alert(
            "Le fichier dépasse 1 Mo. Veuillez choisir un fichier plus petit."
          );
          imagefile.value = "";
          imagePreview.src = "/image/logo/interface/placeholder.svg";
          return;
        }
        imagePreview.src = URL.createObjectURL(file);
      } else {
        imagePreview.src = "/image/logo/interface/placeholder.svg";
      }
    });
  }

  // ---------------- Produit Vérif -----------------

  const produitInput = {
    nom: "produit-libelle_court",
    description: "produit_libelle_long",
    stock: "produit-stock",
    prixHt: "produit-prixht",
    prixFourni: "produit-prixFournisseur",
    promotion: "produit-promotion",
    nomFourni: "produit-select-fournisseur",
    categorie: "produit-categorie",
    sousCat: "produit-sous-categorie",
    image: "produit-image",
  };

  const produitErreur = {
    nom: "Le nom du produit doit être valide.",
    description: "La description du produit doit être valide.",
    stock: "Le stock doit contenir que des chiffres et être positif.",
    prixHt: "Le prix hors taxe doit contenir que des chiffres et être positif.",
    prixFourni:
      "Le prix fournisseur doit contenir que des chiffres et être positif.",
    promotion:
      "Le pourcentage de promotion doit contenir que des chiffres et être positif.",
    nomFourni: "Le produit doit avoir un fournisseur.",
    categorie: "Le produit doit avoir une catégorie.",
    sousCat: "Le produit doit avoir une sous catégorie.",
    image: "Le produit doit avoir une image.",
  };

  const regexProduit = {
    nom: /^[\p{L}0-9\s'*.,\-_/:'()«»°&@€$%?!+="\[\]{}|\\`~#^]+$/u,
    description: /^[\p{L}0-9\s'*.,\-_/:'()«»°&@€$%?!+="\[\]{}|\\`~#^]+$/u,
    stock: /^[0-9]+$/,
    prixHt: /^[0-9]+(\.[0-9]{1,2})?$/,
    prixFourni: /^[0-9]+(\.[0-9]{1,2})?$/,
    promotion: /^[0-9]+[.,]?[0-9]*$/,
    nomFourni: /^[0-9]+$/,
    categorie: /^[0-9]+$/,
    sousCat: /^[0-9]+$/,
  };

  const submitProduit = document.getElementById("submitProduit");
  const formProduit = document.getElementById("formProduit");

  function verifProduit() {
    let isValid = true;

    for (let key in produitInput) {
      const idChamp = produitInput[key];
      const champ = document.getElementById(idChamp);

      if (!champ) {
        console.warn(`Champ non trouvé: ${idChamp}`);
        continue;
      }

      if (key === "promotion" && champ.value.trim() === "") {
        clearError(idChamp);
        continue;
      }

      if (key === "image") {
        const imagePreview = document.getElementById("produit-image-preview");
        const hasExistingImage =
          imagePreview &&
          imagePreview.src &&
          !imagePreview.src.includes("placeholder.svg");

        if ((!champ.files || champ.files.length === 0) && !hasExistingImage) {
          showError(idChamp, produitErreur[key]);
          isValid = false;
        } else {
          clearError(idChamp);
        }
        continue;
      }

      const value = champ.value.trim();

      if (!value || value === "0" || value === "") {
        showError(idChamp, `Le champ ${key} est requis.`);
        isValid = false;
        continue;
      }

      if (key === "nomFourni" || key === "categorie" || key === "sousCat") {
        if (value === "" || value === "0") {
          showError(idChamp, produitErreur[key]);
          isValid = false;
        } else {
          clearError(idChamp);
        }
      } else if (regexProduit[key] && !regexProduit[key].test(value)) {
        showError(idChamp, produitErreur[key]);
        isValid = false;
      } else {
        clearError(idChamp);
      }
    }

    return isValid;
  }

  function realTimeCheckProduit() {
    for (let key in produitInput) {
      const idChamp = produitInput[key];
      const champ = document.getElementById(idChamp);
      if (!champ) continue;

      if (key === "image") {
        champ.addEventListener("change", () => {
          verifProduit();
        });
      } else {
        champ.addEventListener("input", () => {
          verifProduit();
        });
      }
    }
  }

  if (formProduit) {
    formProduit.addEventListener("submit", (e) => {
      const isValid = verifProduit();
      if (!isValid) {
        e.preventDefault();
      } else {
      }
    });
  }

  if (submitProduit) {
    submitProduit.addEventListener("click", (e) => {
      const isValid = verifProduit();
      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  realTimeCheckProduit();

  // ---------------- Commande -----------------

  const select = document.getElementById("commande-select");
  const statutSelect = document.getElementById("form-statut-select");
  const statutProduitSelect = document.getElementById(
    "form-statut-produit-select"
  );

  function updateTable() {
    const selected = select.options[select.selectedIndex];

    document.getElementById("com-id").textContent =
      selected.dataset.userId || "";
    document.getElementById("com-email").textContent =
      selected.dataset.userEmail || "";
    document.getElementById("com-adresse").textContent =
      selected.dataset.userAdresse || "";
    document.getElementById("com-modepaiement").textContent =
      selected.dataset.userModepaiement || "";
    document.getElementById("com-tva").textContent =
      selected.dataset.userTva || "";
    document.getElementById("com-total").textContent =
      selected.dataset.userTotal + " €" || "";
    document.getElementById("com-totalht").textContent =
      selected.dataset.userTotalht + " €" || "";
    document.getElementById("commande-id-hidden").value =
      selected.dataset.userId;

    if (statutSelect) {
      statutSelect.value = selected.dataset.userStatut || "en_attente";
    }

    updateProductsTable(selected);
  }

  function updateProductsTable(selectedOption) {
    try {
      const produitsData = selectedOption.dataset.produits;

      if (!produitsData) {
        clearProductsTable();
        return;
      }

      const produits = JSON.parse(produitsData);

      if (produits.length === 0) {
        clearProductsTable();
        return;
      }
      generateProductTables(produits);
    } catch (error) {
      console.error("Erreur lors du parsing des données produits:", error);
      clearProductsTable();
    }
  }

  function generateProductTables(produits) {
    const commandeTable = document.getElementById("table_com");
    const container = commandeTable.parentNode;

    const oldProductTables = container.querySelectorAll(".produit-table");
    oldProductTables.forEach((table) => table.remove());

    produits.forEach((produit, index) => {
      const tableDiv = document.createElement("div");
      tableDiv.className =
        "mt-[20px] flex flex-col justify-center produit-table";

      tableDiv.innerHTML = `

      <table class="table-auto border-collapse border border-slate-500 w-full max-w-4xl mx-auto text-sm text-left text-gray-700">
        <tbody class="bg-white">
          <tr>
            <th class="border border-slate-400 px-4 py-2 bg-gray-100 w-1/3 font-medium">Nom du produit</th>
            <td class="border border-slate-400 px-4 py-2">${
              produit.produit?.libelleCourt ||
              produit.produit?.nom ||
              "Produit non trouvé"
            }</td>
          </tr>
          <tr>
            <th class="border border-slate-400 px-4 py-2 bg-gray-100 w-1/3 font-medium">Quantité</th>
            <td class="border border-slate-400 px-4 py-2">${
              produit.quantite || "0"
            }</td>
          </tr>
          <tr>
            <th class="border border-slate-400 px-4 py-2 bg-gray-100 w-1/3 font-medium">Prix</th>
            <td class="border border-slate-400 px-4 py-2">${
              produit.prix || "0"
            } €</td>
          </tr>
          <tr>
            <th class="border border-slate-400 px-4 py-2 bg-gray-100 w-1/3 font-medium">Promotion</th>
            <td class="border border-slate-400 px-4 py-2">${
              produit.promotion ? produit.promotion * 100 + "%" : "Aucune"
            }</td>
          </tr>
          <tr>
            <th class="border border-slate-400 px-4 py-2 bg-gray-100 font-medium">Statut</th>
            <td class="border border-slate-400 px-4 py-2">
              <form action="">
                <input type="hidden" value="${
                  produit.id || ""
                }" name="com-commande-produit-id" class="produit-id-hidden">
                <select name="statut-produit" class="produit-statut-select rounded-[16px] text-center border-none text-[12pt] w-full max-w-[200px] h-[30px] cursor-pointer bg-[#62626269] backdrop-blur-[2.2px] font-title">
                  <option value="en_attente" ${
                    produit.statut === "en_attente" ? "selected" : ""
                  }>En attente</option>
                  <option value="en_préparation" ${
                    produit.statut === "en_préparation" ? "selected" : ""
                  }>En préparation</option>
                  <option value="expédiée" ${
                    produit.statut === "expédiée" ? "selected" : ""
                  }>Expédiée</option>
                  <option value="livrée" ${
                    produit.statut === "livrée" ? "selected" : ""
                  }>Livrée</option>
                </select>
                <button type="submit" class="app-button color-btnCta">Modifier</button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    `;
      commandeTable.insertAdjacentElement("afterend", tableDiv);
    });
  }

  function clearProductsTable() {
    const productTables = document.querySelectorAll(".produit-table");
    productTables.forEach((table) => table.remove());
  }
  window.addEventListener("DOMContentLoaded", updateTable);
  select.addEventListener("change", updateTable);
});
