import React, { useState } from 'react';
import API from '../services/api';

function Profile() {
  const [profilePic, setProfilePic] = useState(null);

  const handleUpload = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('profilePic', profilePic);

    try {
      await API.post('/users/update-profile-pic', formData);
      alert('Profile picture updated');
    } catch (err) {
      console.error(err);
      alert('Failed to update profile picture');
    }
  };

  return (
    <form onSubmit={handleUpload}>
      <h2>Profile</h2>
      <input type="file" onChange={(e) => setProfilePic(e.target.files[0])} />
      <button type="submit">Upload</button>
    </form>
  );
}

export default Profile;
