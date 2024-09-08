<script>
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {SButton, SPageTitle} from "@placetopay/spartan-vue";

export default {
    name: "Import",
    components: { SButton, SPageTitle, AuthenticatedLayout },
    props: {
        microsites: Array,
    },
    data() {
        return {
            file: null,
            selectedMicrosite: null,
            error: '',
            success: ''
        };
    },
    methods: {
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        async importInvoices() {
            if (!this.file || !this.selectedMicrosite) {
                this.error = 'Por favor selecciona un archivo y un micrositio.';
                return;
            }

            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('microsite_id', this.selectedMicrosite); // Enviar el ID del micrositio

            try {
                await Inertia.post('/invoices/import', formData, {
                    onSuccess: () => {
                        this.success = 'Facturas importadas exitosamente';
                        this.error = '';
                    },
                    onError: (errors) => {
                        this.error = 'Error al importar facturas';
                        this.success = '';
                    }
                });
            } catch (err) {
                this.error = 'Ocurrió un error en el servidor.';
            }
        }
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>Invoices</SPageTitle>
            </div>
        </template>

        <div class="max-w-2xl mt-12 mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Importar Facturas</h2>

            <form @submit.prevent="importInvoices" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-gray-700">Selecciona un Micrositio:</label>
                    <select v-model="selectedMicrosite" class="mt-2 p-2 border border-gray-300 rounded-lg w-full" required>
                        <option v-for="microsite in microsites" :key="microsite.id" :value="microsite.id">
                            {{ microsite.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Selecciona un archivo Excel:</label>
                    <input
                        type="file"
                        class="mt-2 p-2 border border-gray-300 rounded-lg w-full"
                        @change="handleFileUpload"
                        accept=".xlsx, .xls"
                        required
                    />
                </div>

                <div class="text-right">
                    <SButton
                        class="w-full my-6"
                        type="submit"
                    >
                        Importar
                    </SButton>
                </div>
            </form>

            <div v-if="error" class="mt-4 text-red-500">
                {{ error }}
            </div>

            <div v-if="success" class="mt-4 text-green-500">
                {{ success }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<style scoped>

</style>
