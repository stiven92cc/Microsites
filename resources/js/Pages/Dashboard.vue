<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import {route} from "ziggy-js";
import {usePage} from "@inertiajs/vue3";


const goToIndex = () => {
    Inertia.get(route('categories.index'));
};

const goToCreate = () => {
    Inertia.get(route('categories.create'));
};

const page = usePage();
const user = page.props;

</script>

<template>

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center text-xl">
                        <span class="text-gray-900">
                            Welcome to microsites,
                        </span>
                        <span class="text-orange-500">
                            {{ user.auth.user.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

