
<template>
	<div class="home">
		<div class="chat-container">
			<div class="messages" ref="messagesContainer">
				<ul class="message-list">
					<li v-for="(message, index) in messages" :key="index" :class="message.sender">
						<span v-html="message.text"></span>
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
</template>
  
<script>
import api from "@/services/api";

export default {
	data() {
		return {
			userMessage: "",
			messages: [],
		};
	},
	methods: {
		async sendMessage() {
			if (this.userMessage.trim() === "") return;

			this.messages.push({ sender: "user", text: this.userMessage });

			let botResponse = "";

			if (this.userMessage.toLowerCase().startsWith("sneaker info")) {
				const productName = this.userMessage.substring("sneaker info".length).trim();
				try {
					const response = await api.getSneakerByName(productName);
					const sneaker = response.data;
					console.log(sneaker)
					
					if (sneaker) {
						botResponse = `<div>Informations sur la sneaker ${sneaker.product_name} :</div><br/>
						<div>Prix : ${sneaker.price} €</div>
						<div>Couleur : ${sneaker.color}</div>
						<div>Taille : ${sneaker.size}</div>`;
					} else {
						botResponse = `Désolé, aucune sneaker trouvée avec le nom "${productName}".`;
					}
				} catch (error) {
					console.error("Error fetching sneaker info:", error);
					botResponse = "Désolé, une erreur s'est produite lors de la récupération des informations de la sneaker.";
				}
			} else {
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
			}

			this.messages.push({ sender: "bot", text: botResponse });
			this.userMessage = "";

			this.$nextTick(() => {
				this.scrollToBottom();
			});
		},
		scrollToBottom() {
			const container = this.$refs.messagesContainer;
			container.scrollTop = container.scrollHeight;
		},
	},
};
</script>

