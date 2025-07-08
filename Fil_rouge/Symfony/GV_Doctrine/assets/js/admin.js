document.addEventListener("DOMContentLoaded", function () {
  const selectFournisseur = document.querySelector(".admin-select.font-title"); // select fournisseur
  const selectCommercial = document.querySelector("select#select-commercial"); // select commercial (on lui donne un id pour être sûr)

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
});
