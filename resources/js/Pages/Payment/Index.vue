<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import { h } from 'vue';
import { router } from '@inertiajs/vue3';
import {EyeIcon} from "@heroicons/vue/24/outline/index.js";

defineProps({ payments: Array });

const columns = [
    { key: 'id', label: '#' },
    { key: 'reference', label: 'Reference' },
    {key: 'status', label: 'Status'},
    { key: 'payer_document', label: 'Payer_document' },
    { key: 'payer_document_type', label: 'Payer_document_type' },
    {key: 'payer_name', label: 'Payer_name'},

    {
        key: 'actions',
        label: 'Actions',
        formatter: (value, row) => ({
            render() {
                return h('div', {
                    class: 'flex'
                }, [

                    h(EyeIcon,{
                        onClick: () => router.get(`/payments/${row.id}`),
                        class: 'h-5 w-5 text-gray-400 hover:text-gray-800 mr-2 cursor-pointer',
                    })
                ])
            }
        })
    },
];
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payments</h2>
            </div>
        </template>
        <DataTable :columns="columns" :rows="payments" />
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
