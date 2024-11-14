const mongoose = require('mongoose');

const donationSchema = new mongoose.Schema({
  userId: mongoose.Schema.Types.ObjectId,
  amount: Number,
  description: String,
  donatedAt: { type: Date, default: Date.now },
});

module.exports = mongoose.model('Donation', donationSchema);
