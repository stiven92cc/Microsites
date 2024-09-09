<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'users.index'"
                :icon-position="'left'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>{{ $t('users.create_new_user') }}</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <div class="flex">
                    <div class="mr-4 w-full">
                        <SInputBlock
                            :label="$t('users.forms.name')"
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
                            :label="$t('users.forms.email')"
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
                        <SSelectBlock
                            id="document_type"
                            :errorText="form.errors.document_type"
                            placeholder="Select one option"
                            :label="$t('users.forms.document_type')"
                            v-model="form.document_type"
                        >
                            <option v-for="(value, key) in document_type" :key="key" :value="value">
                                {{ value}}
                            </option>
                        </SSelectBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <label class="text-sm" for="document">{{ $t('users.forms.document') }}</label>
                        <SInput
                            :label="$t('users.forms.document')"
                            :errorText="form.errors.document"
                            name="document"
                            id="document"
                            type="number"
                            v-model="form.document"
                        >
                        </SInput>
                    </div>
                </div>

                <div class="flex my-6">
                    <div class="mr-4 w-full">
                        <label class="text-sm" for="password">{{ $t('users.forms.password') }}</label>
                        <SInput
                            :left-icon="KeyIcon"
                            type="password"
                            :label="$t('users.forms.password')"
                            :errorText="form.errors.password"
                            name="password"
                            id="password"
                            placeholder="*********"
                            v-model="form.password"
                        >
                        </SInput>
                    </div>
                    <div class="ml-4 w-full">
                        <label class="text-sm" for="password_confirmation">{{ $t('users.forms.confirm_password') }}</label>
                        <SInput
                            :left-icon="KeyIcon"
                            type="password"
                            :label="$t('users.forms.confirm_password')"
                            :errorText="form.errors.password_confirmation"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="*********"
                            v-model="form.password_confirmation"
                        >
                        </SInput>
                    </div>
                </div>
                <div class="mr-4 w-full">
                    <SSelectBlock
                        id="role"
                        :errorText="form.errors.role"
                        placeholder="Select one option"
                        :label="$t('users.forms.role')"
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
                    >
                        {{ $t('common.create') }}
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
    document:'',
    document_type:'',
    role: '',
    password:'',
    password_confirmation:'',
});

const props = defineProps({
    document_type: {type:Object},
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


