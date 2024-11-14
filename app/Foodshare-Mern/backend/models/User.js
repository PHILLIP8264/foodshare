const mongoose = require('mongoose');

const UserSchema = new mongoose.Schema({
  username: { type: String, required: true },
  email: { type: String, required: true, unique: true },
  password: { type: String, required: true },
  role: { type: String, enum: ['donor', 'recipient'], required: true },
  location: { type: String, required: true },
});

module.exports = mongoose.model('User', UserSchema);
