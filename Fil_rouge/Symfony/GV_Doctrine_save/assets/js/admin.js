document.addEventListener("DOMContentLoaded", function () {
  const selectFournisseur = document.querySelector(".admin-select.font-title");
  const selectCommercial = document.querySelector("select#select-commercial");

  function showError(idChamp, message) {
    const champ = document.getElementById(idChamp);
    if (!champ) return;

    const erreurExistante = champ.parentElement.querySelector(".form-error");
    if (erreurExistante) {
      erreurExistante.remove();
    }
    const erreur = document.createElement("p");
    erreur.className = "form-error";
    erreur.style.color = "red";
    erreur.textContent = message;
    champ.parentElement.insertBefore(erreur, champ);
    champ.style.border = "1px solid red";
  }

  showError("fourni-telephone", "test erreur");

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
