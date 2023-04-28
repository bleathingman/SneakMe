import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8080/api/',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

// récupère 5 sneakers / produits
async function getSneakers() {
  const response = await apiClient.get('/getSneakers.php');
  return response;
}

// récupère les sneakers par le product_name
async function getSneakerByName(productName) {
  const response = await apiClient.get(
    `/getSneakerByName.php?product_name=${productName}`
  );
  return response;
}

// récupère les sneakers par leur taille
async function getSneakersBySize(size) {
  const response = await apiClient.post('/getSneakersBySize.php', { size });
  return response;
}

export default {
  getProductsByCritere(critere, value) {
    return apiClient.get(`/api.php?critere=${critere}&value=${value}`);
  },
  getSneakers,
  getSneakerByName,
  getSneakersBySize,
};
