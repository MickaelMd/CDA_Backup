import React, { useState } from "react";
import "./forminscription.css";

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

    // Validation adresse de livraison avec nouveaux caractères autorisés
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

    // Validation adresse de facturation avec nouveaux caractères autorisés
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
    <div className="form-inscription-container">
      <div className="registration-form">
        <div className="form-group">
          <div>
            <label htmlFor="registration_form_nom" className="required">
              Nom <span className="color-erreur-text">*</span>
            </label>
            <input
              type="text"
              id="registration_form_nom"
              name="nom"
              value={formData.nom}
              onChange={handleChange}
              required
              placeholder="Votre nom"
              className={errors.nom ? "error" : ""}
            />
            {errors.nom && <div className="form-error">{errors.nom}</div>}
          </div>
        </div>

        <div className="form-group">
          <div>
            <label htmlFor="registration_form_prenom" className="required">
              Prénom <span className="color-erreur-text">*</span>
            </label>
            <input
              type="text"
              id="registration_form_prenom"
              name="prenom"
              value={formData.prenom}
              onChange={handleChange}
              required
              placeholder="Votre prénom"
              className={errors.prenom ? "error" : ""}
            />
            {errors.prenom && <div className="form-error">{errors.prenom}</div>}
          </div>
        </div>

        <div className="form-group">
          <div>
            <label htmlFor="registration_form_email" className="required">
              Adresse email <span className="color-erreur-text">*</span>
            </label>
            <input
              type="email"
              id="registration_form_email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              required
              placeholder="exemple@email.com"
              className={errors.email ? "error" : ""}
            />
            {errors.email && <div className="form-error">{errors.email}</div>}
          </div>
        </div>

        <div className="form-group">
          <div>
            <label htmlFor="registration_form_telephone">Téléphone</label>
            <input
              type="tel"
              id="registration_form_telephone"
              name="telephone"
              value={formData.telephone}
              onChange={handleChange}
              placeholder="01 23 45 67 89"
              className={errors.telephone ? "error" : ""}
            />
            {errors.telephone && (
              <div className="form-error">{errors.telephone}</div>
            )}
          </div>
        </div>

        <div className="form-group">
          <div>
            <label htmlFor="registration_form_adresseLivraison">
              Adresse de livraison
            </label>
            <textarea
              id="registration_form_adresseLivraison"
              name="adresseLivraison"
              value={formData.adresseLivraison}
              onChange={handleChange}
              placeholder="Adresse complète de livraison"
              rows="3"
              className={errors.adresseLivraison ? "error" : ""}
            />
            {errors.adresseLivraison && (
              <div className="form-error">{errors.adresseLivraison}</div>
            )}
          </div>
          <small>Exemple : 8 boulevard des Instruments, 69007 Lyon</small>
        </div>

        <div className="form-group">
          <div>
            <label htmlFor="registration_form_adresseFacturation">
              Adresse de facturation
            </label>
            <textarea
              id="registration_form_adresseFacturation"
              name="adresseFacturation"
              value={formData.adresseFacturation}
              onChange={handleChange}
              placeholder="Adresse complète de facturation"
              rows="3"
              className={errors.adresseFacturation ? "error" : ""}
            />
            {errors.adresseFacturation && (
              <div className="form-error">{errors.adresseFacturation}</div>
            )}
          </div>
          <small>
            Optionnel - Si vide, l'adresse de livraison sera utilisée
          </small>
        </div>

        <div className="form-group">
          <div>
            <label
              htmlFor="registration_form_plainPassword"
              className="required"
            >
              Mot de passe <span className="color-erreur-text">*</span>
            </label>
            <input
              type="password"
              id="registration_form_plainPassword"
              name="plainPassword"
              value={formData.plainPassword}
              onChange={handleChange}
              required
              autoComplete="new-password"
              className={errors.plainPassword ? "error" : ""}
            />
            {errors.plainPassword && (
              <div className="form-error">{errors.plainPassword}</div>
            )}
          </div>
        </div>

        <div className="form-group checkbox-group">
          <label
            htmlFor="registration_form_agreeTerms"
            className="required checkbox-label"
            style={{ textAlign: "center" }}
          >
            <input
              type="checkbox"
              id="registration_form_agreeTerms"
              name="agreeTerms"
              checked={formData.agreeTerms}
              onChange={handleChange}
              required
              value="1"
            />
            J'accepte les conditions d'utilisation{" "}
            <span className="color-erreur-text">*</span>
          </label>
          {errors.agreeTerms && (
            <div className="form-error">{errors.agreeTerms}</div>
          )}
        </div>

        <button
          type="button"
          onClick={handleSubmit}
          className="login-btn"
          disabled={isSubmitting}
        >
          {isSubmitting ? "Inscription en cours..." : "S'inscrire"}
        </button>
      </div>

      <p className="login-link">
        Déjà inscrit ? <a href="/connexion">Se connecter</a>
      </p>
    </div>
  );
};

export default FormInscription;
