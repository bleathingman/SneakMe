<template>
  <div class="home">
    <div class="content-wrapper">
      <div class="commands-list">
        <h3>Commandes disponibles :</h3>
        <ul class="commandes-dispo">
          <li class="commands-in-list" v-for="command in commands" :key="command.bot_message">
            <strong>{{ command.bot_message }}</strong> - {{ command.description }}
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
            </li>
          </ul>
        </div>
        <div class="input-container">
          <input type="text" v-model="userMessage" @keyup.enter="sendMessage" />
          <button class="button-send" @click="sendMessage">Envoyer</button>
        </div>
      </div>
      <div class="cart-list">
        <h3>Mon panier :</h3>
        <h4>Total : {{ totalAmount.toFixed(2) }} €</h4>
        <ul class="cart-dispo">
          <li class="sneaker-in-cart" v-for="(product, index) in cartProducts" :key="product.id">
            <strong>{{ product.product_name }}</strong> - {{ product.price }} €
            <button @click="removeFromCart(index)">X</button>
          </li>
        </ul>
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
      cart: [],
      commands: [],
    };
  },
  async created() {
    // Charger les commandes quand le composant est créé
    this.loadCommands();
  },
  methods: {
    async loadCommands() {
      try {
        const response = await api.getCommands();
        // Vérifiez si la réponse contient des commandes
        if (response.data.length > 0) {
          this.commands = response.data; // Utilisez directement le tableau retourné par l'API
        } else {
          console.log('Aucune commande disponible.');
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des commandes :', error);
      }
    },
    async sendMessage() {
      // Vérifier si le message est vide
      if (this.userMessage.trim() === '') return;
      // Ajouter le message de l'utilisateur aux messages
      this.messages.push({ sender: 'user', text: this.userMessage });
      // Initialiser la réponse du bot
      let botResponse = '';
      // Gérer les commandes utilisateur
      switch (this.userMessage.toLowerCase()) {
        case 'liste sneakers':
          try {
            const response = await api.getSneakers();
            // Vérifier si la réponse contient des sneakers
            if (response.data.length > 0) {
              response.data.forEach((sneaker, index) => {
                this.messages.push({
                  sender: 'bot',
                  text: `${index + 1}. ${sneaker.product_name}`,
                  sneakerId: sneaker.id, // Ajoutez cette ligne si vous avez un id pour chaque sneaker
                  sneaker: sneaker // Si vous voulez passer l'objet sneaker complet
                });
              });
            } else {
              this.messages.push({ sender: 'bot', text: 'Désolé, il n\'y a actuellement aucune sneaker disponible.' });
            }
          } catch (error) {
            console.error('Error fetching sneakers:', error);
            botResponse = "Désolé, une erreur s'est produite lors de la récupération des sneakers.";
          }
          break;
        default:
          try {
            const commandResponse = await api.getChatBotCommand(this.userMessage.toLowerCase());
            botResponse = commandResponse.data;
          } catch (error) {
            console.error('Error fetching command:', error);
            botResponse = "Désolé, une erreur s'est produite lors de la récupération de la commande.";
          }
      }

      // Ajouter la réponse du bot aux messages
      this.messages.push({ sender: 'bot', text: botResponse });
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
    addToCart(product) {
      // Ajouter le produit au panier
      this.cart.push(product);
      // Afficher une notification de confirmation
      alert(`Produit ajouté au panier : ${product.product_name}`);
      console.log(this.cart); // Ajouter cette ligne
    },
    removeFromCart(index) {
      this.cart.splice(index, 1);
    },
  },
  computed: {
    cartProducts() {
      return this.cart;
    },
    totalAmount() {
      return this.cart.reduce((total, product) => {
        return total + parseFloat(product.price);
      }, 0);
    }
  },
  components: {
    SneakerInfo,
    BotResponse,
  },
};
</script>
