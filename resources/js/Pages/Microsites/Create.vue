<template>
    <AuthenticatedLayout>
        <div class="my-8 max-w-md mx-auto p-8 bg-white rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Microsites</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" v-model="form.name" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="slug" class="block text-gray-700 text-sm font-bold mb-2">Slug</label>
                    <input type="text" id="slug" name="slug" v-model="form.slug" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipo de micrositio</label>
                    <select id="type" name="type" v-model="form.type"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option disabled value="">Seleccione una</option>
                        <option v-for="(value, key) in types" :key="key" :value="value">
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Categoria</label>
                    <select id="category_id" name="category_id" v-model="form.category_id"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option disabled value="">Seleccione una</option>
                        <option v-for="(value, key) in categories" :key="key" :value="key">
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Currency</label>
                    <select id="currency" name="currency" v-model="form.currency"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option disabled value="">Seleccione una</option>
                        <option v-for="(value, key) in currencies" :key="key" :value="value">
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="payment_expiration" class="block text-gray-700 text-sm font-bold mb-2">Payment_expiration</label>
                    <input type="number" min="3" id="payment_expiration" name="payment_expiration" v-model="form.payment_expiration" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                    <input type="file" id="logo" name="logo" @change="onSelectLogo" accept="image/*"
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>

                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                    Create
                </button>
            </form>
            <p v-if="successMessage" class="mt-4 text-green-500">{{ successMessage }}</p>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps } from 'vue';

const props = defineProps({
    currencies: Array,
    categories: Array,
    types: Array
});

const form = useForm({
    name: '',
    slug: '',
    category_id: '',
    type: '',
    currency: '',
    payment_expiration: '',
    logo: null
});

const onSelectLogo = (e) => {
    const files = e.target.files
    if(files.length){
        console.log(files)
        form.logo = files[0]
        console.log(form)

    }
}

const page = usePage();
const successMessage = ref('');

watch(page, () => {
    successMessage.value = page.props.flash.success || '';
});

const submit = () => {
    form.post(route('microsites.store'), {
        onSuccess: () => {
            successMessage.value = 'Microsite creado exitosamente';
        },
        onError: () => {
            console.log('Errores al enviar el formulario', form.errors);
        },
    });
};
</script>
