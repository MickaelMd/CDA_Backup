document.addEventListener("DOMContentLoaded", function () {
  // ---------------- Fournisseur -----------------

  const selectFournisseur = document.querySelector(".admin-select.font-title");
  const selectCommercial = document.querySelector("select#select-commercial");

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

  // -------------------- verif --------------------

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
      Object.values(fournisseurInput)[i].addEventListener("input", (e) => {
        verifFournisseur(e);
      });
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

  categorieSelect.addEventListener("change", function () {
    const selectedOption = this.options[this.selectedIndex];
    const sousCategories = selectedOption.getAttribute("data-sous-categories");

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

  // ---------------- Produit Image -----------------

  const imagefile = document.getElementById("produit-image");
  const imagePreview = document.getElementById("produit-image-preview");

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
});

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
};

const produitErreur = {
  nom: "Le nom du produit doit être valide.",
  description: "La description du produit doit être valide.",
  stock: "Le stock doit contenir que des chiffre et être positive.",
  prixHt: "Le prix hors taxe doit contenir que des chiffre et être positive.",
  prixFourni:
    "Le prix fournisseur doit contenir que des chiffre et être positive.",
  promotion:
    "Le pourcentage de promotion doit contenir que des chiffre et être positive.",
  nomFourni: "Le produit doit avoir un fournisseur.",
  categorie: "Le produit doit avoir une catégorie.",
  sousCat: "Le produit doit avoir une sous catégorie.",
};

const regexProduit = {
  nom: /^[a-zA-Z0-9\s'*.,-]+$/,
  description: /^[a-zA-Z0-9\s'*.,-]+$/,
  stock: /^[0-9]+$/,
  prixHt: /^[0-9]+(\.[0-9]{1,2})?$/,
  prixFourni: /^[0-9]+(\.[0-9]{1,2})?$/,
  promotion: /^[0-9]+$/,
};

const submitProduit = document.getElementById("submitProduit");
const formProduit = document.getElementById("formProduit");

function verifProduit() {
  let isValid = true;

  for (let key in produitInput) {
    const idChamp = produitInput[key];
    const champ = document.getElementById(idChamp);

    if (!champ) continue;

    const value = champ.value.trim();

    if (key === "promotion" && value === "") {
      clearError(idChamp);
      continue;
    }

    if (!value) {
      showError(idChamp, `Le champ ${key} est requis.`);
      isValid = false;
      continue;
    }

    if (regexProduit[key] && !regexProduit[key].test(value)) {
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

    champ.addEventListener("input", () => {
      verifProduit();
    });
  }
}

if (formProduit) {
  formProduit.addEventListener("submit", (e) => {
    const isValid = verifProduit();
    if (!isValid) {
      e.preventDefault();
    }
  });
}

realTimeCheckProduit();
