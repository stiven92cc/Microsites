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
                <SPageTitle>{{ $t('microsites.edit_microsite') }}</SPageTitle>
            </div>
            <form @submit.prevent="submit">
                <div class="flex">
                    <div class="mr-4 w-full">
                        <SInputBlock
                            :label="$t('microsites.forms.name')"
                            :errorText="form.errors.name"
                            name="name"
                            id="name"
                            placeholder="John Doe"
                            v-model="form.name"
                        />
                    </div>
                    <div class="ml-4 w-full">
                        <SInputBlock
                            :label="$t('microsites.forms.slug')"
                            :errorText="form.errors.slug"
                            name="slug"
                            id="slug"
                            v-model="form.slug"
                        />
                    </div>
                </div>
                <div class="flex mt-6">
                    <div class="mr-4 w-full">
                        <SSelectBlock
                            id="type"
                            :errorText="form.errors.type"
                            placeholder="Select one option"
                            :label="$t('microsites.forms.type')"
                            v-model="form.type"
                        >
                            <option v-for="(value, key) in types" :key="key" :value="value">
                                {{ value }}
                            </option>
                        </SSelectBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <SSelectBlock
                            id="category_id"
                            :errorText="form.errors.category_id"
                            placeholder="Select one option"
                            :label="$t('microsites.forms.category_id')"
                            v-model="form.category_id"
                        >
                            <option v-for="(value, key) in categories" :key="key" :value="key">
                                {{ value }}
                            </option>
                        </SSelectBlock>
                    </div>
                </div>
                <div class="flex mt-6">
                    <div class="mr-4 w-full">
                        <SSelectBlock
                            id="currency"
                            :errorText="form.errors.currency"
                            placeholder="Select one option"
                            :label="$t('microsites.forms.currency')"
                            v-model="form.currency"
                        >
                            <option v-for="(value, key) in currencies" :key="key" :value="value">
                                {{ value }}
                            </option>
                        </SSelectBlock>
                    </div>
                    <div class="ml-4 w-full">
                        <SInputBlock
                            :label="$t('microsites.forms.payment_expiration')"
                            :errorText="form.errors.payment_expiration"
                            name="payment_expiration"
                            id="payment_expiration"
                            v-model="form.payment_expiration"
                        />
                    </div>
                </div>
                <div v-if="props.microsite.logo || logoUrl" class="mt-6 w-auto cursor-pointer" @click="triggerLogoUpload">
                    <input @change="onSelectLogo" id="logo" type="file" class="hidden" />
                    <h1 class="text-gray-900 text-sm">logo:</h1>
                    <img v-if="logoUrl" :src="logoUrl" alt="Logo preview" class="h-32 w-60 rounded-lg ml-12 border border-gray-300 shadow-md"/>
                    <img v-else :src="`/storage/${props.microsite.logo}`" class="h-32 w-60 rounded-lg ml-12 border border-gray-300 shadow-md"/>
                </div>
                <main v-else class="items-center justify-center font-sans mt-8">
                    <label v-if="!logoUrl" for="logo" class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center rounded-xl border-2 border-dashed border-orange-500 bg-white p-6 text-center">
                        <ArrowUpCircleIcon class="w-12 h-12 text-orange-500"/>
                        <h2 class="mt-4 text-xl font-medium text-gray-700 tracking-wide">
                            {{ $t('microsites.forms.input_logo.select_logo') }}
                        </h2>
                        <p class="mt-2 text-gray-500 tracking-wide">
                            {{ $t('microsites.forms.input_logo.only_upload_png_and_jpg') }} .
                        </p>
                        <input @change="onSelectLogo" id="logo" type="file" class="hidden" />
                    </label>
                    <div v-else class="mx-auto flex w-full max-w-lg flex-col items-center rounded-xl border-2 border-dashed border-orange-500 bg-white p-6 text-center">
                        <img :src="logoUrl" alt="Logo preview" class="w-full h-auto"/>
                        <button @click="removeLogo" type="button" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Eliminar</button>
                    </div>
                </main>
                <div class="text-center mt-1">
                    <InputMessageError :message="form.errors.logo"/>
                </div>
                <div class="flex justify-end">
                    <SButton class="bg-orange-500 hover:bg-orange-400 mt-6" type="submit">
                        {{ $t('common.edit') }}
                    </SButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {defineProps, ref} from 'vue';
import {route} from "ziggy-js";
import {SButton, SInputBlock, SPageTitle, SSelectBlock} from "@placetopay/spartan-vue";
import InputMessageError from "@/Layouts/InputMessageError.vue";
import {ArrowLeftIcon, ArrowUpCircleIcon} from "@heroicons/vue/24/outline/index.js";
import Button from "@/Components/Atoms/Button.vue";

const props = defineProps({
    currencies: Object,
    categories: Object,
    types: Object,
    microsite: Object
});

const form = useForm({
    name: props.microsite.name,
    slug: props.microsite.slug,
    category_id: props.microsite.category_id,
    type: props.microsite.type,
    currency: props.microsite.currency,
    payment_expiration: props.microsite.payment_expiration,
    logo: null
});

const submit = () => {
    form.post(route('microsites.update.temp', props.microsite.id));
};

const logoUrl = ref('');

const onSelectLogo = (e) => {
    const files = e.target.files;
    if(files.length){
        form.logo = files[0];
        logoUrl.value = URL.createObjectURL(files[0]);
    }
}

const removeLogo = () => {
    form.logo = null;
    logoUrl.value = '';
    document.getElementById('logo').value = null;
}

const triggerLogoUpload = () => {
    document.getElementById('logo').click();

}
</script>
