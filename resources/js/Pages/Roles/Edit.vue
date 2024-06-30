<template>
    <AuthenticatedLayout>
        <div class="my-8 max-w-md mx-auto p-8 bg-white rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">Roles</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" v-model="form.name" required
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>


                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                    Edit
                </button>
            </form>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {defineProps} from "vue";
import {useForm} from "@inertiajs/vue3";


const props = defineProps({
    roles: Object
});

console.log(props.roles)

const form = useForm({
    name: props.roles.name,
});

const submit = () => {
    form.patch(route('roles.update', props.roles.id));
};

</script>
