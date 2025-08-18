function CardCategorie({ nomCategorie, categorieId, lienImg }) {
  return (
    <a
      href={`/categorie/${categorieId}`}
      className="rounded-xl flex flex-col items-center w-[200px] overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 bg-white border border-transparent hover:border-green-500"
    >
      <div className="h-[120px] w-full overflow-hidden">
        <img
          className="w-full h-full object-cover"
          src={lienImg}
          alt={nomCategorie}
        />
      </div>
      <h1 className="p-3 text-gray-700 font-medium text-center transition-colors duration-300 hover:text-green-600">
        {nomCategorie}
      </h1>
    </a>
  );
}

export default CardCategorie;
