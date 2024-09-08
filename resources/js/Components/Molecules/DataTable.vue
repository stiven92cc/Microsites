<template>
    <div class="mx-36">
        <STable>
            <STableHead>
                <STableRow>
                    <STableHeadCell v-for="col in cols" :key="col">{{ $t('common.' + col ) }}</STableHeadCell>
                </STableRow>
            </STableHead>

            <STableBody>
                <STableRow v-for="row in data" :key="row.id">
                    <STableCell v-for="col in cols" :key="col">
                        <template v-if="col === 'actions'">
                            <div class="flex items-center space-x-1">
                                <Link v-for="action in Object.keys(actions)" :key="action" :href="route(actions[action], { id: row.id })" :method="getMethod(action)">
                                    <component :is="getIcon(action)" class="w-5 hover:text-orange-500" />
                                </Link>
                            </div>
                        </template>
                        <template v-else>
                            {{ translateValue(row[col]) }}
                        </template>
                    </STableCell>
                </STableRow>
            </STableBody>
        </STable>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { STable, STableBody, STableCell, STableHead, STableHeadCell, STableRow } from "@placetopay/spartan-vue";
import { PencilIcon, EyeIcon, TrashIcon, CreditCardIcon } from "@heroicons/vue/24/outline/index.js";
import { Link } from "@inertiajs/vue3";
import { route } from 'ziggy-js';
import { usePage } from "@inertiajs/vue3";
import {useI18n} from "vue-i18n";

const { t } = useI18n();

const page = usePage();
const permissions = Object.values(page.props.auth.allPermissions).flat();

const props = defineProps({
    data: {
        type: Array,
        required: true
    },
    cols: {
        type: Array,
        required: true
    },
    actions: {
        type: Object,
        required: true
    },
    id_microsite:{
        type: Object,
        required: true
    }
});

const translateValues = [
    'subscription',
    'donation',
    'invoice',
    'admin',
    'guest',
    'PENDING',
    'APPROVED',
    'REJECTED',
    'APPROVED_PARTIAL',
    'PARTIAL_EXPIRED',
    'UNKNOWN',
];

const getIcon = (action) => {
    switch (action) {
        case 'edit':
            return PencilIcon;
        case 'show':
            return EyeIcon;
        case 'destroy':
            return TrashIcon;
        case 'payment':
            return CreditCardIcon;
        case 'pay':
            return CreditCardIcon;
        default:
            return null;
    }
};

const getMethod = (action) => {
    switch (action) {
        case 'edit':
            return 'get';
        case 'show':
            return 'get';
        case 'destroy':
            return 'delete';
        case 'payment':
            return 'get';
        case 'pay':
            return 'post';
        default:
            return 'get';
    }
};

const translateValue = (value) => {
    if (translateValues.includes(value)) {
        if (t('microsites.types.' + value) !== 'microsites.types.' + value) {
            return t('microsites.types.' + value);
        }
        if (t('roles.roles_base.' + value) !== 'roles.roles_base.' + value) {
            return t('roles.roles_base.' + value);
        }
        if (t('payments.status.' + value) !== 'payments.status.' + value) {
            return t('payments.status.' + value);
        }
    }
    return value;
};

</script>
