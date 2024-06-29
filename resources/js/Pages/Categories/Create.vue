<template>
    <!-- This is an example component -->
    <AuthenticatedLayout>
        <div class="my-8 max-w-md mx-auto p-8 bg-white rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Category</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" v-model="form.name" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="alias" class="block text-gray-700 text-sm font-bold mb-2">Alias</label>
                    <input type="text" id="alias" name="alias" v-model="form.alias" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-6">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea id="description" name="description" v-model="form.description" rows="4"
                              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                    Create
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const form = useForm({
    name: '',
    description: '',
    alias: ''
});

const submit = () => {
    form.post(route('categories.store'));
};
</script>
