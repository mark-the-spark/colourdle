<script>
import TileComponent from "./TileComponent.vue";

export default {
  components: {
    tile: TileComponent,
  },

  props: {
    guess: Array,
  },
};
</script>

<template>
  <div class="flex tile-row">
    <tile :letter="guess[0]"></tile>
    <tile :letter="guess[1]"></tile>
    <tile :letter="guess[2]"></tile>
    <tile :letter="guess[3]"></tile>
    <tile :letter="guess[4]"></tile>
  </div>
</template>