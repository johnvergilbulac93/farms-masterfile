<script setup>
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    business_units: Object,
    total_record: Number,
    filters: Object,
    cus_id: String,
});

const form = useForm({
    search: props.filters.search,
});

watch(
    form,
    throttle(function (val) {
        Inertia.get(
            route("customer.status", props.cus_id),
            { search: val.search },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true,
            }
        );
    }, 1000)
);

const clear = () => {
    form.search = "";
};

const changeStatus = (payload) => {
    Inertia.post(
        route("customer.apply"),
        {
            bu_id: payload.id,
            cus_code: props.cus_id,
        },
        {
            replace: true,
            preserveScroll: true,
            onSuccess: (data) => {
                notyf.success({
                    message: `${data.props.flash.message}`,
                    position: {
                        x: "right",
                        y: "bottom",
                    },
                });
            },
        }
    );
};
</script>
<template>
    <Head title="Customer Status" />
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
                    v-if="form.search"
                    @click="clear"
                    class="absolute inset-y-0 right-2 flex items-center pl-3 cursor-pointer group"
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
                    v-model="form.search"
                    type="text"
                    id="table-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-80 pl-10 p-2.5"
                    placeholder="Search for business unit"
                />
            </div>

            <Link
                :href="route('customer.show')"
                class="text-gray-500 flex items-center gap-1 hover:underline"
            >
                Back</Link
            >
        </div>
        <table>
            <thead>
                <tr>
                    <th scope="col">Business Unit</th>
                    <th scope="col" class="text-center">Type</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!business_units.data.length">
                    <td class="ext-center" colspan="4">
                        No matching records found
                    </td>
                </tr>

                <tr v-for="(bu, i) in business_units.data" :key="i">
                    <td scope="row">
                        {{ bu.bu_name }}
                    </td>
                    <td class="text-center">
                        <span v-if="bu.bu_type == 1" class="badge-primary">
                            Aqua
                        </span>
                        <span v-if="bu.bu_type == 2" class="badge-success">
                            Agri
                        </span>
                        <span v-if="bu.bu_type == 3" class="badge-secondary">
                            Non-farm
                        </span>
                    </td>
                    <td class="text-center">
                        <button
                            @click="changeStatus(bu)"
                            class="background-transparent font-bold uppercase px-8 outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                            type="button"
                            :class="{
                                'text-emerald-500': bu.customer != null,
                                'text-red-500': bu.customer == null,
                            }"
                        >
                            <svg
                                v-if="bu.customer != null"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"
                                />
                            </svg>

                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination
            :links="business_units"
            :search="form.search"
            :total="total_record"
        />
    </BreezeAuthenticatedLayout>
</template>
