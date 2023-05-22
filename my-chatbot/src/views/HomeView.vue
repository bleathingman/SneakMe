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
          <li>
            <strong>help</strong> - Affiche la liste des commandes disponibles
          </li>
          <li><strong>bonjour</strong> - Salutation du chatbot</li>
          <li>
            <strong>liste sneakers</strong> - Affiche une liste de 5 sneakers
          </li>
          <li>
            <strong>sneaker info [product_name]</strong> - Affiche les
            informations d'une sneaker spécifique
          </li>
          <li>
            <strong>sneakers par taille [size]</strong> - Affiche les sneakers
            en fonction de leur taille
          </li>
        </ul>
      </div>
      <div class="chat-container">
        <div class="messages" ref="messagesContainer">
          <ul class="message-list">
            <li v-for="(message, index) in messages" :key="index" :class="message.sender">
              <bot-response v-if="message.sender === 'bot'" :type="message.type" :data="message.data"
                @add-to-cart="addToCart"></bot-response>
              <component :is="'div'" v-html="message.text" :class="message.sender" v-on="this.$listeners">
              </component>
              <sneaker-info v-if="message.sneaker" :sneaker="message.sneaker" @add-to-cart="addToCart"></sneaker-info>
              <!-- Ajoutez le bouton "Ajouter au panier" pour chaque sneaker -->
              <button v-if="message.sneakerId" @click="addToCart(message.sneakerId)" class="add-to-cart-btn">
                Ajouter au panier
              </button>
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
import api from '@/services/api';
import SneakerInfo from './SneakerInfo.vue';
import BotResponse from './BotResponse.vue';

export default {
  data() {
    return {
      userMessage: '',
      messages: [],
      showCart: false,
      cartProducts: [],
    };
  },
  methods: {
    async sendMessage() {
      // Vérifier si le message est vide
      if (this.userMessage.trim() === '') return;
      // Ajouter le message de l'utilisateur aux messages
      this.messages.push({ sender: 'user', text: this.userMessage });
      // Initialiser la réponse du bot
      let botResponse = '';
      // Vérifier si le message de l'utilisateur commence par "sneaker info"
      if (this.userMessage && typeof this.userMessage === 'string' && this.userMessage.toLowerCase().startsWith('sneaker info ')) {
        const productName = this.userMessage.substring('sneaker info '.length).trim();
        try {
          // Faire une requête à l'API pour obtenir les informations sur la sneaker
          const response = await api.getSneakerByName(productName);
          console.log('API response:', response);
          const sneaker = response.data.data;

          // Vérifier s'il n'y a pas d'erreur dans la réponse de l'API
          if (sneaker && !sneaker.error) {
            // Construire la réponse avec les informations de la sneaker
            botResponse = `<sneaker-info :sneaker="sneaker"></sneaker-info>`;
            this.messages.push({
              sender: 'bot',
              type: 'sneakerInfo',
              data: sneaker,
            });
          } else {
            // Répondre que la sneaker n'a pas été trouvée
            botResponse = `Désolé, aucune sneaker trouvée avec le nom "${productName}".`;
            this.messages.push({ sender: 'bot', text: botResponse });
          }
        } catch (error) {
          // Gérer les erreurs lors de la requête à l'API
          console.error('Error fetching sneaker info:', error);
          botResponse = "Désolé, une erreur s'est produite lors de la récupération des informations de la sneaker.";
          this.messages.push({ sender: 'bot', text: botResponse });
        }
      } else {
        // Gérer les autres commandes utilisateur
        switch (this.userMessage.toLowerCase()) {
          case 'help':
            botResponse =
              'Voici les commandes disponibles :\n- help\n- bonjour\n- liste sneakers\n- sneaker info [product_name]\n- ajouter au panier [product_name]';
            break;
          case 'bonjour':
            botResponse = 'Bonjour ! Comment puis-je vous aider ?';
            break;
          case 'liste sneakers':
            try {
              const response = await api.getSneakers();
              const sneakers = response.data;
              sneakers.forEach((sneaker, index) => {
                this.messages.push({
                  sender: 'bot',
                  text: `${index + 1}. ${sneaker.product_name} - ${sneaker.price
                    } €`,
                  imageUrl: sneaker.image_url,
                  sneakerId: sneaker.id, // Ajoutez l'ID de la sneaker pour pouvoir l'ajouter au panier
                });
              });
            } catch (error) {
              console.error('Error fetching sneakers:', error);
              botResponse =
                "Désolé, une erreur s'est produite lors de la récupération des sneakers.";
              this.messages.push({ sender: 'bot', text: botResponse });
            }
            break;
          default:
            botResponse =
              "Désolé, je ne comprends pas cette commande. Tapez 'help' pour voir la liste des commandes.";
        }
        // Ajouter la réponse du bot aux messages
        this.messages.push({ sender: 'bot', text: botResponse });
      }

      // Vider le champ de saisie du message utilisateur
      this.userMessage = '';

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
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.push(productId);
      localStorage.setItem('cart', JSON.stringify(cart));
      this.updateCartProducts();
    },
    updateCartProducts() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      this.cartProducts = cart.map((productId) => {
        return this.messages
          .filter(
            (message) =>
              message.sender === 'bot' && message.type === 'sneakerInfo'
          )
          .map((message) => message.data)
          .find((sneaker) => sneaker.id === productId);
      });
    },
  },
  mounted() {
    this.updateCartProducts();
  },
  components: {
    SneakerInfo,
    BotResponse,
  },
};
</script>
