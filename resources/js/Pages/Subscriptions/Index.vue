<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>{{ $t('modules.subscriptions') }}</SPageTitle>
            </div>
        </template>

        <div class="my-12">
            <DataTable
                :data="props.subscriptions"
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
    subscriptions: {
        type: Object
    }
});

const cols = [
    "id",
    "payer_email",
    "plan_frencuency",
    "validUntil",
    "status",
    "actions",
];

const actions = {
    cancel:"subscription.cancel",
    show:"subscriptions.show",
}
</script>
