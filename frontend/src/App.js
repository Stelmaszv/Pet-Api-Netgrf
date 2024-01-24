import React, { useState, useEffect } from 'react';
import { Alert } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/pets';

function App() {
  const [pets, setPets] = useState([]);
  const [editingPetId, setEditingPetId] = useState(null);
  const [newPet, setNewPet] = useState({
    name: '',
    status: ''
  });
  const [showAlert, setShowAlert] = useState(false);

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
      if (!newPet.name || !newPet.status) {
        setShowAlert(true);
        return;
      }

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

      setShowAlert(false);
    } catch (error) {
      console.error('Error adding/editing pet:', error);
    }
  };

  const handleEditPet = (petId) => {
    const editingPet = pets.find((pet) => pet.id === petId);

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
    <div className="container mt-4">
      <h1>Lista Zwierząt</h1>
      {Array.isArray(pets) ? (
        <ul className="list-group">
          {pets.map((pet) => (
            <li key={pet.id} className="list-group-item">
              {pet.name} - {pet.status}
              <button
                className="btn btn-info ms-2"
                onClick={() => handleEditPet(pet.id)}
              >
                Edytuj
              </button>
              <button
                className="btn btn-danger ms-2"
                onClick={() => handleDeletePet(pet.id)}
              >
                Usuń
              </button>
            </li>
          ))}
        </ul>
      ) : (
        <p>Dane nie są w formie tablicy.</p>
      )}

      <h2>
        {editingPetId
          ? `Edytuj Zwierzaka: ${newPet.name}`
          : 'Dodaj Nowego Zwierzaka'}
      </h2>
      <form>
        <div className="mb-3">
          <label className="form-label">Nazwa:</label>
          <input
            type="text"
            className="form-control"
            name="name"
            value={newPet.name}
            onChange={handleInputChange}
          />
        </div>
        <div className="mb-3">
          <label className="form-label">Status:</label>
          <select
            className="form-select"
            name="status"
            value={newPet.status}
            onChange={handleInputChange}
          >
            <option value="aktywne">Aktywne</option>
            <option value="realizowane">Realizowane</option>
            <option value="w trakcie">W trakcie</option>
          </select>
        </div>
        {showAlert && (
          <div className="alert alert-danger" role="alert">
            Proszę wypełnić wszystkie pola (Nazwa i Status)!
          </div>
        )}
        <button
          type="button"
          className="btn btn-primary"
          onClick={handleAddPet}
        >
          {editingPetId ? 'Edytuj Zwierzaka' : 'Dodaj Zwierzaka'}
        </button>
      </form>
    </div>
  );
}

export default App;
