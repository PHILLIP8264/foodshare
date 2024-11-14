const express = require('express');
const Claim = require('../models/Claim');

const router = express.Router();

router.post('/claim', async (req, res) => {
  const { userId, listingId } = req.body;
  const claim = new Claim({ userId, listingId });
  await claim.save();
  res.send('Item claimed successfully');
});

module.exports = router;
