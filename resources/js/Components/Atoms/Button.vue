<template>
    <button @click="navigate" class="bg-blue-700 text-white px-4 py-2 mx-24 rounded hover:bg-blue-800">
        {{ text }}
    </button>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    routeName: String,
    text: String
});

const navigate = () => {
    router.get(route(props.routeName));
};
</script>

<style scoped>
button {
    transition: background-color 0.3s ease;
}
</style>
