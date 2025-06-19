const FormAdresse = ({ adresseLivraison }) => {
  return (
    <section>
      <div className="profil-card-adresse color-fond2">
        <h1 className="font-title">Adresse de livraison</h1>
        <form action="">
          <textarea
            name="adresseLivraison"
            id="adresseLivraison"
            defaultValue={adresseLivraison}
          ></textarea>
          <button type="submit">Modifier</button>
        </form>
      </div>
    </section>
  );
};

export default FormAdresse;
