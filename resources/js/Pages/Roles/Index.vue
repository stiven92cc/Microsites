<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>Roles</SPageTitle>
            </div>
        </template>

        <div v-if="can('roles.create')" class="flex justify-end m-6">
            <Button
                :icon="PlusCircleIcon"
                :classes="'bg-orange-500 hover:bg-orange-400'"
                :route-name="'roles.create'"
            >
                Create
            </Button>
        </div>

        <DataTable
            :cols="cols"
            :data="props.roles"
            :actions="actions"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {h} from "vue";
import {router} from "@inertiajs/vue3";
import {PencilIcon, PlusCircleIcon, TrashIcon} from "@heroicons/vue/24/outline/index.js";
import {SPageTitle} from "@placetopay/spartan-vue";

const props = defineProps({
    roles: {type: Object}
});

const cols = [
    "id",
    "name",
    "actions",
];

const actions = {
    edit:"roles.edit",
    destroy:"roles.destroy",
}
</script>
