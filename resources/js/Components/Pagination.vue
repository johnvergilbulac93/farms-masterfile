<script setup>
import { watch } from "vue";

const props = defineProps({
    links: Object,
    total: Number,
    search: String,
});
const url = (url) => {
    return `${url}?search=${props.search}`;
};

const cNumber = (x) => {
    return x.toLocaleString("en-US");
};
</script>

<template>
    <div class="py-2 flex justify-between items-center">
        <div>
            <span class="text-sm font-semibold text-gray-500"
                >Showing {{ links.from ? links.from : 0 }} to
                {{ links.to ? links.to : 0 }} of
                {{ cNumber(links.total) }} entries
                <span v-if="search"
                    >(filtered from {{ cNumber(total) }} total entries)</span
                ></span
            >
        </div>
        <nav class="block">
            <ul class="flex pl-0 rounded list-none flex-wrap">
                <li v-for="(link, i) in links.links" :key="i">
                    <Link
                        preserve-scroll
                        preserve-state
                        class="first:ml-0 text-xs font-semibold flex mx-1 p-2 items-center justify-center leading-tight relative border border-solid border-indigo-500/50 bg-white"
                        :href="url(link.url)"
                        v-html="link.label"
                        :class="{
                            'bg-indigo-500 text-white': link.active,
                            'text-indigo-500': !link.active,
                            'cursor-not-allowed': !link.url,
                        }"
                    />
                </li>
            </ul>
        </nav>
    </div>
</template>
