const FormAdresse = ({ adresseLivraison, titre }) => {
  return (
    <section>
      <div className="profil-card-adresse color-fond2">
        <h1 className="font-title">{titre}</h1>
        <form action="">
          <textarea
            name="adresseLivraison"
            id="adresseLivraison"
            defaultValue={adresseLivraison}
            rows="3"
          ></textarea>
          <button type="submit">Modifier</button>
        </form>
      </div>
    </section>
  );
};

export default FormAdresse;
