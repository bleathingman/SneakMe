<template>
  <div>
    <sneaker-info
      v-if="type === 'sneakerInfo'"
      :sneaker="data"
      @add-to-cart="$emit('add-to-cart', $event)"
    ></sneaker-info>
    <div v-else-if="type === 'sneaker'">
      <button @click="$emit('add-to-cart', data.id)">Ajouter au panier</button>
    </div>
    <div v-else v-html="data"></div>
  </div>
</template>

<script>
import SneakerInfo from './SneakerInfo.vue';

export default {
  props: {
    type: {
      type: String,
      required: true,
    },
    data: {
      type: [String, Object],
      required: true,
    },
  },
  components: {
    SneakerInfo,
  },
};
</script>
