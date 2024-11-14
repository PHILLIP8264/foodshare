const Listing = require('../models/Listing');

const createListing = async (req, res) => {
  try {
    const { foodType, quantity, expirationDate, pickupLocation } = req.body;
    const newListing = new Listing({
      userId: req.user.id,
      foodType,
      quantity,
      expirationDate,
      pickupLocation,
    });
    await newListing.save();
    res.status(201).json(newListing);
  } catch (err) {
    res.status(500).json({ message: 'Error creating listing' });
  }
};

module.exports = { createListing };
