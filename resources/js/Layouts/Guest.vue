<script setup>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/runtime-core";
</script>

<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 xs:pt-0 bg-gray-100"
    >
        <Link href="/" class="text-gray-600 text-3xl font-semibold">
            FARMS MASTERFILE
            <!-- <img src="/images/logo.png" alt="logo" class="w-28" /> -->
        </Link>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
