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

    // Clear error when user starts typing
    if (errors[name]) {
      setErrors((prev) => ({
        ...prev,
        [name]: "",
      }));
    }
  };

  const validateForm = () => {
    const newErrors = {};

    // Validation des champs requis
    if (!formData.nom.trim()) {
      newErrors.nom = "Le nom est requis";
    }

    if (!formData.prenom.trim()) {
      newErrors.prenom = "Le prénom est requis";
    }

    if (!formData.email.trim()) {
      newErrors.email = "L'adresse email est requise";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = "Format d'email invalide";
    }

    if (!formData.plainPassword) {
      newErrors.plainPassword = "Le mot de passe est requis";
    } else if (formData.plainPassword.length < 6) {
      newErrors.plainPassword =
        "Le mot de passe doit contenir au moins 6 caractères";
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

    // Créer un formulaire HTML et le soumettre
    const form = document.createElement("form");
    form.method = "POST";
    form.action = window.location.href; // Soumet à la même URL (route d'inscription)

    // Ajouter tous les champs comme inputs cachés
    Object.keys(formData).forEach((key) => {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = `registration_form[${key}]`;
      input.value = formData[key];
      form.appendChild(input);
    });

    // Ajouter le token CSRF (vous devrez le récupérer de votre template Twig)
    const csrfToken = document
      .querySelector('meta[name="csrf-token"]')
      ?.getAttribute("content");
    if (csrfToken) {
      const tokenInput = document.createElement("input");
      tokenInput.type = "hidden";
      tokenInput.name = "registration_form[_token]";
      tokenInput.value = csrfToken;
      form.appendChild(tokenInput);
    }

    document.body.appendChild(form);
    form.submit();
  };

  return (
    <div className="form-inscription-container">
      <div className="header-title color-fond2 font-title">
        <h1>Inscription</h1>
      </div>

      <div onSubmit={handleSubmit} className="registration-form">
        <div className="form-group">
          <div>
            <label htmlFor="registration_form_nom" className="required">
              Nom
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
              Prénom
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
              Adresse email
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
            />
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
            />
          </div>
          <small>Optionnel - Adresse où seront livrées vos commandes</small>
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
            />
          </div>
          <small>
            Optionnel - Adresse pour la facturation (si différente de la
            livraison)
          </small>
        </div>

        <div className="form-group">
          <div>
            <label
              htmlFor="registration_form_plainPassword"
              className="required"
            >
              Mot de passe
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
            J'accepte les conditions d'utilisation
          </label>
          {errors.agreeTerms && (
            <div className="form-error">{errors.agreeTerms}</div>
          )}
        </div>

        <button
          type="button"
          onClick={handleSubmit}
          className="submit-btn"
          disabled={isSubmitting}
        >
          S'inscrire
        </button>
      </div>

      <p className="login-link">
        Déjà inscrit ?{" "}
        <a
          href="#"
          onClick={(e) => {
            e.preventDefault();
            alert("Redirection vers connexion");
          }}
        >
          Se connecter
        </a>
      </p>
    </div>
  );
};

export default FormInscription;
