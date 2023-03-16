<script>
export default {

  props: {
    letter: Object,
  },
};
</script>

<template>
      <div class="tile" :class="[letter !== undefined  && letter.status ? letter.status + ' has-status' : '', letter ? 'filled' : '']">
        <span>{{ letter !== undefined ? letter.letter : "" }}</span>
      </div>
</template>