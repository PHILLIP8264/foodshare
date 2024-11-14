const express = require('express');
const router = express.Router();
const { createListing } = require('../controllers/listingsController');
const authMiddleware = require('../middleware/authMiddleware');

router.post('/listings', authMiddleware, createListing);

module.exports = router;
