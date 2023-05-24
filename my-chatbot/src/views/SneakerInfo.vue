<template>
  <div>
    <img class="sneakers-image" :src="imageUrl" alt="Sneaker image">
    <br>
    <!-- <div>ID : {{ sneaker.id }} </div> -->
    <strong>{{ sneaker.product_name }} </strong>
    <div>Prix : {{ sneaker.price }} €</div>
    <div>Couleur : {{ sneaker.color }}</div>
    <div>Taille : {{ sneaker.size }}</div>
    <button class="add-to-cart" @click="$emit('add-to-cart', sneaker)">
      Ajouter au panier
    </button>
  </div>
  ---------------------------------------------------------
</template>

<script>
import { BASE_URL } from "../store/constants.js";
export default {
  props: {
    sneaker: {
      type: Object,
      required: true,
    },
  },
  computed: {
    imageUrl() {
      return BASE_URL + this.sneaker.image;
    }
  }
};
</script>
