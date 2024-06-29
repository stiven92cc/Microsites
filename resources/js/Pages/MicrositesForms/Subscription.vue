<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    microsite: {
        type: Object,
        required: true,
    },
    documentTypes: {
        type: Array,
        required: true,
    }
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-0 sm:p-12">
        <div class="mx-auto max-w-3xl px-6 py-12 bg-white border-0 shadow-lg sm:rounded-3xl">
            <h1 class="text-2xl font-bold mb-8">{{ microsite.name }}</h1>
            <form id="form" novalidate>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="name"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="name" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Nombre</label>
                        <span class="text-sm text-red-600 hidden" id="error">Name is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="phone_number"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="phone_number" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Número de Teléfono</label>
                        <span class="text-sm text-red-600 hidden" id="error">Phone number is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <select
                            name="document_type"
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        >
                            <option value="" disabled selected hidden></option>
                            <option v-for="(value, key) in documentTypes" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </select>
                        <label for="document_type" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Tipo de Documento</label>
                        <span class="text-sm text-red-600 hidden" id="error">Document type is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="document"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="document" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Documento</label>
                        <span class="text-sm text-red-600 hidden" id="error">Document is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5 flex">
                        <input
                            type="number"
                            name="amount"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="amount" class="absolute duration-300 top-3 left-2 -z-1 origin-0 text-gray-500">Valor</label>
                        <span class="ml-2 mt-3 text-gray-500">{{ microsite.currency }}</span>
                        <span class="text-sm text-red-600 hidden" id="error">Amount is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="country"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="country" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">País</label>
                        <span class="text-sm text-red-600 hidden" id="error">Country is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="email"
                            name="email"
                            placeholder=" "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <label for="email" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500">Correo</label>
                        <span class="text-sm text-red-600 hidden" id="error">Email is required</span>
                    </div>
                </div>
                <button
                    id="button"
                    type="button"
                    class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-blue-500 hover:bg-blue-700 hover:shadow-lg focus:outline-none"
                >
                    Pagar
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Custom styles here */
</style>
