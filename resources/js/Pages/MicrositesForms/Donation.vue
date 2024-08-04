<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'microsites.index'"
                :icon-position="'left'"
            >
                Back
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="mb-6 text-center">
                <SPageTitle> {{ microsite.name }}</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <div class="flex">
                    <div class="mr-4 w-full">
                        <SInputBlock
                            label="name"
                            :errorText="form.errors.payer_name"
                            name="name"
                            id="name"
                            placeholder="John"
                            v-model="form.payer_name"
                        >
                        </SInputBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <SInputBlock
                            label="last_name"
                            :errorText="form.errors.payer_last_name"
                            name="last_name"
                            id="last_name"
                            placeholder="Doe"
                            v-model="form.payer_last_name"
                        >
                        </SInputBlock>
                    </div>
                </div>
                <div class="flex my-6">
                    <div class="mr-4 w-full">
                        <SSelectBlock
                            id="payer_document_type"
                            :errorText="form.errors.payer_document_type"
                            placeholder="Select one option"
                            label="payer_document_type"
                            v-model="form.payer_document_type"
                        >
                            <option v-for="(value, key) in documentTypes" :key="key" :value="value">
                                {{ value }}
                            </option>
                        </SSelectBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <SInputBlock
                            label="document"
                            :errorText="form.errors.payer_document"
                            name="slug"
                            id="slug"
                            v-model="form.payer_document"
                        >
                        </SInputBlock>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-4 w-full">
                        <SInputBlock
                            :left-icon="EnvelopeIcon"
                            label="email"
                            :errorText="form.errors.payer_email"
                            name="email"
                            id="email"
                            placeholder="John.doe@test.com"
                            v-model="form.payer_email"
                        >
                        </SInputBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <SInputBlock
                            prefix="+57"
                            label="phone_number"
                            :errorText="form.errors.phone_number"
                            name="phone_number"
                            id="phone_number"
                            placeholder="311765342"
                            v-model="form.phone_number"
                        >
                        </SInputBlock>
                    </div>
                </div>
                <div class="flex my-6">
                    <div class="mr-4 w-full">
                        <SSelectBlock
                            id="currency"
                            :errorText="form.errors.currency"
                            placeholder="Select one option"
                            label="currency"
                            v-model="form.currency"
                        >
                            <option v-for="(value, key) in currencyTypes" :key="key" :value="value">
                                {{ value }}
                            </option>
                        </SSelectBlock>
                    </div>
                    <div class="w-full">
                        <SInputBlock
                            :left-icon="CurrencyDollarIcon"
                            label="amount"
                            :errorText="form.errors.amount"
                            name="amount"
                            id="amount"
                            v-model="form.amount"
                        >
                        </SInputBlock>
                    </div>
                </div>
                <div class="w-full">
                    <SInputBlock
                        :left-icon="InformationCircleIcon"
                        label="reference"
                        :errorText="form.errors.reference"
                        name="last_name"
                        id="last_name"
                        placeholder="87dgr4syt421"
                        v-model="form.reference"
                    >
                    </SInputBlock>
                </div>
                <div class="w-full my-6">
                    <STextAreaBlock
                        label="description"
                        :errorText="form.errors.description"
                        name="description"
                        id="description"
                        placeholder="des...."
                        v-model="form.description"
                    >
                    </STextAreaBlock>
                </div>
                <SButton
                    class="w-full my-6"
                    type="submit"
                >
                    Pagar
                </SButton>
            </form>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {SButton, SInputBlock, SPageTitle, SSelectBlock, STextAreaBlock} from "@placetopay/spartan-vue";
import {route} from "ziggy-js";
import {
    ArrowLeftIcon,
    CurrencyDollarIcon,
    EnvelopeIcon,
    InformationCircleIcon,
    ReceiptPercentIcon
} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";

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
        required: true
    }
});

const form = useForm({
    payer_name: '',
    payer_last_name: '',
    payer_document_type:'',
    payer_document:'',
    amount: '',
    currency: '',
    payer_email:'',
    phone_number: '',
    reference: '',
    description: '',
});

const submit = () => {
    form.post(route('payment.pay', props.microsite.id), {
        onSuccess: () => {
            form.reset()
        },
    });
};
</script>
