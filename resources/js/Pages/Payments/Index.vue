<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>Payments</SPageTitle>
            </div>
        </template>

        <div class="my-12">
            <DataTable
                :data="props.payments"
                :cols="cols"
                :actions="actions"
            />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import {SPageTitle} from "@placetopay/spartan-vue";

const props = defineProps({
    payments: {
        type: Object
    }
});

const cols = [
    "id",
    "reference",
    "name",
    "payer_document_type",
    "payer_document",
    "status",
    "actions"
];

const actions = {
    show:"payments.show",
}
</script>
