const mongoose = require('mongoose');

const ListingSchema = new mongoose.Schema({
  userId: { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
  foodType: { type: String, required: true },
  quantity: { type: Number, required: true },
  expirationDate: { type: Date, required: true },
  pickupLocation: { type: String, required: true },
  status: { type: String, enum: ['available', 'claimed'], default: 'available' },
});

module.exports = mongoose.model('Listing', ListingSchema);
