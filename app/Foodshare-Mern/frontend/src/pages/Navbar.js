import React from 'react';
import { Link } from 'react-router-dom';

const handleLogout = () => {
    localStorage.removeItem('token');
    window.location.href = '/';
  };
  

function Navbar() {
  return (
    <nav>
      <ul>
        <li><Link to="/">Home</Link></li>
        <li><Link to="/register">Register</Link></li>
        <li><Link to="/login">Login</Link></li>
        <li><Link to="/listings">Listings</Link></li>
        <li><Link to="/donate">Donate</Link></li>
        <li><Link to="/profile">Profile</Link></li>
      </ul>
    </nav>
  );
}

export default Navbar;
