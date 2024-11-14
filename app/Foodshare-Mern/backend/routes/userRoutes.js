const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const multer = require('multer');
const User = require('../models/User');

const router = express.Router();
const upload = multer({ dest: 'uploads/' });

// Register user
router.post('/register', async (req, res) => {
  const { username, password } = req.body;
  const hashedPassword = await bcrypt.hash(password, 10);
  const user = new User({ username, password: hashedPassword });
  await user.save();
  res.send('User registered successfully');
});

// Login user
router.post('/login', async (req, res) => {
  const { username, password } = req.body;
  const user = await User.findOne({ username });
  if (user && await bcrypt.compare(password, user.password)) {
    const token = jwt.sign({ id: user._id }, process.env.JWT_SECRET);
    res.json({ token });
  } else {
    res.status(401).send('Invalid credentials');
  }
});

// Update credentials
router.put('/change-credentials', async (req, res) => {
  const { userId, newUsername, newPassword } = req.body;
  const hashedPassword = await bcrypt.hash(newPassword, 10);
  await User.findByIdAndUpdate(userId, { username: newUsername, password: hashedPassword });
  res.send('Credentials updated');
});

// Update profile picture
router.post('/update-profile-pic', upload.single('profilePic'), async (req, res) => {
  const { userId } = req.body;
  const profilePicPath = req.file.path;
  await User.findByIdAndUpdate(userId, { profilePic: profilePicPath });
  res.send('Profile picture updated');
});

module.exports = router;
