const mongoose = require('mongoose');

const soupKitchenSchema = new mongoose.Schema({
  name: String,
  latitude: Number,
  longitude: Number
});

const SoupKitchen = mongoose.model('SoupKitchen', soupKitchenSchema);

module.exports = SoupKitchen;
