const express = require("express");
const mongoose = require("mongoose");
const cors = require("cors");

const app = express();
app.use(cors());
app.use(express.static("public"));

mongoose
  .connect(
    "mongodb://root:example@localhost:27017/sample_mflix?authSource=admin"
  )
  .then(() => console.log("MongoDB connecté"))
  .catch((err) => console.error("Erreur de connexion MongoDB", err));

const Movie = mongoose.model(
  "Movie",
  new mongoose.Schema({}, { strict: false })
);

app.get("/api/movies", async (req, res) => {
  try {
    const movies = await Movie.find().limit(1000);
    res.json(movies);
  } catch (err) {
    console.error("Erreur dans /api/movies :", err);
    res.status(500).send("Erreur serveur");
  }
});

app.listen(3000, () => {
  console.log("Serveur en ligne sur http://localhost:3000");
});
