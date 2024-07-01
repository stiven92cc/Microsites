<template>
    <AuthenticatedLayout>
        <div class="my-8 max-w-md mx-auto p-8 bg-white rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Usuarios</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" v-model="form.name" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="text" id="email" name="email" v-model="form.email" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select  v-model="form.role" name="role" id="role" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option
                            name="role"
                            v-for="role in props.roles"
                            :value="role.name"
                        >
                            {{role.name}}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" v-model="form.password" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" v-model="form.confirm_password" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
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

import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const form = useForm({
    name: '',
    email: '',
    role: '',
    password:'',
    confirm_password:'',
});

const props = defineProps({
    roles: {type:Object}
});


const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            console.log('Errores al enviar el formulario', form.errors);
        },
    });
};

</script>


