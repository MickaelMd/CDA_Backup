function CardProduit({
  nomProduit,
  produitId,
  lienImg,
  nomCategorie,
  lienCategorie,
  prix,
}) {
  return (
    <div className="rounded-xl flex flex-col items-center w-[200px] overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 bg-white border border-transparent hover:border-green-500">
      <div className="h-[150px] w-full overflow-hidden">
        <img
          className="w-full h-full object-cover"
          src={lienImg}
          alt={nomProduit}
        />
      </div>
      <h1 className="p-2 font-bold text-center transition-colors duration-300 hover:text-green-600">
        {nomProduit}
      </h1>
      <a className=" text-gray-500" href={"/categorie/" + lienCategorie}>
        {nomCategorie}
      </a>
      <p className="m-2">{prix} €</p>
      <a
        className="text-center m-2 bg-green-500 hover:bg-green-600 text-white rounded-2xl py-1 px-3 transition-colors duration-200"
        href={"produit/" + produitId}
      >
        Page du produit
      </a>
    </div>
  );
}

export default CardProduit;
