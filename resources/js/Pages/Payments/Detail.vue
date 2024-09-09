<template>
    <div class="mt-4 ml-36">
        <div class="flex items-center justify-between">
            <SPageTitle>{{ $t('common.payment_summary') }}</SPageTitle>
            <div class="mr-36">
                <ChangeLocale/>
            </div>
        </div>
    </div>
    <div class="min-w-min bg-white mx-36 my-12 rounded-lg">
        <div class="p-6 grid grid-cols-3">
            <div>
                <h1 class="text-gray-400">{{ $t('payments.show.payer_name') }}</h1>
                <span>{{ props.payment.payer_name }} {{ props.payment.payer_last_name }}</span>
            </div>
            <div>
                <h1 class="text-gray-400">{{ $t('payments.show.payer_document') }}</h1>
                <span>{{ props.payment.payer_document_type }} - {{ props.payment.payer_document }}</span>
            </div>
            <div>
                <h1 class="text-gray-400">{{ $t('payments.show.reference') }}</h1>
                <span>{{ props.payment.reference }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.payer_email') }}</h1>
                <span>{{ props.payment.payer_email }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.phone_number') }}</h1>
                <span>{{ props.payment.phone_number }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.description') }}</h1>
                <span>{{ props.payment.description }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.currency') }}</h1>
                <span>{{ props.payment.currency }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.amount') }}</h1>
                <span>{{ props.payment.amount }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.status_payment') }}</h1>
                <span>{{ $t('payments.status.' + props.payment.status) }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.payment_date') }}</h1>
                <span>{{ parser.processDate(props.payment.created_at) }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.microsite') }}</h1>
                <span>{{ props.microsite.name }}</span>
            </div>
            <div class="mt-6">
                <h1 class="text-gray-400">{{ $t('payments.show.microsite_type') }}</h1>
                <span>{{ $t('microsites.types.' + props.microsite.type ) }}</span>
            </div>
        </div>
        <div v-if="props.payment.status === 'REJECTED'" class="flex justify-end p-8">
            <SButton>
                {{ $t('common.payment_retry') }}
            </SButton>
        </div>
    </div>
    <div class="flex justify-center">
    <Button
        :iconPosition="'left'"
        :icon="BuildingStorefrontIcon"
        :route-name="'welcome'"
        :icon-position="'left'"
    >
        {{ $t('common.return') }}
    </Button>
    </div>
</template>

<script setup>

import {ParserDate} from "@/parserDate.js";
import {SButton, SPageTitle} from "@placetopay/spartan-vue";
import {BuildingStorefrontIcon} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import ChangeLocale from "@/Components/Molecules/ChangeLocale.vue";

const parser = new ParserDate();

const props = defineProps({
    payment: {
        type: Object
    },
    microsite: {
        type: Object
    }
});
</script>
