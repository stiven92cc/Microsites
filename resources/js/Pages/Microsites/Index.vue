<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>Microsites</SPageTitle>
            </div>
        </template>

        <div v-if="can('microsites.create')" class="flex justify-end m-6">
            <Button
                :icon="PlusCircleIcon"
                :classes="'bg-orange-500 hover:bg-orange-400'"
                :route-name="'microsites.create'"
            >
                Create
            </Button>
        </div>

        <DataTable
            :data="props.microsites"
            :cols="cols"
            :actions="actions"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import {SPageTitle} from "@placetopay/spartan-vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {PlusCircleIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    microsites: {
        type: Array,
        required: false,
    }
})

const cols = [
    "name",
    "slug",
    "category_id",
    "type",
    "currency",
    "actions"
];

const actions = {
    edit:"microsites.edit",
    show:"microsites.show",
    destroy:"microsites.destroy",
    payment: "payment.form"
}
</script>
