<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'subscription-plans.index'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="mt-6 mx-auto max-w-3xl p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>{{ $t('Edit_Subscription') }}editar</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <!-- Name Field -->
                <div class="mr-4 w-full mt-6">
                    <SInputBlock
                        :label="$t('subscription_plans.fields.name')"
                        :errorText="form.errors.name"
                        name="name"
                        id="name"
                        placeholder="Name"
                        v-model="form.name"
                    >
                    </SInputBlock>
                </div>

                <!-- Descriptions Field -->
                <div class="md:col-span-2 mt-6">
                    <label class="block text-sm font-medium text-gray-700" for="description">
                        {{ $t('subscription_plans.fields.description') }}
                    </label>
                    <div v-for="(desc, index) in form.descriptions" :key="index" class="flex space-x-2 items-center mt-1">
                        <textarea
                            v-model="form.descriptions[index]"
                            rows="2"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            :placeholder="$t('subscription_plans.fields.description')"
                        ></textarea>
                        <button type="button" @click="removeDescription(index)" class="text-red-500 hover:text-red-700">
                            &times;
                        </button>
                    </div>
                    <button
                        type="button"
                        @click="addDescription"
                        class="mt-2 text-sm text-orange-600 hover:underline"
                    >
                        + {{ $t('subscription.addDescription') }}
                    </button>
                    <InputError class="mt-2" :message="form.errors.descriptions" />
                </div>

                <!-- Amount Field -->
                <div class="mb-4 mt-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700">
                        {{ $t('subscription_plans.fields.amount') }}
                    </label>
                    <input
                        v-model="form.amount"
                        id="amount"
                        type="number"
                        step="0.01"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                </div>

                <!-- Subscription Period Field -->
                <div class="mr-4 w-full mt-6">
                    <SSelectBlock
                        id="subscription_period"
                        :errorText="form.errors.subscription_period"
                        placeholder="Select one option"
                        :label="$t('subscription_plans.fields.subscription_period')"
                        v-model="form.subscription_period"
                    >
                        <option v-for="(value) in subscriptionPeriods" :key="value" :value="value">
                            {{ $t(`subscription_plans.periods.${value}`) }}
                        </option>
                    </SSelectBlock>
                </div>

                <!-- Expiration Time Field -->
                <div class="mb-4 mt-6">
                    <label for="expiration_time" class="block text-sm font-medium text-gray-700">
                        {{ $t('subscription_plans.fields.expiration_time') }}
                    </label>
                    <input
                        v-model="form.expiration_time"
                        id="expiration_time"
                        type="number"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <SButton class="bg-orange-500 hover:bg-orange-400 mt-6" type="submit">
                        {{ $t('common.update') }}
                    </SButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import { SInputBlock, SPageTitle, SSelectBlock, SButton } from "@placetopay/spartan-vue";
import { useI18n } from 'vue-i18n';
import { route } from "ziggy-js";

const props = defineProps({
    subscriptionPlan: Object,
    subscriptionPeriods: Array,
    microsite: Object,
});

const { t } = useI18n();

// Define the form with default values or values from props
const form = useForm({
    microsite_id: props.microsite?.id || null,
    id: props.subscriptionPlan.id || '',
    name: props.subscriptionPlan.name || '',
    descriptions: Array.isArray(props.subscriptionPlan.description) ? props.subscriptionPlan.description : [''],
    amount: props.subscriptionPlan.amount || 0,
    subscription_period: props.subscriptionPlan.subscription_period || '',
    expiration_time: props.subscriptionPlan.expiration_time || 0,
});

// Function to add a new description field
const addDescription = () => {
    form.descriptions.push('');
};

// Function to remove a description field
const removeDescription = (index) => {
    form.descriptions.splice(index, 1);
};

// Submit function to update the subscription plan
const submit = () => {
    form.put(route('subscription-plans.update', form.id), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors); // Log errors to console for debugging
        }
    });
};
</script>
