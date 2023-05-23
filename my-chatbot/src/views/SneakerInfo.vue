<template>
  <div>
    <div>ID : {{ sneaker.id }} </div>
    <div>Prix : {{ sneaker.price }} €</div>
    <div>Couleur : {{ sneaker.color }}</div>
    <div>Taille : {{ sneaker.size }}</div>
    <button class="add-to-cart" @click="$emit('add-to-cart', sneaker)">
      Ajouter au panier
    </button>
  </div>
</template>

<script>
export default {
  props: {
    sneaker: {
      type: Object,
      required: true,
    },
  },
};
</script>
