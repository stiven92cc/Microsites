<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>{{$t('Invoices')}}</SPageTitle>
            </div>
        </template>

        <div v-if="can('microsites.create')" class="flex justify-end m-6">
            <Button
                :icon="PlusCircleIcon"
                :classes="'bg-orange-500 hover:bg-orange-400'"
                :route-name="'import.form'"
            >
                {{ $t('common.import') }}
            </Button>
        </div>

        <DataTable
            class="mt-12"
            :data="props.invoices"
            :cols="cols"
            :actions="actions"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { useI18n } from 'vue-i18n';
import {SPageTitle} from "@placetopay/spartan-vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {PlusCircleIcon} from "@heroicons/vue/24/outline/index.js";

const { t } = useI18n();

const props = defineProps({
    invoices: {
        type: Array,
        required: false,
    },
    canPay: {
        type: Boolean
    }
})

const baseCols = [
    "reference",
    "email",
    "currency",
    "status",
    "amount",
    "document_type",
    "document",
    "expired_at",
];

const cols = props.canPay ? [...baseCols, "actions"] : baseCols;

const actions = props.canPay ? { pay: "payment.pay.invoice" } : {};
</script>
