const express = require('express');
const Listing = require('../models/Listing');

const router = express.Router();

// Add a new listing
router.post('/add', async (req, res) => {
  const listingData = req.body;
  const listing = new Listing(listingData);
  await listing.save();
  res.send('Listing created');
});

// Get all listings
router.get('/', async (req, res) => {
  const listings = await Listing.find();
  res.json(listings);
});

module.exports = router;
