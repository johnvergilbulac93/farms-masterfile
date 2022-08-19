<script setup>
defineProps({
    image: String,
    title: String,
    count: Number,
    link: String,
});
</script>

<template>
    <div
        class="py-8 px-8 max-w-sm mx-auto bg-gray-100 rounded-xl shadow-lg space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6"
    >
        <img
            class="block mx-auto h-16 rounded-full sm:mx-0 sm:shrink-0"
            :src="image"
            alt="image"
        />
        <div class="text-center space-y-2 sm:text-left">
            <div class="space-y-0.5">
                <p class="text-xl text-slate-500 font-semibold">{{ title }}</p>
                <p class="text-slate-500 font-medium text-lg">
                    {{ count ? count.toLocaleString() : '' }}
                </p>
            </div>
            <Link
                :href="link"
                class="px-4 mt-1 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2 transition duration-300"
            >
                Click here to view
            </Link>
        </div>
    </div>
</template>
