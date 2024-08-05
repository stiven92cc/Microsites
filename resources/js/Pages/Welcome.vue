<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import {route} from "ziggy-js";

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    microsites: {
        type: Array,
        required: true,
    },
    search: String,
});

const searchQuery = ref(props.search || '');

const searchMicrosites = () => {
    Inertia.get('/', {search: searchQuery.value});
};

</script>

<template>
    <Head title="Welcome"/>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="w-full">
                <main>
                    <header class="bg-white dark:bg-gray-900">
                        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                            <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </Link>

                                <template v-else>
                                    <Link
                                        :href="route('login')"
                                        class="rounded-md px-3 py-2 mt-5 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </Link>

                                    <Link
                                        v-if="canRegister"
                                        :href="route('register')"
                                        class="rounded-md px-3 py-2 mt-5 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Register
                                    </Link>
                                </template>
                            </nav>
                        </div>
                        <div class="container mx-auto px-6 py-2 pt-28 text-center">
                            <div class="mx-auto max-w-lg">
                                <h1 class="text-3xl font-bold text-gray-800 dark:text-white md:text-4xl">
                                    Micrositios</h1>

                                <div
                                    class="mx-auto mt-6 w-full max-w-sm rounded-md border bg-transparent focus-within:border-blue-400 focus-within:ring focus-within:ring-blue-300 focus-within:ring-opacity-40 dark:border-gray-700 dark:focus-within:border-blue-300">
                                    <form @submit.prevent="searchMicrosites" class="flex flex-col md:flex-row">
                                        <input v-model="searchQuery" type="text" placeholder="Buscar micrositio"
                                               class="m-1 h-10 flex-1 appearance-none border-none bg-transparent px-4 py-2 text-gray-700 placeholder-gray-400 focus:placeholder-transparent focus:outline-none focus:ring-0 dark:text-gray-200"/>
                                        <button type="submit"
                                                class="m-1 h-10 transform rounded-md bg-blue-500 px-4 py-2 text-white transition-colors duration-300 hover:bg-blue-400 focus:bg-blue-400 focus:outline-none">
                                            Buscar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </header>

                    <section class="bg-white dark:bg-gray-900">
                        <div class="container mx-auto px-6 pt-6">
                            <div class="mt-8 grid grid-cols-1 gap-8 md:grid-cols-2 xl:mt-16 xl:grid-cols-4">
                                <div v-for="microsite in microsites" :key="microsite.id"
                                     class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    <Link :href="route('payment.form', microsite.id)">
                                        <div
                                            class="group flex transform cursor-pointer flex-col items-center rounded-xl p-8 transition-colors duration-300 hover:bg-blue-600 border-2 border-gray-300 bg-gray-50">
                                            <img class="h-32 w-32 rounded-full object-cover ring-4 ring-gray-300"
                                                 :src="microsite.logo ? `/storage/${microsite.logo}` : 'https://www.palomacornejo.com/wp-content/uploads/2021/08/no-image.jpg'"
                                                 alt="logo del micrositio"/>

                                            <h1 class="text-center mt-4 text-2xl font-semibold capitalize text-gray-700 group-hover:text-white dark:text-white">
                                                {{ microsite.name }}</h1>
                                            <p class="mt-2 capitalize text-gray-500 group-hover:text-gray-300 dark:text-gray-300">
                                                {{ microsite.category.name }}</p>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </section>

                    <footer class="bg-white dark:bg-gray-900">
                        <div class="container mx-auto px-6 py-20">
                            <hr class="my-6 border-gray-200 dark:border-gray-700 md:my-8"/>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-2xl font-bold text-gray-800 transition-colors duration-300 hover:text-gray-700 dark:text-white dark:hover:text-gray-300">Stiven Castrillon Ciro</span>
                                <div class="-mx-2 flex">
                                    <a href="https://github.com/stiven92cc"
                                       class="mx-2 text-gray-600 transition-colors duration-300 hover:text-blue-500 dark:text-gray-300 dark:hover:text-blue-400"
                                       aria-label="Github">
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
