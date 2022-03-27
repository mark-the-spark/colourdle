<script>
export default {
    props: {
       keystroke: String,
       state: String
    },

    data () {
        return {

        }
    }
}
</script>

<template>
    <button class="key" :class="state ? state : ''" @click="this.$emit('pressed', keystroke)"><span><slot></slot></span></button>
</template>

<style scoped>

.key {
    font-size: 16px;
    text-transform: uppercase;
    background-color: #D3D6DA;
    font-weight: bold;
    height: 50px;
    /* width: 38px; */

    display: float;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 4px;
    margin: 2px;
}

.correct {
    background-color: #6AA964;
    border: 2px solid #6AA964;
    color: white;
}

.incorrect {
    background-color: #787C7E;
    border: 2px solid #787C7E;
    color: white;
}

.present {
    background-color: #C8B458;
    border: 2px solid #C8B458;
    color: white;
}

.key:active {
    background-color: #787C7E;
}

.key span {
    margin-left: 4px;
    margin-right: 4px;
}

</style>