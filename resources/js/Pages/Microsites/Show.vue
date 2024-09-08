<template>
    <AuthenticatedLayout>
        <template #header>
            <SPageTitle>{{ props.microsite.name }}</SPageTitle>
        </template>

        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'microsites.index'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>

        <div class="min-w-min bg-white m-12 rounded-lg">
            <DropDownIndex
                class="flex justify-end"
                :links="[
                { route: '/microsites/' + props.microsite.id + '/edit/', action: 'Edit' },
                { route: '/microsites/' + props.microsite.id, action: 'Delete', id: props.microsite.id },
            ]"
            />
            <div class="p-6 grid grid-cols-3">
                <div>
                    <h1 class="text-gray-400">{{ $t('microsites.show.name') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.name }}</span>
                </div>
                <div>
                    <h1 class="text-gray-400">{{ $t('microsites.show.category') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.category.name }}</span>
                </div>
                <div>
                    <h1 class="text-gray-400">{{ $t('microsites.show.type') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.type }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">{{ $t('microsites.show.slug') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.name }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">{{ $t('microsites.show.currency') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.currency }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">{{ $t('microsites.show.payment_expiration') }}</h1>
                    <span class="text-gray-900">{{ props.microsite.payment_expiration }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">{{ $t('microsites.show.created_at') }}</h1>
                    <span class="text-gray-900">{{ parserDate.processDate(props.microsite.created_at) }}</span>
                </div>
                <div class="mt-6">
                    <h1 class="text-gray-400">{{ $t('microsites.show.updated_at') }}</h1>
                    <span class="text-gray-900">{{ parserDate.processDate(props.microsite.updated_at) }}</span>
                </div>

                <div class="mt-6 flex">
                    <h1 class="text-gray-400">{{ $t('microsites.show.logo') }}</h1>
                    <img class="h-24 w-44 rounded-lg ml-12 border border-gray-300 shadow-md"
                         :src="props.microsite.logo ? `/storage/${props.microsite.logo}` : 'https://www.palomacornejo.com/wp-content/uploads/2021/08/no-image.jpg'"
                    >
                </div>
            </div>
        </div>

        <!-- Botón para crear un nuevo plan de suscripción -->
        <div v-if="props.microsite.type === 'subscription'">
            <div class="flex justify-end mt-6 mx-12">
                <Button
                    :classes="'bg-orange-500'"
                    :route-name="'subscription-plans.create'"
                    :param="props.microsite.id"
                    type="submit"
                >
                    {{ $t('subscription_plans.create') }}
                </Button>
            </div>

            <div class="m-12">
                <DataTable
                    :data="props.microsite.subscription_plans"
                    :cols="cols"
                    :actions="actions"
                    :id_microsite="props.microsite.id"
                />
            </div>

        </div>

        <!--<Form
           // :configuration="JSON.parse(props.microsite.form.form_configuration)"
            //:microsite="props.microsite"
        >
       // </Form>-->
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ParserDate} from "@/parserDate.js";
import DropDownIndex from "@/Components/Molecules/DropDownIndex.vue";
import Form from "@/Pages/Microsites/Form.vue";
import {SButton, SPageTitle} from "@placetopay/spartan-vue";
import Button from "@/Components/Atoms/Button.vue";
import {ArrowLeftIcon, PlusCircleIcon} from "@heroicons/vue/24/outline/index.js";
import DataTable from "@/Components/Molecules/DataTable.vue";
import { useI18n } from 'vue-i18n';

const parserDate = new ParserDate();

const props = defineProps({
    microsite: Object,
    subscriptionPlans: Array
});

const { t } = useI18n();

const cols = [
    "name",
    "amount",
    "subscription_period",
    "expiration_time",
    "actions"
];

const actions = {
    edit: "subscription-plans.edit",
    show: "subscription-plans.index",
    destroy: "subscription-plans.destroy"
}

</script>
