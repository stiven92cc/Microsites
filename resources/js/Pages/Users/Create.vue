<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'users.index'"
                :icon-position="'left'"
            >
                Back
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>Create new user</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <div class="flex">
                    <div class="mr-4 w-full">
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
                    <div class="ml-4 w-full">
                        <SInputBlock
                            :left-icon="EnvelopeIcon"
                            label="email"
                            :errorText="form.errors.email"
                            name="email"
                            id="email"
                            v-model="form.email"
                        >
                        </SInputBlock>
                    </div>
                </div>
                <div class="flex my-6">
                    <div class="mr-4 w-full">
                        <label class="text-sm" for="password">password</label>
                        <SInput
                            :left-icon="KeyIcon"
                            type="password"
                            label="password"
                            :errorText="form.errors.con"
                            name="name"
                            id="name"
                            placeholder="*********"
                            v-model="form.password"
                        >
                        </SInput>
                    </div>
                    <div class="ml-4 w-full">
                        <label class="text-sm" for="password">confirm_password</label>
                        <SInput
                            :left-icon="KeyIcon"
                            type="confirm_password"
                            label="confirm_password"
                            :errorText="form.errors.confirm_password"
                            name="confirm_password"
                            id="name"
                            placeholder="*********"
                            v-model="form.confirm_password"
                        >
                        </SInput>
                    </div>
                </div>
                <div class="mr-4 w-full">
                    <SSelectBlock
                        id="role"
                        :errorText="form.errors.role"
                        placeholder="Select one option"
                        label="role"
                        v-model="form.role"
                    >
                        <option v-for="(value, key) in roles" :key="key" :value="value.name">
                            {{ value.name }}
                        </option>
                    </SSelectBlock>
                </div>

                <div class="flex justify-end">
                    <SButton
                        class="bg-orange-500 hover:bg-orange-400 mt-6"
                        type="submit"
                    >Create
                    </SButton>

                </div>
            </form>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {route} from "ziggy-js";
import {ArrowLeftIcon, ArrowUpCircleIcon, EnvelopeIcon, KeyIcon} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import {SButton, SInput, SInputBlock, SPageTitle, SSelectBlock} from "@placetopay/spartan-vue";
import InputMessageError from "@/Layouts/InputMessageError.vue";


const form = useForm({
    name: '',
    email: '',
    role: '',
    password:'',
    confirm_password:'',
});

const props = defineProps({
    roles: {type:Object}
});


const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>


