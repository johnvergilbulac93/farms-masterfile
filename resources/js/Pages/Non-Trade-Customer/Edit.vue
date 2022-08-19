<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    business_units: Array,
    customer: Object,
});

const form = useForm({
    id: props.customer.cus_id,
    bu_code: props.customer.applied_to_bu,
    cus_name: props.customer.cus_name,
    nav_code: props.customer.nav_code,
});

const handleUpdate = () => {
    form.post(route("non-trade-customer.update"), {
        onSuccess: (data) => {
            notyf.success({
                message: `${data.props.flash.message}`,
                position: {
                    x: "center",
                    y: "top",
                },
            });
        },
    });
};
</script>
<template>
    <Head title="Edit Non-Trade Customer" />
    <BreezeAuthenticatedLayout>
        <div class="flex justify-center items-center w-full">
            <form @submit.prevent="handleUpdate" class="w-1/2">
                <div class="mt-4">
                    <Label for="nav_code" value="Navision Code" />
                    <Input
                        v-model="form.nav_code"
                        type="text"
                        class="mt-1 block w-full"
                        tabindex="1"
                        autofocus
                    />
                </div>
                <div class="mt-4">
                    <Label for="cus_name" value="Customer Name" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        tabindex="2"
                        v-model="form.cus_name"
                    />
                </div>
                <div class="mt-4">
                    <Label for="bu_code" value="Applied To" />
                    <select
                        class="block w-full text-base font-medium whitespace-nowrap text-gray-600 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        v-model="form.bu_code"
                        tabindex="3"
                    >
                        <option value="">Select Customer Type</option>
                        <option
                            :value="bu.id"
                            v-for="(bu, i) in business_units"
                            :key="i"
                        >
                            {{ bu.bu_name }}
                        </option>
                    </select>
                    <!-- <small
                        v-if="form.errors.cus_type"
                        class="text-red-500 block"
                        >{{ form.errors.cus_type }}</small
                    > -->
                </div>

                <div class="flex justify-end items-center mt-4 gap-2">
                    <Link
                        :href="route('non-trade-customer.show')"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    >
                        Back
                    </Link>
                    <Button
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Submit
                    </Button>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
