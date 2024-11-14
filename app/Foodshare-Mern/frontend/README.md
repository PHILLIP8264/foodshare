FoodShare MERN App
FoodShare is a web application built with the MERN (MongoDB, Express, React, Node.js) stack to help reduce food waste and address food insecurity by allowing users to donate and claim food items. The app includes functionalities for user registration, login, managing food listings, claiming donations, and updating profiles.

Table of Contents
Features
Prerequisites
Getting Started
Project Structure
API Documentation
Environment Variables
Deployment
Contributing
License
Features
User Registration & Authentication: Secure user registration and login functionality with JWT-based authentication.
Food Listings: Users can view food listings and claim available items.
Donations: Users can make monetary donations to support food initiatives.
Profile Management: Users can update their profile information and upload a profile picture.
Responsive Design: Mobile-friendly layout for easy access on any device.
Prerequisites
Node.js and npm
MongoDB (use MongoDB Atlas for a hosted database)
Git (for version control)
Getting Started
1. Clone the Repository
bash
Copy code
git clone https://github.com/yourusername/foodshare-mern.git
cd foodshare-mern
2. Set Up Backend
Install Dependencies
bash
Copy code
cd backend
npm install
Configure Environment Variables
Create a .env file in the backend directory with the following variables:

plaintext
Copy code
MONGO_URI=mongodb+srv://<username>:<password>@cluster.mongodb.net/foodshare?retryWrites=true&w=majority
JWT_SECRET=your_jwt_secret
PORT=5000
Start the Server
bash
Copy code
node server.js
The backend server will start on http://localhost:5000.

3. Set Up Frontend
Install Dependencies
bash
Copy code
cd ../frontend
npm install
Start the Frontend
bash
Copy code
npm start
The frontend will start on http://localhost:3000.

Project Structure
bash
Copy code
backend/
├── models/          # Mongoose models for database collections
├── routes/          # Express routes for user, listings, claims, and donations
├── server.js        # Main server file
└── .env             # Environment variables

frontend/
├── src/
│   ├── pages/       # Pages for each route (Home, Login, Register, Listings, etc.)
│   ├── components/  # Reusable components (Navbar, ProtectedRoute)
│   ├── services/    # API service for Axios instance and API calls
│   ├── context/     # User context for global state management
│   └── App.js       # Main React application file with routing
└── public/          # Static files
API Documentation
Authentication
POST /api/users/register - Register a new user
POST /api/users/login - Log in an existing user and receive a JWT
Listings
GET /api/listings - Fetch all food listings
POST /api/listings/add - Add a new listing (requires authentication)
Claims
POST /api/claims/claim - Claim a food item (requires authentication)
Donations
POST /api/donations/donate - Make a monetary donation (requires authentication)
Profile Management
PUT /api/users/change-credentials - Update user credentials
POST /api/users/update-profile-pic - Upload a profile picture (requires authentication)
Environment Variables
For the backend, create a .env file in the backend directory with the following variables:

MONGO_URI - MongoDB connection string
JWT_SECRET - Secret key for JWT token generation
PORT - Port number for the backend server
For the frontend, you may need to create a .env file in the frontend directory to specify the API URL, if different:

plaintext
Copy code
REACT_APP_API_URL=http://localhost:5000/api
Deployment
Backend (Express & MongoDB)
Use a cloud service like Heroku, DigitalOcean, or AWS to deploy the backend.
Ensure MongoDB is hosted on MongoDB Atlas or a similar cloud provider.
Set environment variables in your hosting platform with the values from your .env file.
Frontend (React)
Deploy the frontend using a service like Vercel, Netlify, or AWS Amplify.
Update the API URL in the frontend environment variables to point to the backend server’s deployed URL.
Contributing
Contributions are welcome! Please fork the repository, create a new branch, and submit a pull request for any changes or enhancements.

License
This project is licensed under the MIT License.

