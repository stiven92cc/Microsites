<script setup>
import { defineProps } from 'vue';
import {useForm} from "@inertiajs/vue3";

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

const form = useForm({
    payer_name: '',
    payer_document_type:'',
    payer_document:'',
    amount: '',
    payer_email:'',
});

const submit = () => {
    form.post(route('payment.pay', props.microsite.id), {
        onSuccess: () => {
            successMessage.value = 'Pago exitosamente';
        },
        onError: () => {
            console.log('Error al pagar', form.errors);
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-0 sm:p-12">
        <div class="mx-auto max-w-3xl px-6 py-12 bg-white border-0 shadow-lg sm:rounded-3xl">
            <h1 class="text-2xl font-bold mb-8">{{ microsite.name }}</h1>
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="name"
                            placeholder="Nombre "
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                            v-model="form.payer_name"
                        />
                        <span class="text-sm text-red-600 hidden" id="error">Name is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="phone_number"
                            placeholder="Número de Teléfono"
                            v-model="form.phone_number"
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <span class="text-sm text-red-600 hidden" id="error">Phone number is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <select
                            name="document_type"
                            required
                            v-model="form.payer_document_type"
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        >
                            <option value="" disabled selected hidden></option>
                            <option v-for="(value, key) in documentTypes" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </select>
                        <span class="text-sm text-red-600 hidden" id="error">Document type is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="text"
                            name="document"
                            placeholder="Documento"
                            v-model="form.payer_document"
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <span class="text-sm text-red-600 hidden" id="error">Document is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5 flex">
                        <input
                            type="number"
                            name="amount"
                            placeholder="Valor"
                            v-model="form.amount"
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <span class="ml-2 mt-3 text-gray-500">{{ microsite.currency }}</span>
                        <span class="text-sm text-red-600 hidden" id="error">Amount is required</span>
                    </div>

                    <div class="relative z-0 w-full mb-5">
                        <input
                            type="email"
                            name="email"
                            placeholder="Correo"
                            v-model="form.payer_email"
                            required
                            class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                        />
                        <span class="text-sm text-red-600 hidden" id="error">Email is required</span>
                    </div>
                </div>
                <button
                    id="button"
                    type="submit"
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
