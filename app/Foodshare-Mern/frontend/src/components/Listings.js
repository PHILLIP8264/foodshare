import React, { useEffect, useState } from 'react';
import API from '../services/api';

function Listings() {
  const [listings, setListings] = useState([]);

  useEffect(() => {
    const fetchListings = async () => {
      try {
        const { data } = await API.get('/listings');
        setListings(data);
      } catch (err) {
        console.error(err);
      }
    };

    fetchListings();
  }, []);

  const handleClaim = async (listingId) => {
    try {
      await API.post('/claims/claim', { listingId });
      alert('Item claimed successfully');
    } catch (err) {
      console.error(err);
      alert('Failed to claim item');
    }
  };

  return (
    <div>
      <h2>Listings</h2>
      {listings.map((listing) => (
        <div key={listing._id}>
          <h3>{listing.title}</h3>
          <p>{listing.description}</p>
          <button onClick={() => handleClaim(listing._id)}>Claim</button>
        </div>
      ))}
    </div>
  );
}

export default Listings;
