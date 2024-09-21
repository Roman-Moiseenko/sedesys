<template>

    <InfoOrder :order="order" />

</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import InfoOrder from './Info/Show.vue'
const props = defineProps({
    order: Object,
})
</script>

<style scoped>

</style>
