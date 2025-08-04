function Card({ title, image, desc, date }) {
  return (
    <div className="flex flex-col items-center gap-6 border text-white w-full max-w-[1000px] min-h-[300px] lg:h-[300px] bg-white/20 rounded-2xl backdrop-blur-sm p-4 sm:p-6">
      <div className="flex flex-col lg:flex-row items-center lg:items-center gap-5 flex-1 w-full">
        <div className="w-[110px] h-[185px] lg:h-[185px] overflow-hidden rounded-lg flex-shrink-0">
          <img className="w-full h-full object-cover" src={image} alt="img" />
        </div>
        <div className="flex flex-col justify-between h-full flex-1 text-center lg:text-left">
          <h1 className="font-semibold text-xl lg:text-2xl line-clamp-2">
            {title}
          </h1>
          <p className="text-gray-300 flex-1 line-clamp-3 text-sm lg:text-base mt-2 lg:mt-0 overflow-y-auto">
            {desc}
          </p>
          <p className="mt-2 lg:mt-4 text-sm lg:text-base">
            <span className="font-semibold">Date de sortie :</span> {date}
          </p>
        </div>
      </div>
    </div>
  );
}

export default Card;
