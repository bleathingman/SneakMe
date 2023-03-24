import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost/api/',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
});

// recupère 5 sneakers / produits
async function getSneakers() {
    const response = await apiClient.get('http://localhost/test_44/requetes/getSneakers.php');
    return response;
}

// récupère les sneakers par le product_name
async function getSneakerByName(productName) {
    const response = await axios.get(`http://localhost/test_44/requetes/getSneakerByName.php?product_name=${productName}`);
    return response;
}



export default {
    getProductsByCritere(critere, value) {
        return apiClient.get(`/products?${critere}=${value}`);
    },
    getSneakers, getSneakerByName,
};
