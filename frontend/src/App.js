import React, { useState, useEffect } from 'react';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/pets';

function App() {
  const [pets, setPets] = useState([]);
  const [editingPetId, setEditingPetId] = useState(null);
  const [newPet, setNewPet] = useState({
    name: '',
    status: '',
  });

  useEffect(() => {
    fetchPets();
  }, []);

  const fetchPets = async () => {
    try {
      const response = await axios.get(API_URL);
      setPets(response.data['data']);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setNewPet((prevPet) => ({
      ...prevPet,
      [name]: value,
    }));
  };

  const handleAddPet = async () => {
    try {
      if (editingPetId) {
        const response = await fetch(`${API_URL}/${editingPetId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newPet),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        setEditingPetId(null);
      } else {
        const response = await fetch(API_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(newPet),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
      }

      fetchPets();

      setNewPet({
        name: '',
        status: '',
      });
    } catch (error) {
      console.error('Error adding/editing pet:', error);
    }
  };

  const handleEditPet = (petId) => {
    const editingPet = pets.find(pet => pet.id === petId);

    setNewPet({
      name: editingPet.name,
      status: editingPet.status,
    });

    setEditingPetId(petId);
  };

  const handleDeletePet = async (petId) => {
    try {  
      const response = await axios.delete(`${API_URL}/${petId}`);
      fetchPets();
  
    } catch (error) {
      console.error('Error deleting pet:', error);
    }
  };

  return (
    <div>
      <h1>Lista Zwierząt</h1>
      {Array.isArray(pets) ? (
        <ul>
          {pets.map((pet) => (
            <li key={pet.id}>
              {pet.name} - {pet.status}
              <button onClick={() => handleEditPet(pet.id)}>Edytuj</button>
              <button onClick={() => handleDeletePet(pet.id)}>Usuń</button>
            </li>
          ))}
        </ul>
      ) : (
        <p>Dane nie są w formie tablicy.</p>
      )}

      <h2>Dodaj Nowego Zwierzaka</h2>
      <form>
        <label>
          Nazwa:
          <input type="text" name="name" value={newPet.name} onChange={handleInputChange} />
        </label>
        <br />
        <label>
          Status:
          <input type="text" name="status" value={newPet.status} onChange={handleInputChange} />
        </label>
        <br />
        <button type="button" onClick={handleAddPet}>
          Dodaj Zwierzaka
        </button>
      </form>
    </div>
  );
}

export default App;
