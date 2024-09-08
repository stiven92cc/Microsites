
<script setup>

import { defineProps } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    subscriptionPlans: Array,
});
</script>

<template>
    <AuthenticatedLayout>
    <!-- Aquí utilizas los datos pasados desde el controlador -->
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                    {{$t(Subscription_Plan)}}
                </h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    {{}}
                </p>
            </div>
            <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                <!-- Recorre los planes de suscripción -->
                <div v-for="plan in subscriptionPlans" :key="plan.id" class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                    <h3 class="mb-4 text-2xl font-semibold">{{ plan.name }}</h3>
                    <div
                        v-for="(feature, i) in JSON.parse(plan.description)"
                        :key="i"
                        class="font-light text-gray-500 sm:text-lg dark:text-gray-400"
                    >
                        <span class="flex-shrink-0 rounded-2xl">{{ feature }}</span>
                    </div>
                    <div class="flex justify-center items-baseline my-8">
                        <span class="mr-2 text-5xl font-extrabold">${{ plan.amount }}</span>
                        <span class="text-gray-500 dark:text-gray-400">{{plan.subscription_period}}</span>
                    </div>
                    <!-- List of features, etc. -->
                    <a href="#" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white dark:focus:ring-primary-900">
                        Get started
                    </a>
                </div>
            </div>
        </div>
    </section>
        </AuthenticatedLayout>
</template>

<style scoped>
/* Tu CSS aquí */
</style>
