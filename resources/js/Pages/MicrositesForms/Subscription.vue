<template>
    <AuthenticatedLayout>
        <div class="mx-20 my-6 text-xl text-gray-900 font-semibold">
            <h1>{{$t('subscription.title')}}</h1>
        </div>
        <div class="grid grid-cols-3 gap-4 mx-16">
            <div v-for="subscription in props.microsite.subscription_plans"
                 :key="subscription.id"
                 class="bg-white mx-4 col-span-1 p-4 border border-gray-300 rounded-lg">
                <div>
                    <h1 class="relative pb-2 text-center">
                        {{ subscription.name }}
                        <span class="absolute left-0 bottom-0 w-full h-0.5 bg-gray-200"></span>
                    </h1>
                    <div class="my-6">
                        <h1>{{$t('subscription.billing_period')}}: {{ subscription.subscription_period }}</h1>
                    </div>
                    <div class="my-6">
                        <h1>{{$t('subscription.price')}}: {{ subscription.amount }} {{ subscription.currency }}</h1> <!-- Currency displayed -->
                    </div>
                    <div class="my-6">
                        <p v-for="description in JSON.parse(subscription.description)">
                            {{ description }}
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <button @click="openModal(subscription)" class="bg-orange-500 text-white p-2 rounded-lg">
                            {{$t('subscription.select')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>

            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg z-10 w-full max-w-lg relative">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold mb-2">{{$t('subscription.selected')}}: {{ selectedSubscription.name }}</h2>
                    <p>{{$t('subscription.billing_period')}}: {{ selectedSubscription.subscription_period }}</p>
                    <p>{{$t('subscription.price')}}: {{ selectedSubscription.amount }} {{ selectedSubscription.currency }}</p>
                </div>

                <form @submit.prevent="submit">
                    <div class="flex">
                        <div class="mr-4 w-full">
                            <SInputBlock
                                :label="$t('microsites.forms.payment_form.name')"
                                :errorText="form.errors.payer_name"
                                name="name"
                                id="name"
                                placeholder="John"
                                v-model="form.payer_name"
                            />
                        </div>
                        <div class="ml-4 w-full">
                            <SInputBlock
                                :label="$t('microsites.forms.payment_form.last_name')"
                                :errorText="form.errors.payer_last_name"
                                name="last_name"
                                id="last_name"
                                placeholder="Doe"
                                v-model="form.payer_last_name"
                            />
                        </div>
                    </div>

                    <div class="flex my-6">
                        <div class="mr-4 w-full">
                            <SSelectBlock
                                id="payer_document_type"
                                :errorText="form.errors.payer_document_type"
                                placeholder="Select one option"
                                :label="$t('microsites.forms.payment_form.document_type')"
                                v-model="form.payer_document_type"
                            >
                                <option v-for="(value, key) in documentTypes" :key="key" :value="value">
                                    {{ value }}
                                </option>
                            </SSelectBlock>
                        </div>
                        <div class="ml-4 w-full">
                            <SInputBlock
                                :label="$t('microsites.forms.payment_form.document_number')"
                                :errorText="form.errors.payer_document"
                                name="slug"
                                id="slug"
                                v-model="form.payer_document"
                            />
                        </div>
                    </div>

                    <div class="flex">
                        <div class="mr-4 w-full">
                            <SInputBlock
                                :left-icon="EnvelopeIcon"
                                :label="$t('microsites.forms.payment_form.email')"
                                :errorText="form.errors.payer_email"
                                name="email"
                                id="email"
                                placeholder="John.doe@test.com"
                                v-model="form.payer_email"
                            />
                        </div>
                        <div class="ml-4 w-full">
                            <SInputBlock
                                prefix="+57"
                                :label="$t('microsites.forms.payment_form.phone_number')"
                                :errorText="form.errors.phone_number"
                                name="phone_number"
                                id="phone_number"
                                placeholder="311765342"
                                v-model="form.phone_number"
                            />
                        </div>
                    </div>

                    <SButton class="w-full my-6" type="submit">
                        {{ $t('microsites.forms.payment_form.payment') }}
                    </SButton>
                </form>
                <button @click="closeModal" class="text-red-500 mt-4">Close</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {ref} from 'vue';
import {defineProps} from 'vue';
import {useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {SButton, SInputBlock, SSelectBlock} from '@placetopay/spartan-vue';
import {route} from 'ziggy-js';

const props = defineProps({
    microsite: {
        type: Object,
        required: true,
    },
    documentTypes: {
        type: Object,
        required: true,
    },
    currencyTypes: {
        type: Object,
        required: true,
    },
});

const showModal = ref(false);
const selectedSubscription = ref(null);

const form = useForm({
    payer_name: '',
    payer_last_name: '',
    payer_document_type: '',
    payer_document: '',
    payer_email: '',
    phone_number: '',
    amount: '',
    currency: '',
    subscription: {
        reference: generateReference(),
        id: null,
    },
});

function generateReference() {
    return 'REF-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

const openModal = (subscription) => {
    selectedSubscription.value = subscription;
    form.subscription.id = subscription.id; // Set the subscription ID in the form
    form.amount = subscription.amount; // Set the amount
    form.currency = subscription.currency; // Set the currency
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    form.post(route('payment.pay', props.microsite.id), {
        onSuccess: () => {
            form.reset();
            closeModal();
        },
    });
};
</script>
