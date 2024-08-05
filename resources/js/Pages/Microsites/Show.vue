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

        <h1></h1>

        <Form
            :configuration="JSON.parse(props.microsite.form.form_configuration)"
            :microsite="props.microsite"
        >
        </Form>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ParserDate} from "@/parserDate.js";
import DropdownLink from "@/Components/DropdownLink.vue";
import {route} from "ziggy-js";
import Dropdown from "@/Components/Dropdown.vue";
import DropDownIndex from "@/Components/Molecules/DropDownIndex.vue";
import Form from "@/Pages/Microsites/Form.vue";
import {SPageTitle} from "@placetopay/spartan-vue";
import Button from "@/Components/Atoms/Button.vue";
import {ArrowLeftIcon} from "@heroicons/vue/24/outline/index.js";

const parserDate = new ParserDate();

const props = defineProps({
    microsite: Object,
});
</script>
