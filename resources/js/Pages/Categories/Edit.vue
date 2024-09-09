<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'categories.index'"
                :icon-position="'left'"
            >
                Back
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>Create new category</SPageTitle>
                <form @submit.prevent="submit">
                    <div class="my-4 w-full">
                        <SInputBlock
                            label="name"
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
                            label="alias"
                            :errorText="form.errors.alias"
                            name="alias"
                            id="alias"
                            v-model="form.alias"
                        >
                        </SInputBlock>
                    </div>
                    <div class="my-4 w-full">
                        <label for="description text-gray-900 text-sm">description</label>
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
                            Save
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
import { defineProps } from 'vue';
import {route} from "ziggy-js";
import {ArrowLeftIcon} from "@heroicons/vue/24/outline/index.js";
import {SButton, SInputBlock, SPageTitle, STextArea} from "@placetopay/spartan-vue";
import Button from "@/Components/Atoms/Button.vue";

const props = defineProps({
    category: Object
});

const form = useForm({
    name: props.category.name,
    description: props.category.description,
    alias: props.category.alias
});

const submit = () => {
    form.patch(route('categories.update', props.category.id));
};
</script>
