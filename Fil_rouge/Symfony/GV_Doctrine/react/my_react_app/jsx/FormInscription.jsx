import React, { useState } from "react";

const FormInscription = ({ token_csrf }) => {
  const [formData, setFormData] = useState({
    nom: "",
    prenom: "",
    email: "",
    telephone: "",
    adresseLivraison: "",
    adresseFacturation: "",
    plainPassword: "",
    agreeTerms: false,
  });

  const [errors, setErrors] = useState({});
  const [isSubmitting, setIsSubmitting] = useState(false);

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value,
    }));

    if (errors[name]) {
      setErrors((prev) => ({
        ...prev,
        [name]: "",
      }));
    }
  };

  const validateForm = () => {
    const newErrors = {};

    if (!formData.nom.trim()) {
      newErrors.nom = "Le nom est requis";
    } else if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(formData.nom.trim())) {
      newErrors.nom =
        "Le nom ne peut contenir que des lettres, espaces, apostrophes et tirets";
    }

    if (!formData.prenom.trim()) {
      newErrors.prenom = "Le prénom est requis";
    } else if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(formData.prenom.trim())) {
      newErrors.prenom =
        "Le prénom ne peut contenir que des lettres, espaces, apostrophes et tirets";
    }

    if (!formData.email.trim()) {
      newErrors.email = "L'adresse email est requise";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = "Format d'email invalide";
    }

    if (formData.telephone.trim()) {
      const phoneRegex =
        /^(?:(?:\+33|0)[1-9](?:[0-9]{8}))$|^(?:0[1-9](?:[-.\s]?[0-9]{2}){4})$/;
      const cleanPhone = formData.telephone.replace(/[-.\s]/g, "");

      if (
        !phoneRegex.test(cleanPhone) &&
        !/^0[1-9][0-9]{8}$/.test(cleanPhone)
      ) {
        newErrors.telephone =
          "Format de téléphone invalide (ex: 01 23 45 67 89)";
      }
    }

    if (formData.adresseLivraison.trim()) {
      const adresseLivraison = formData.adresseLivraison.trim();

      if (adresseLivraison.length < 10) {
        newErrors.adresseLivraison =
          "L'adresse de livraison doit contenir au moins 10 caractères";
      } else if (!/\d/.test(adresseLivraison)) {
        newErrors.adresseLivraison = "L'adresse doit contenir un numéro";
      } else if (!/^[a-zA-Z0-9À-ÿ\s,.''-]+$/.test(adresseLivraison)) {
        newErrors.adresseLivraison =
          "Seuls les lettres, chiffres, espaces et les caractères , . ' - sont autorisés";
      }
    }

    if (formData.adresseFacturation.trim()) {
      const adresseFacturation = formData.adresseFacturation.trim();

      if (adresseFacturation.length < 10) {
        newErrors.adresseFacturation =
          "L'adresse de facturation doit contenir au moins 10 caractères";
      } else if (!/\d/.test(adresseFacturation)) {
        newErrors.adresseFacturation = "L'adresse doit contenir un numéro";
      } else if (!/^[a-zA-Z0-9À-ÿ\s,.''-]+$/.test(adresseFacturation)) {
        newErrors.adresseFacturation =
          "Seuls les lettres, chiffres, espaces et les caractères , . ' - sont autorisés";
      }
    }

    if (!formData.plainPassword) {
      newErrors.plainPassword = "Le mot de passe est requis";
    } else if (formData.plainPassword.length < 8) {
      newErrors.plainPassword =
        "Le mot de passe doit contenir au moins 8 caractères";
    }

    if (!formData.agreeTerms) {
      newErrors.agreeTerms = "Vous devez accepter les conditions d'utilisation";
    }

    return newErrors;
  };

  const handleSubmit = () => {
    const validationErrors = validateForm();

    if (Object.keys(validationErrors).length > 0) {
      setErrors(validationErrors);
      return;
    }

    setIsSubmitting(true);

    const dataToSubmit = { ...formData };

    if (
      !dataToSubmit.adresseFacturation.trim() &&
      dataToSubmit.adresseLivraison.trim()
    ) {
      dataToSubmit.adresseFacturation = dataToSubmit.adresseLivraison;
    }

    const form = document.createElement("form");
    form.method = "POST";
    form.action = window.location.href;

    Object.keys(dataToSubmit).forEach((key) => {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = `registration_form[${key}]`;
      input.value = dataToSubmit[key];
      form.appendChild(input);
    });

    if (token_csrf) {
      const tokenInput = document.createElement("input");
      tokenInput.type = "hidden";
      tokenInput.name = "registration_form[_token]";
      tokenInput.value = token_csrf;
      form.appendChild(tokenInput);
    }

    document.body.appendChild(form);
    form.submit();
  };

  return (
    <div className="flex flex-col items-center w-full p-4">
      <div className="flex flex-col items-center w-full max-w-[300px]">
        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_nom"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Nom <span className="text-[#ff0000]">*</span>
          </label>
          <input
            type="text"
            id="registration_form_nom"
            name="nom"
            value={formData.nom}
            onChange={handleChange}
            required
            placeholder="Votre nom"
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.nom ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.nom && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.nom}
            </div>
          )}
        </div>
        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_prenom"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Prénom <span className="text-[#ff0000]">*</span>
          </label>
          <input
            type="text"
            id="registration_form_prenom"
            name="prenom"
            value={formData.prenom}
            onChange={handleChange}
            required
            placeholder="Votre prénom"
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.prenom ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.prenom && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.prenom}
            </div>
          )}
        </div>

        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_email"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Adresse email <span className="text-[#ff0000]">*</span>
          </label>
          <input
            type="email"
            id="registration_form_email"
            name="email"
            value={formData.email}
            onChange={handleChange}
            required
            placeholder="exemple@email.com"
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.email ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.email && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.email}
            </div>
          )}
        </div>

        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_telephone"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Téléphone
          </label>
          <input
            type="tel"
            id="registration_form_telephone"
            name="telephone"
            value={formData.telephone}
            onChange={handleChange}
            placeholder="01 23 45 67 89"
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.telephone ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.telephone && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.telephone}
            </div>
          )}
        </div>

        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_adresseLivraison"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Adresse de livraison
          </label>
          <textarea
            id="registration_form_adresseLivraison"
            name="adresseLivraison"
            value={formData.adresseLivraison}
            onChange={handleChange}
            placeholder="Adresse complète de livraison"
            rows={3}
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.adresseLivraison ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.adresseLivraison && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.adresseLivraison}
            </div>
          )}
          <small className="text-[#555] text-[10pt] mt-[5px] block">
            Exemple : 8 boulevard des Instruments, 69007 Lyon
          </small>
        </div>

        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_adresseFacturation"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Adresse de facturation
          </label>
          <textarea
            id="registration_form_adresseFacturation"
            name="adresseFacturation"
            value={formData.adresseFacturation}
            onChange={handleChange}
            placeholder="Adresse complète de facturation"
            rows={3}
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.adresseFacturation ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.adresseFacturation && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.adresseFacturation}
            </div>
          )}
          <small className="text-[#555] text-[10pt] mt-[5px] block">
            Optionnel - Si vide, l'adresse de livraison sera utilisée
          </small>
        </div>

        <div className="w-full mb-[15px]">
          <label
            htmlFor="registration_form_plainPassword"
            className="block text-left w-full mt-[10px] mb-[5px]"
          >
            Mot de passe <span className="text-[#ff0000]">*</span>
          </label>
          <input
            type="password"
            id="registration_form_plainPassword"
            name="plainPassword"
            value={formData.plainPassword}
            onChange={handleChange}
            required
            autoComplete="new-password"
            className={`w-full bg-white border border-black rounded-[16px] py-[5px] px-[15px] text-[12pt] transition-[border] duration-200 focus:border-[#4caf50] focus:outline-none ${
              errors.plainPassword ? "border-[#ff0000]" : ""
            }`}
          />
          {errors.plainPassword && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.plainPassword}
            </div>
          )}
        </div>

        <div className="w-full mb-[15px] text-center">
          <label
            htmlFor="registration_form_agreeTerms"
            className="flex items-center justify-center"
          >
            <input
              type="checkbox"
              id="registration_form_agreeTerms"
              name="agreeTerms"
              checked={formData.agreeTerms}
              onChange={handleChange}
              required
              value="1"
              className="mr-2"
            />
            J'accepte les conditions d'utilisation{" "}
            <span className="text-[#ff0000]">*</span>
          </label>
          {errors.agreeTerms && (
            <div className="text-[#ff0000] text-[11pt] mt-[3px]">
              {errors.agreeTerms}
            </div>
          )}
        </div>

        <button
          type="button"
          onClick={handleSubmit}
          className={`py-[5px] px-[40px] bg-[#369354] text-white rounded-[25px] shadow-[0_4px_4px_rgba(0,0,0,0.25)] mt-[20px] text-[13pt] border-none cursor-pointer transition-[box-shadow] duration-200 ease-in-out ${
            isSubmitting
              ? "opacity-50 cursor-not-allowed"
              : "hover:shadow-[0_4px_4px_rgba(0,0,0,0.25),inset_0_0_16px_5px_rgba(0,0,0,0.25)]"
          }`}
          disabled={isSubmitting}
        >
          {isSubmitting ? "Inscription en cours..." : "S'inscrire"}
        </button>
      </div>

      <div className="flex flex-col items-center mt-[30px]">
        <p>Déjà inscrit ?</p>
        <a
          href="/connexion"
          className="py-[5px] px-[40px] bg-[#369354] text-white rounded-[25px] shadow-[0_4px_4px_rgba(0,0,0,0.25)] mt-[20px] text-[13pt] no-underline transition-[box-shadow] duration-200 ease-in-out hover:shadow-[0_4px_4px_rgba(0,0,0,0.25),inset_0_0_16px_5px_rgba(0,0,0,0.25)]"
        >
          Se connecter
        </a>
      </div>
    </div>
  );
};

export default FormInscription;
