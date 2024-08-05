<script setup>
const props = defineProps({
    message: {
        type: String
    }
})
</script>

<template>
    <p class="text-sm text-red-500">
        {{ message }}
    </p>
</template>
