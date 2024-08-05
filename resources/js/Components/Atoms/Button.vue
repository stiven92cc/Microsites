<template>
    <SButton
        @click="navigate"
        :class="classes"
        :right-icon="iconPosition === 'right' ? icon : null"
        :left-icon="iconPosition === 'left' ? icon : null"
    >
        <slot></slot>
    </SButton>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { SButton } from "@placetopay/spartan-vue";
import { route } from "ziggy-js";

const props = defineProps({
    routeName: {
        type: String
    },
    text: {
        type: String
    },
    icon: {
        type: Function
    },
    iconPosition: {
        type: String,
        default: 'right',
        validator: value => ['left', 'right'].includes(value)
    },
    classes: {
        type: String
    }
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
