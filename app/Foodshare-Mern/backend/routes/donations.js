const express = require('express');
const Donation = require('../models/Donation');

const router = express.Router();

router.post('/donate', async (req, res) => {
  const { userId, amount, description } = req.body;
  const donation = new Donation({ userId, amount, description });
  await donation.save();
  res.send('Donation recorded successfully');
});

module.exports = router;
