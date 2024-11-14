import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Map = () => {
  const [soupKitchens, setSoupKitchens] = useState([]);

  useEffect(() => {
    axios.get('http://localhost:5000/api/soup-kitchens')
      .then(response => {
        setSoupKitchens(response.data);
        initMap(response.data);
      })
      .catch(error => {
        console.error("There was an error fetching the soup kitchens!", error);
      });
  }, []);

  const initMap = (kitchens) => {
    const mapCenter = { lat: -25.7479, lng: 28.2293 }; // Default center for Pretoria
    const map = new window.google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: mapCenter,
    });

    kitchens.forEach(kitchen => {
      const location = { lat: parseFloat(kitchen.latitude), lng: parseFloat(kitchen.longitude) };
      new window.google.maps.Marker({
        position: location,
        map: map,
        title: kitchen.name,
      });
    });
  };

  return (
    <div className="map-container">
      <h1>Soup Kitchens</h1>
      <div id="map" style={{ height: '400px', width: '100%' }}></div>
    </div>
  );
};

export default Map;
