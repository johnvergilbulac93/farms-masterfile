<script setup>
defineProps({
    show: Boolean,
});
</script>
<template>
    <teleport to="body">
        <div
            v-if="show"
            class="fixed inset-0 w-full h-screen bg-black/50 overflow-hidden flex justify-center items-center"
        >
            <div class="w-1/2 bg-white rounded">123123</div>
        </div>
    </teleport>
</template>
