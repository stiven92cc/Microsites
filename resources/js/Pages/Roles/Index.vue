<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>
            </div>
        </template>

        <div class="flex justify-end w-full">
            <Button class="mx-8 my-2" routeName="roles.create" text="Create" />
        </div>

        <DataTable :columns="columns" :rows="props.roles"/>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {h} from "vue";
import {router} from "@inertiajs/vue3";
import {PencilIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    roles: {type: Object}
})

const columns = [
    { key: 'id', label: '#' },
    { key: 'name', label: 'Name' },
    {
        key: 'actions',
        label: 'Actions',
        formatter: (value, row) => ({
            render() {
                return h('div', {
                    class: 'flex'
                }, [
                    h(PencilIcon,{
                        onClick: () => router.get(`/roles/${row.id}/edit`),
                        class: 'h-5 w-5 text-gray-400 hover:text-gray-800 mr-2 cursor-pointer',
                    }),
                    h(TrashIcon,{
                        onClick: () => router.delete(`/roles/${row.id}`),
                        class: 'h-5 w-5 text-gray-400 hover:text-red-500 mr-2 cursor-pointer',
                    })
                ])
            }
        })
    },

];
</script>
