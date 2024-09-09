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
        type: String,
        required: true
    },
    text: {
        type: String,
        default: ''
    },
    icon: {
        type: Function,
        default: null
    },
    iconPosition: {
        type: String,
        default: 'right',
        validator: value => ['left', 'right'].includes(value)
    },
    classes: {
        type: String,
        default: ''
    },
    param: {
        type: [String, Number, null],
        default: null
    }
});

const navigate = () => {
    const fullRoute = props.param ? route(props.routeName, props.param) : route(props.routeName);
    router.get(fullRoute);
};
</script>

<style scoped>
button {
    transition: background-color 0.3s ease;
}
</style>
