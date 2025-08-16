import { Search, User, ShoppingCart, Home, Grid3X3 } from "lucide-react";
import { Link } from "react-router-dom";

function Navbar() {
  return (
    <nav className="fixed bottom-0 left-0 right-0 bg-white/30 backdrop-blur-lg border-t border-gray-200/50 shadow-lg z-50">
      <div className="max-w-md mx-auto px-4 py-3">
        <div className="flex items-end justify-between">
          <Link
            to="/"
            className="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 hover:bg-gray-100 active:scale-95 group"
          >
            <Home className="w-6 h-6 text-gray-600 group-hover:text-green-600 transition-colors duration-200" />
            <span className="text-xs text-gray-600 group-hover:text-green-600 mt-1 font-medium transition-colors duration-200">
              Accueil
            </span>
          </Link>

          <Link
            to="/categories"
            className="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 hover:bg-gray-100 active:scale-95 group"
          >
            <Grid3X3 className="w-6 h-6 text-gray-600 group-hover:text-green-600 transition-colors duration-200" />
            <span className="text-xs text-gray-600 group-hover:text-green-600 mt-1 font-medium transition-colors duration-200">
              Catégories
            </span>
          </Link>

          <Link
            to="/recherche"
            className="flex flex-col items-center justify-center  p-4 rounded-full transition-all duration-200 hover:bg-gray-100 active:scale-95 group -mt-6"
          >
            <Search
              className="w-8 h-8 text-gray-600 group-hover:text-green-600 transition-colors duration-200"
              strokeWidth={1.5}
            />
          </Link>

          <Link
            to="/panier"
            className="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 hover:bg-gray-100 active:scale-95 group relative"
          >
            <div className="relative">
              <ShoppingCart className="w-6 h-6 text-gray-600 group-hover:text-green-600 transition-colors duration-200" />
              <div className="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium">
                2
              </div>
            </div>
            <span className="text-xs text-gray-600 group-hover:text-green-600 mt-1 font-medium transition-colors duration-200">
              Panier
            </span>
          </Link>

          <Link
            to="/profile"
            className="flex flex-col items-center justify-center p-2 rounded-xl transition-all duration-200 hover:bg-gray-100 active:scale-95 group"
          >
            <div className="w-8 h-8 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center group-hover:from-green-600 group-hover:to-green-600 transition-all duration-200">
              <User className="w-5 h-5 text-white" />
            </div>
            <span className="text-xs text-gray-600 group-hover:text-green-600 mt-1 font-medium transition-colors duration-200">
              Profil
            </span>
          </Link>
        </div>
      </div>
    </nav>
  );
}

export default Navbar;
