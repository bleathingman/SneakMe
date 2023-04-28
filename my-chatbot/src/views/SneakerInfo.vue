<template>
  <div>
    <div>Informations sur la sneaker {{ sneaker.product_name }} :</div>
    <br />
    <div>Prix : {{ sneaker.price }} €</div>
    <div>Couleur : {{ sneaker.color }}</div>
    <div>Taille : {{ sneaker.size }}</div>
    <button class="add-to-cart" @click="$emit('add-to-cart', sneaker.id)">
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
