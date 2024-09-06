<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'microsites.index'"
                :icon-position="'left'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>{{ $t('Create_New_Subscription') }}</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <div class="mr-4 w-full mt-6">
                    <SInputBlock
                        :label="$t('subscription_plans.fields.name')"
                        :errorText="form.errors.name"
                        name="name"
                        id="name"
                        placeholder="name"
                        v-model="form.name"
                    >
                    </SInputBlock>
                </div>
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
                <div class="mr-4 w-full mt-6">
                    <SSelectBlock
                        id="subscription_period"
                        :errorText="form.errors.subscription_period"
                        placeholder="Select one option"
                        :label="$t('subscription_plans.fields.subscription_period')"
                        v-model="form.subscription_period"
                    >
                        <option v-for="(value) in props.subscriptionPeriods" :key="value" :value="value">
                            {{ $t(`subscription_plans.periods.${value}`) }}
                        </option>
                    </SSelectBlock>
                </div>
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
                <div class="flex justify-end">
                    <SButton
                        class="bg-orange-500 hover:bg-orange-400 mt-6"
                        type="submit"
                    >
                        {{ $t('common.create') }}
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
    microsite_id: Number,
    subscriptionPeriods: Object,
});

const { t } = useI18n();

const form = useForm({
    microsite_id: props.microsite_id,
    name: '',
    descriptions: [''],
    amount: '',
    subscription_period: 'monthly',
    expiration_time: 0,
});

const addDescription = () => {
    form.descriptions.push('');
};

const removeDescription = (index) => {
    form.descriptions.splice(index, 1);
};

const submit = () => {
    form.post(route('subscription-plans.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
