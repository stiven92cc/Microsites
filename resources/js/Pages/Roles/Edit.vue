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
                <SPageTitle>{{ $t('roles.edit_role') }} {{ form.name }}</SPageTitle>
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
                            <form
                                @submit.prevent="submit"
                                class="w-full max-w-3xl py-8 space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                                    <div v-for="(permissions, group) in groupedPermissions" :key="group">
                                        <div class="flex items-center">
                                            <input
                                                class="cursor-pointer form-checkbox text-orange-400 border-gray-200 rounded hover:text-orange-500 hover:border-gray-400 focus:ring-2 focus:ring-orange-500"
                                                type="checkbox"
                                                :id="'group_' + group"
                                                :checked="permissions.every(permission => isPermissionSelected(permission))"
                                                @click="toggleGroup(permissions)"
                                            />
                                            <InputLabel :for="'group_' + group" :value="$t('roles.forms.group_roles.' + group)" class="ml-2" />
                                        </div>
                                        <div class="mt-4 ml-6">
                                            <div v-for="permission in permissions" :key="permission" class="flex items-center mt-2">
                                                <input
                                                    type="checkbox"
                                                    :id="permission"
                                                    :value="permission"
                                                    name="permissions[]"
                                                    class="cursor-pointer form-checkbox text-orange-400 border-gray-200 rounded hover:text-orange-500 hover:border-gray-400 focus:ring-2 focus:ring-orange-500"
                                                    @change="togglePermission(permission)"
                                                    :checked="isPermissionSelected(permission)"
                                                />
                                                <InputLabel :for="permission" :value="$t('roles.forms.permissions.' + permission.replace(/^[^.]+\./, ''))" class="ml-2" />

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <SButton
                                        type="submit"
                                    >
                                        {{ $t('common.edit') }}
                                    </SButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {route} from "ziggy-js";
import InputLabel from "@/Components/InputLabel.vue";
import {computed, defineProps, watch} from "vue";
import {ArrowLeftIcon} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";
import {SButton, SInputBlock, SPageTitle} from "@placetopay/spartan-vue";

const props = defineProps({
    role: {
        type: Object,
        required: true,
    },
    allPermissions: {
        type: Array,
        required: true,
    }
});

const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions.map(permission => permission.name) || [],
});

const separatePermissions = (permissions) => {
    return permissions.map(permission => {
        // Clonamos el objeto para no mutar el original
        let newPermission = { ...permission };

        // Modificamos la propiedad name si existe y es una cadena
        if (typeof newPermission.name === 'string') {
            newPermission.name = newPermission.name.replace(/^[^.]+\./, '');
        }

        return newPermission;
    });
}
// console.log(separatePermissions(props.allPermissions));
console.log(props.allPermissions);

const isPermissionSelected = (permission) => {
    return form.permissions.includes(permission);
};


const togglePermission = (permission) => {
    if (isPermissionSelected(permission)) {
        form.permissions = form.permissions.filter(p => p !== permission);
    } else {
        form.permissions.push(permission);
    }
};

const toggleGroup = (permissions) => {
    const allSelected = permissions.every(permission => isPermissionSelected(permission));
    if (allSelected) {
        form.permissions = form.permissions.filter(p => !permissions.includes(p));
    } else {
        permissions.forEach(permission => {
            if (!isPermissionSelected(permission)) {
                form.permissions.push(permission);
            }
        });
    }
};

const groupedPermissions = computed(() => {
    const groups = {};
    props.allPermissions.forEach(permission => {
        const [entity] = permission.name.split('.');
        if (!groups[entity]) {
            groups[entity] = [];
        }
        groups[entity].push(permission.name);
    });
    return groups;
});

watch(() => props.role, (newRole) => {
    form.name = newRole.name;
    form.permissions = newRole.permissions.map(permission => permission.name) || [];
}, { immediate: true });

const submit = () => {
    form.put(route('roles.update', props.role.id));
};
</script>
