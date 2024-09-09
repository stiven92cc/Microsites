<script setup>
import { router } from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline/index.js";

const props = defineProps({
    links: {
        type: Array,
        default: () => []
    }
});

const handleAction = (link) => {
    if (link.action === 'Delete') {
        router.delete(link.route)
    } else {
        router.get(link.route)
    }
};
</script>

<template>
    <div class="">
        <div class="ms-3">
            <Dropdown>
                <template #trigger>
                    <span class="rounded-md">
                        <button
                            type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium
                            rounded-full text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                            <EllipsisVerticalIcon class="w-6 h-6 rounded-full"/>
                        </button>
                    </span>
                </template>

                <template #content>
                    <template v-for="(link, index) in links" :key="index">
                        <DropdownLink :href="link.route" @click="handleAction(link)">
                            {{ link.action }}
                        </DropdownLink>
                    </template>
                </template>
            </Dropdown>
        </div>
    </div>
</template>
