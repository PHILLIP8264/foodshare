const express = require('express');
const connectDB = require('./config/db');
const userRoutes = require('./routes/userRoutes');
const listingsRoutes = require('./routes/listingsRoutes');
require('dotenv').config();

const app = express();
connectDB();

app.use(express.json());

app.use('/api/users', userRoutes);
app.use('/api/listings', listingsRoutes);

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
