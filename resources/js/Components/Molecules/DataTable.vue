<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-200 border-b">
                        <tr>
                            <th v-for="column in columns" :key="column.key" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                {{ column.label }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(row, rowIndex) in rows" :key="rowIndex" class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                            <td v-for="column in columns" :key="column.key" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <component :is="renderCell(row, column)" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, h } from 'vue';

const props = defineProps({
    columns: Array,
    rows: Array
});

const renderCell = (row, column) => {
    if (column.formatter) {
        return column.formatter(row[column.key], row);
    }
    return {
        render() {
            return h('span', row[column.key]);
        }
    };
};
</script>
