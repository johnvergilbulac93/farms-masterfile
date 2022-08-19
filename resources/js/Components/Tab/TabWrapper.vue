<template>
    <div class="w-full">
        <ul class="flex items-center">
            <li
                v-for="(title, i) in tabTitles"
                :key="i"
                class="py-1 px-3 cursor-pointer text-gray-600 font-medium"
                :class="{ 'text-indigo-700': selectedTitle === title }"
                @click="selectedTitle = title"
            >
                {{ title }}
            </li>
        </ul>
        <div class="border-t p-2">
            <slot />
        </div>
    </div>
</template>
<script setup>
import { ref, useSlots, provide } from "vue";

const slots = useSlots();
const tabTitles = ref(slots.default().map((tab) => tab.props.title));
const selectedTitle = ref(tabTitles.value[0]);

provide("selectedTitle", selectedTitle);
</script>
