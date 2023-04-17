<template>
	<div class="home">
		<button @click="showCart = true">Afficher le panier</button>
		<div v-if="showCart" class="cart-popup">
			<button @click="showCart = false">Fermer</button>
			<ul>
				<li v-for="product in cartProducts" :key="product.id">
					{{ product.product_name }}
				</li>
			</ul>
		</div>
		<div class="content-wrapper">
			<div class="commands-list">
				<h3>Commandes disponibles :</h3>
				<ul class="commandes-dispo">
					<li><strong>help</strong> - Affiche la liste des commandes disponibles</li>
					<li><strong>bonjour</strong> - Salutation du chatbot</li>
					<li><strong>liste sneakers</strong> - Affiche une liste de 5 sneakers</li>
					<li><strong>sneaker info [product_name]</strong> - Affiche les informations d'une sneaker spécifique
					</li>
					<li><strong>sneakers par taille [size]</strong> - Affiche les sneakers en fonction de leur taille</li>
				</ul>
			</div>
			<div class="chat-container">
				<div class="messages" ref="messagesContainer">
					<ul class="message-list">
						<li v-for="(message, index) in messages" :key="index" :class="message.sender">
							<component :is="'div'" v-html="message.text" :class="message.sender" v-on="this.$listeners">
							</component>
							<img v-if="message.imageUrl" :src="message.imageUrl" alt="Sneaker image"
								class="sneaker-image" />
							<div class="message-time">{{ message.timestamp }}</div>
						</li>
					</ul>
				</div>
				<div class="input-container">
					<input type="text" v-model="userMessage" @keyup.enter="sendMessage" />
					<button @click="sendMessage">Envoyer</button>
				</div>
			</div>
		</div>
	</div>
</template>
  
  
<script>
import api from "@/services/api";

export default {
	data() {
		return {
			userMessage: "",
			messages: [],
			showCart: false,
			cartProducts: [],
		};
	},
	methods: {
		async sendMessage() {
			// Vérifier si le message est vide
			if (this.userMessage.trim() === "") return;

			// Ajouter le message de l'utilisateur aux messages
			this.messages.push({ sender: "user", text: this.userMessage });

			// Initialiser la réponse du bot
			let botResponse = "";

			// Vérifier si le message de l'utilisateur commence par "sneaker info"
			if (this.userMessage.toLowerCase().startsWith("sneaker info")) {
				const productName = this.userMessage.substring("sneaker info".length).trim();
				try {
					// Faire une requête à l'API pour obtenir les informations sur la sneaker
					const response = await api.getSneakerByName(productName);
					console.log("API response:", response);
					const sneaker = response.data.data;

					// Vérifier s'il n'y a pas d'erreur dans la réponse de l'API
					if (!sneaker.error) {
						// Construire la réponse avec les informations de la sneaker
						botResponse = `
							<div>Informations sur la sneaker ${sneaker.product_name} :</div>
							<br/>
							<div>Prix : ${sneaker.price} €</div>
							<div>Couleur : ${sneaker.color}</div>
							<div>Taille : ${sneaker.size}</div>
							<button class="add-to-cart" @click="addToCart(${sneaker.id})">Ajouter au panier</button>
						`;
						const imageUrl = sneaker.image_url;
						this.messages.push({ sender: "bot", text: botResponse, imageUrl: imageUrl });
					} else {
						// Répondre que la sneaker n'a pas été trouvée
						botResponse = `Désolé, aucune sneaker trouvée avec le nom "${productName}".`;
						this.messages.push({ sender: "bot", text: botResponse });
					}
				} catch (error) {
					// Gérer les erreurs lors de la requête à l'API
					console.error("Error fetching sneaker info:", error);
					botResponse = "Désolé, une erreur s'est produite lors de la récupération des informations de la sneaker.";
					this.messages.push({ sender: "bot", text: botResponse });
				}
			} else {
				// Gérer les autres commandes utilisateur
				switch (this.userMessage.toLowerCase()) {
					case "help":
						botResponse =
							"Voici les commandes disponibles :\n- help\n- bonjour\n- liste sneakers\n- sneaker info [product_name]";
						break;
					case "bonjour":
						botResponse = "Bonjour ! Comment puis-je vous aider ?";
						break;
					case "liste sneakers":
						try {
							const response = await api.getSneakers();
							const sneakers = response.data;
							botResponse = "Voici une liste de 5 sneakers :\n\n";
							sneakers.forEach((sneaker, index) => {
								botResponse += `${index + 1}. ${sneaker.product_name} - ${sneaker.price} €\n`;
							});
						} catch (error) {
							console.error("Error fetching sneakers:", error);
							botResponse = "Désolé, une erreur s'est produite lors de la récupération des sneakers.";
						}
						break;
					default:
						botResponse = "Désolé, je ne comprends pas cette commande. Tapez 'help' pour voir la liste des commandes.";
				}
				// Ajouter la réponse du bot aux messages
				this.messages.push({ sender: "bot", text: botResponse });
			}

			// Vider le champ de saisie du message utilisateur
			this.userMessage = "";

			// Faire défiler vers le bas pour afficher le dernier message
			this.$nextTick(() => {
				this.scrollToBottom();
			});
		},
		scrollToBottom() {
			const container = this.$refs.messagesContainer;
			container.scrollTop = container.scrollHeight;
		},
		// Ajout au panier d'un produit
		addToCart(productId) {
			let cart = JSON.parse(localStorage.getItem("cart")) || [];
			if (!cart.includes(productId)) {
				cart.push(productId);
				localStorage.setItem("cart", JSON.stringify(cart));
				alert("Le produit a été ajouté au panier.");
			} else {
				alert("Le produit est déjà dans le panier.");
			}
		},
		// Récupérer les Produits qui sont ajouter dans le panier
		async getCartProducts() {
			const cart = JSON.parse(localStorage.getItem("cart")) || [];
			const products = [];
			for (const productId of cart) {
				try {
					const response = await api.getSneakerById(productId);
					products.push(response.data.data);
				} catch (error) {
					console.error("Error fetching sneaker info:", error);
				}
			}
			this.cartProducts = products;
		},
	},
	watch: {
		showCart(newVal) {
			if (newVal) {
				this.getCartProducts();
			}
		},
	},
};
</script>

