const mongoose = require('mongoose');

const claimSchema = new mongoose.Schema({
  userId: mongoose.Schema.Types.ObjectId,
  listingId: mongoose.Schema.Types.ObjectId,
  claimedAt: { type: Date, default: Date.now },
});

module.exports = mongoose.model('Claim', claimSchema);
