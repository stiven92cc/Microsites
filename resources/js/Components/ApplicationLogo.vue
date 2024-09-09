<template>
    <div class="flex lg:justify-start lg:col-start-2">
        <div class="group flex items-center rounded">
            <GlobeAmericasIcon class="w-6 text-orange-500 group-hover:text-gray-500" />
            <h1 class="m-1 text-orange-500 group-hover:text-gray-500">{{ $t('common.microsites') }}</h1>
        </div>
    </div>
</template>
<script setup>
import {GlobeAmericasIcon} from "@heroicons/vue/24/outline/index.js";
</script>
