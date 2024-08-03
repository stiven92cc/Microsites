<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    configuration: { type: Object },
    microsite: { type: Object }
});

const reactiveConfiguration = ref({ ...props.configuration });

const addField = () => {
    reactiveConfiguration.value.fields.push({
        type: "text",
        name: `field${reactiveConfiguration.value.fields.length + 1}`,
        active: true,
        required: false
    });
};

const removeField = (index) => {
    reactiveConfiguration.value.fields.splice(index, 1);
};

const toggleFieldActive = (field) => {
    field.active = field.active === 'true' ? 'false' : 'true';
};

watch(() => props.configuration, (newVal) => {
    reactiveConfiguration.value = { ...newVal };
});
</script>

<template>
    <div class="mx-16">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Configure payment form</h1>
    </div>
    <div class="grid grid-cols-6 gap-4 m-12">
        <div class="col-span-4 bg-white rounded-lg p-4 py-16">
            <div class="grid grid-cols-2 gap-4">
                <div
                    v-for="(field, index) in reactiveConfiguration.fields"
                    :key="index"
                    class="col-span-1"
                >
                    <label :for="field.name">{{ field.name }}</label>
                    <input
                        :type="field.type"
                        :id="field.name"
                        class="w-full border border-gray-300 rounded-md p-2"
                    />
                </div>
            </div>
        </div>
        <div class="col-span-2 bg-white rounded-lg p-4 ml-6">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Change configuration</h1>
            <div>
                <button @click="addField" class="bg-blue-500 text-white rounded-md px-4 py-2 mb-4">Add Field</button>
                <div v-for="(field, index) in reactiveConfiguration.fields" :key="index" class="mb-2">
                    <input
                        type="checkbox"
                        :id="'checkbox-' + field.name"
                        v-model="field.active"
                    />
                    <label :for="'checkbox-' + field.name">{{ field.name }}</label>
                    <button @click="removeField(index)" class="bg-red-500 text-white rounded-md px-2 py-1 ml-2">Remove</button>
                </div>
            </div>
        </div>
    </div>
</template>
