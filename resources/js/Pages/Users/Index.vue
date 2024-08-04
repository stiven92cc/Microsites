<template>
    <AuthenticatedLayout>
        <template #header>
            <SPageTitle>Users</SPageTitle>
        </template>

        <div v-if="can('users.create')" class="flex justify-end m-6">
            <Button
                :icon="PlusCircleIcon"
                :classes="'bg-orange-500 hover:bg-orange-400'"
                :route-name="'users.create'"
            >
                Create
            </Button>
        </div>

    <DataTable
        :cols="cols"
        :data="props.users"
        :actions="actions"
    />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {SPageTitle} from "@placetopay/spartan-vue";
import {PlusCircleIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    users: {type: Object}
});

const cols = [
    "id",
    "name",
    "email",
    "actions",
];

const actions = {
    edit:"users.edit",
    destroy:"users.destroy",
}
</script>



