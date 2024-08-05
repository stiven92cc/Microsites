<template>
    <AuthenticatedLayout>
        <div class="flex justify-end mt-6 mx-12">
            <Button
                :iconPosition="'left'"
                :icon="ArrowLeftIcon"
                :route-name="'roles.index'"
                :icon-position="'left'"
            >
                {{ $t('common.back') }}
            </Button>
        </div>
        <div class="mt-6 mx-[450px] p-8 bg-white rounded-md shadow-ls">
            <div class="my-1.5">
                <SPageTitle>{{ $t('roles.create_new_rol') }}</SPageTitle>
            </div>

            <form @submit.prevent="submit">
                <div class="w-full">
                    <SInputBlock
                        :label="$t('roles.forms.name')"
                        :errorText="form.errors.name"
                        name="name"
                        id="name"
                        placeholder="Admin"
                        v-model="form.name"
                    >
                    </SInputBlock>

                    <div>
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="flex justify-center p-6 text-gray-900">
                                    <form @submit.prevent="submit"
                                          class="w-full max-w-3xl py-8 space-y-5" id="formPermissions"
                                    >
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                            <div v-for="(permissions, group) in groupedPermissions" :key="group">
                                                <div class="flex items-center">
                                                    <input
                                                        class="cursor-pointer form-checkbox text-orange-400 border-gray-200 rounded hover:text-orange-500 hover:border-gray-400 focus:ring-2 focus:ring-orange-500"
                                                        type="checkbox"
                                                        :id="'group_' + group"
                                                        v-model="selectedRoles[group]"
                                                        @click="toggleGroup(group, selectedRoles, groupedPermissions)"
                                                    />
                                                    <InputLabel :for="'group_' + group" :value="$t('roles.forms.group_roles.' + group)" class="ml-2" />
                                                </div>
                                                <div class="ml-6">
                                                    <div v-for="permission in permissions" :key="permission" class="flex items-center mt-2">
                                                        <input
                                                            type="checkbox"
                                                            :id="`${group}.${permission}`"
                                                            :value="`${group}.${permission}`"
                                                            name="permissions[]"
                                                            class="cursor-pointer form-checkbox text-orange-400 border-gray-200 rounded hover:text-orange-500 hover:border-gray-400 focus:ring-2 focus:ring-orange-500"
                                                            @change="e => handlePermissionChange(group, permission, e)"
                                                            :checked="isPermissionChecked(group, permission)"
                                                        />
                                                        <InputLabel :for="`${group}.${permission}`" :value="$t('roles.forms.permissions.' + permission)" class="ml-2"/>
                                                    </div>
                                                </div>
                                            </div>
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
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { route } from "ziggy-js";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { defineProps, ref } from "vue";
import {ArrowLeftIcon} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import {SButton, SCheckbox, SInputBlock, SPageTitle} from "@placetopay/spartan-vue";

const selectedRoles = ref({});

function toggleGroup(group, selectedGroups, permissions) {
    const isChecked = !selectedGroups[group];
    selectedGroups[group] = isChecked;

    permissions[group].forEach(permission => {
        const checkbox = document.getElementById(`${group}.${permission}`);
        checkbox.checked = isChecked;
        if (isChecked) {
            form.permissions.push(`${group}.${permission}`);
        } else {
            form.permissions = form.permissions.filter(p => p !== `${group}.${permission}`);
        }
    });
}

function processPermissions(permissions) {
    let bundledPermissions = {};

    permissions.forEach(permission => {
        let permissionName = permission.name;
        let token = permissionName.split('.');

        if (!bundledPermissions[token[0]]) {
            bundledPermissions[token[0]] = [];
        }
        bundledPermissions[token[0]].push(token[1]);
    });

    return bundledPermissions;
}

const initialValues = {
    name: "",
    permissions: []
}

const form = useForm(initialValues)

const submit = () => {
    form.post(route('roles.store'), {
        onSuccess: () => {

        },
        onError: () => {

        }
    });
}

const props = defineProps({
    permissions: {
        type: Array
    }
})

const groupedPermissions = processPermissions(props.permissions);

const handlePermissionChange = (group, permission, event) => {
    const value = `${group}.${permission}`;
    if (event.target.checked) {
        form.permissions.push(value);
    } else {
        form.permissions = form.permissions.filter(p => p !== value);
    }
};

const isPermissionChecked = (group, permission) => {
    return form.permissions.includes(`${group}.${permission}`);
};
</script>
