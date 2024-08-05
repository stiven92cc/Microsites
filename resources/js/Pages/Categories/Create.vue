<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'categories.index'"
                :icon-position="'left'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>{{ $t('categories.create_new_category') }}</SPageTitle>
                <form @submit.prevent="submit">
                    <div class="my-4 w-full">
                        <SInputBlock
                            :label="$t('categories.forms.name')"
                            :errorText="form.errors.name"
                            name="name"
                            id="name"
                            placeholder="John Doe"
                            v-model="form.name"
                        >
                        </SInputBlock>
                    </div>
                    <div class="my-4 w-full">
                        <SInputBlock
                            :label="$t('categories.forms.alias')"
                            :errorText="form.errors.alias"
                            name="alias"
                            id="alias"
                            v-model="form.alias"
                        >
                        </SInputBlock>
                    </div>
                    <div class="my-4 w-full">
                        <label for="description text-gray-900 text-sm">{{ $t('categories.forms.description') }}</label>
                        <STextArea
                            :errorText="form.errors.description"
                            name="description"
                            id="description"
                            v-model="form.description"
                        >
                        </STextArea>
                    </div>
                    <div class="flex justify-end">
                        <SButton
                            type="submit"
                        >
                            {{ $t('common.create') }}
                        </SButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {SButton, SInputBlock, SPageTitle, STextArea} from "@placetopay/spartan-vue";
import Button from "@/Components/Atoms/Button.vue";
import {ArrowLeftIcon} from "@heroicons/vue/24/outline/index.js";
import {route} from "ziggy-js";

const form = useForm({
    name: '',
    description: '',
    alias: ''
});

const submit = () => {
    form.post(route('categories.store'));
};
</script>
