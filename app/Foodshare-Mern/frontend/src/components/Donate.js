import React, { useState } from 'react';
import API from '../services/api';

function Donate() {
  const [amount, setAmount] = useState('');
  const [description, setDescription] = useState('');

  const handleDonate = async (e) => {
    e.preventDefault();
    try {
      await API.post('/donations/donate', { amount, description });
      alert('Donation successful');
    } catch (err) {
      console.error(err);
      alert('Donation failed');
    }
  };

  return (
    <form onSubmit={handleDonate}>
      <h2>Donate</h2>
      <input type="number" placeholder="Amount" value={amount} onChange={(e) => setAmount(e.target.value)} />
      <input type="text" placeholder="Description" value={description} onChange={(e) => setDescription(e.target.value)} />
      <button type="submit">Donate</button>
    </form>
  );
}

export default Donate;
