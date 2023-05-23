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
  console.log(productName);
  const response = await apiClient.get(
    `/getSneakersbyName.php?product_name=${encodeURIComponent(productName)}`
  );
  return response;
}

// récupère les sneakers par leur taille
async function getSneakersBySize(size) {
  const response = await getProductsByCritere('size', size);
  return response;
}

// Récupère des produits par un certain critère
async function getProductsByCritere(critere, value) {
  const response = await apiClient.get(
    `/api.php?critere=${critere}&value=${value}`
  );
  return response;
}

export default {
  getSneakers,
  getSneakerByName,
  getSneakersBySize,
};
