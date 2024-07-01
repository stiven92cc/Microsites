<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Micrositios</h2>
            </div>
        </template>

        <div v-if="can('microsites.create')" class="flex justify-end w-full">
            <Button class="mx-8 my-2" routeName="microsites.create" text="Create" />
        </div>

        <DataTable :columns="columns" :rows="microsites" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import { h } from 'vue';
import { router } from '@inertiajs/vue3';
import {PencilIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";

defineProps({ microsites: Array });

const columns = [
    { key: 'id', label: '#' },
    { key: 'name', label: 'Name' },
    { key: 'slug', label: 'Slug' },
    { key: 'category_id', label: 'Category_id' },
    { key: 'type', label: 'Type' },
    { key: 'currency', label: 'Currency' },
    { key: 'payment_expiration', label: 'Payment_expiration' },
    {
        key: 'actions',
        label: 'Actions',
        formatter: (value, row) => ({
            render() {
                return h('div', {
                    class: 'flex'
                }, [
                    h(PencilIcon,{
                        onClick: () => router.get(`/microsites/${row.id}/edit`),
                        class: 'h-5 w-5 text-gray-400 hover:text-gray-800 mr-2 cursor-pointer',
                    }),
                    h(TrashIcon,{
                        onClick: () => router.delete(`/microsites/${row.id}`),
                        class: 'h-5 w-5 text-gray-400 hover:text-red-500 mr-2 cursor-pointer',
                    })
                ])
            }
        })
    },
    {
        key: 'actions',
        label: 'Actions',
        formatter: (value, row) => ({
            render() {
                return h('button', {
                    onClick: () => router.get(`/payment/${row.id}`),
                    class: 'text-blue-500 hover:text-blue-700'
                }, 'Ver formulario');
            }
        })
    }
];
</script>
