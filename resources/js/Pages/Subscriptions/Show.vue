<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'subscriptions.index'"
                :icon-position="'left'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="min-w-min bg-white mx-36 my-12 rounded-lg">
            <div class="p-6 grid grid-cols-3">
                <div>
                    <h1 class="text-gray-400">Subscriber Name</h1>
                    <span>{{ props.payment.payer_name }} {{ props.payment.payer_last_name }}</span>
                </div>
                <div>
                    <h1 class="text-gray-400">Document</h1>
                    <span>{{ props.payment.payer_document_type }} - {{ props.payment.payer_document }}</span>
                </div>
                <div>
                    <h1 class="text-gray-400">Reference</h1>
                    <span>{{ props.payment.reference }}</span>
                </div>

                <div class="mt-6">
                    <h1 class="text-gray-400">Subscription Status</h1>
                    <span>{{ props.subscription.status }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">Valid Until</h1>
                    <span>{{ props.subscription.validUntil }}</span>
                </div>

                <div class="mt-6">
                    <h1 class="text-gray-400">Subscription Plan</h1>
                    <span>{{ props.subscriptionPlan.name }} ({{ props.subscriptionPlan.subscription_period }})</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">Amount</h1>
                    <span>{{ props.subscriptionPlan.amount }}</span>
                </div>

                <div class="mt-6">
                    <h1 class="text-gray-400">Payment Status</h1>
                    <span>{{ props.payment.status }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">Payment Date</h1>
                    <span>{{ parser.processDate(props.payment.paid_at) }}</span>
                </div>
            </div>

            <div v-if="props.subscription.status === 'REJECTED'" class="flex justify-end p-8">
                <SButton>
                    Retry Payment
                </SButton>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import { ParserDate } from "@/parserDate.js";
import { SButton } from "@placetopay/spartan-vue";

const parser = new ParserDate();

const props = defineProps({
    subscription: {
        type: Object
    },
    payment: {
        type: Object
    },
    subscriptionPlan: {
        type: Object
    }
});
</script>
