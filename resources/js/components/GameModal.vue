<script>
export default {
    props: {
        active: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<template>
     <div class="modal" :class="active ? 'is-active' : '' ">
        <div class="modal-background"></div>
        <div class="modal-content">
            <slot></slot>
        </div>
        <button class="modal-close is-large" aria-label="close" @click="$emit('closed')"></button>
     </div>
</template>