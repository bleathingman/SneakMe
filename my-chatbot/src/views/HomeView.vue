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
              <div v-else v-html="message.text"></div>
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
            <img :src="imageUrl(product)" alt="Image of the product" class="sneakers-image">
            <br>
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
import { BASE_URL } from "../store/constants.js";
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
    this.loadCommands();
  },
  methods: {
    async loadCommands() {
      try {
        const response = await api.getCommands();
        if (response.data.length > 0) {
          this.commands = response.data;
        } else {
          console.log('Aucune commande disponible.');
        }
      } catch (error) {
        console.error('Erreur lors de la récupération des commandes :', error);
      }
    },
    async sendMessage() {
      if (this.userMessage.trim() === '') return;

      this.messages.push({ sender: 'user', text: this.userMessage });

      let botResponse = '';

      if (this.userMessage.toLowerCase() === 'liste sneakers') {
        try {
          const response = await api.getSneakers();
          if (response.data.length > 0) {
            response.data.forEach((sneaker, index) => {
              this.messages.push({
                sender: 'bot',
                text: `${index + 1}. ${sneaker.product_name}`,
                sneakerId: sneaker.id,
                sneaker: sneaker
              });
            });
          } else {
            this.messages.push({ sender: 'bot', text: 'Désolé, il n\'y a actuellement aucune sneaker disponible.' });
          }
        } catch (error) {
          console.error('Error fetching sneakers:', error);
          botResponse = "Désolé, une erreur s'est produite lors de la récupération des sneakers.";
        }
      } else if (this.userMessage.toLowerCase().startsWith('sneaker info ')) {
        let sneakerName = this.userMessage.toLowerCase().replace('sneaker info ', '');
        try {
          const response = await api.getSneakerByName(sneakerName);
          if (response.data.error) {
            this.messages.push({ sender: 'bot', text: response.data.error });
          } else {
            this.messages.push({ sender: 'bot', sneaker: response.data });
          }
        } catch (error) {
          console.error('Erreur lors de la récupération de la sneaker:', error);
          botResponse = "Désolé, une erreur s'est produite lors de la récupération de la sneaker.";
        }
      } else if (this.userMessage.toLowerCase().startsWith('ajouter au panier ')) {
        let sneakerName = this.userMessage.toLowerCase().replace('ajouter au panier ', '');
        try {
          const sneakerInfoResponse = await api.getSneakerByName(sneakerName);
          if (sneakerInfoResponse.data.error) {
            botResponse = sneakerInfoResponse.data.error;
          } else {
            this.addToCart(sneakerInfoResponse.data);
            botResponse = `Le produit ${sneakerName} a été ajouté à votre panier.`;
          }
        } catch (error) {
          console.error('Erreur lors de l\'ajout de la sneaker au panier:', error);
          botResponse = "Désolé, une erreur s'est produite lors de l'ajout de la sneaker au panier.";
        }
      } else {
        try {
          const commandResponse = await api.getChatBotCommand(this.userMessage.toLowerCase());
          botResponse = commandResponse.data;
        } catch (error) {
          console.error('Error fetching command:', error);
          botResponse = "Désolé, une erreur s'est produite lors de la récupération de la commande.";
        }
      }
      if (botResponse) {
        this.messages.push({ sender: 'bot', text: botResponse });
      }
      // rend vide la zone de text
      this.userMessage = '';
      // permet de voir toujours le dernier message
      this.$nextTick(() => {
        this.scrollToBottom();
      });
    },
    scrollToBottom() {
      const container = this.$refs.messagesContainer;
      container.scrollTop = container.scrollHeight;
    },
    addToCart(product) {
      this.cart.push(product);
      alert(`Produit ajouté au panier : ${product.product_name}`);
      console.log(this.cart);
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
    },
    imageUrl() {
      return product => {
        return BASE_URL + product.image;
      };
    },
  },
  components: {
    SneakerInfo,
    BotResponse,
  },
};
</script>
s
