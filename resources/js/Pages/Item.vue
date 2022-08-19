<script setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch } from "vue";
import throttle from "lodash/throttle";

const props = defineProps({
    items: Object,
    filters: Object,
    total_record: Number,
});

const search = ref(props.filters.search);

const clear = () => {
    search.value = "";
};

watch(
    search,
    throttle(function (value) {
        Inertia.get(
            "/item",
            { search: value },
            { preserveState: true, replace: true, preserveScroll: true }
        );
    }, 1000)
);
</script>

<template>
    <Head title="Item" />
    <BreezeAuthenticatedLayout>
        <div class="flex items-center justify-between">
            <div class="relative">
                <label for="table-search" class="sr-only">Search</label>
                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                    <svg
                        class="w-5 h-5 text-gray-500 dark:text-gray-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>

                <button
                    class="absolute inset-y-0 right-2 flex items-center pl-3 cursor-pointer group"
                    v-if="search"
                    @click="clear"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 text-gray-500 group-hover:text-red-500"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </button>
                <input
                    v-model="search"
                    type="text"
                    id="table-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-80 pl-10 p-2.5"
                    placeholder="Search for item"
                />
            </div>

            <Link
                :href="route('item.create')"
                class="inline-flex gap-1 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                </svg>
                <span>ADD</span>
            </Link>
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">Item Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-if="!items.data.length">
                    <td class="text-center" colspan="4">
                        No matching records found
                    </td>
                </tr>

                <tr v-for="(item, i) in items.data" :key="i">
                    <td scope="row">
                        {{ item.itemcode }}
                    </td>
                    <td>
                        {{ item.description }}
                    </td>
                    <td class="flex gap-2">
                        <Link
                            :href="route('item.status', item.itemcode)"
                            class="font-medium text-indigo-600 hover:underline"
                            >Status</Link
                        >
                        |
                        <Link
                            :href="route('item.edit', item.id)"
                            class="font-medium text-indigo-600 hover:underline"
                            >Edit</Link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination :links="items" :search="search" :total="total_record" />
    </BreezeAuthenticatedLayout>
</template>
