<template>
    <button @click="navigate" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
        {{ text }}
    </button>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';

const props = defineProps({
    routeName: String,
    text: String
});

const navigate = () => {
    Inertia.visit(route(props.routeName));
};
</script>

<style scoped>
button {
    transition: background-color 0.3s ease;
}
</style>
