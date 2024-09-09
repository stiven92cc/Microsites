<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <SPageTitle>{{ $t('modules.categories') }}</SPageTitle>
            </div>
        </template>

        <div v-if="can('microsites.create')" class="flex justify-end m-6">
            <Button
                :icon="PlusCircleIcon"
                :classes="'bg-orange-500 hover:bg-orange-400'"
                :route-name="'categories.create'"
            >
                {{ $t('common.create') }}
            </Button>
        </div>

        <DataTable
            :data="props.categories"
            :cols="cols"
            :actions="actions"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/Molecules/DataTable.vue";
import Button from "@/Components/Atoms/Button.vue";
import {PlusCircleIcon} from "@heroicons/vue/24/outline/index.js";
import {SPageTitle} from "@placetopay/spartan-vue";

const props = defineProps({
    categories: Object
});

const cols = [
    "id",
    "name",
    "description",
    "alias",
    "actions",
];

const actions = {
    edit:"categories.edit",
    destroy:"categories.destroy",
}
</script>
