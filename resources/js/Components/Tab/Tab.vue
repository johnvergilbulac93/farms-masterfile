<template>
    <div class="" v-show="title === selectedTitle">
        <slot />
    </div>
</template>

<script set setup>
import { inject } from "vue";

defineProps({
    title: String,
});
const selectedTitle = inject("selectedTitle");
</script>
