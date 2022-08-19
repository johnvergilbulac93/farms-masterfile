<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { watch } from "vue";

let props = defineProps({
    business_units: Array,
});

const form = useForm({
    bu_id: "",
    bu_seq: "",
    cus_code: "",
    cus_name: "",
    cus_type: "",
});
const handleChange = (e) => {
    let id =
        e.target.options[e.target.options.selectedIndex].getAttribute(
            "data-id"
        );
    form.bu_id = id;
    form.cus_code = form.bu_seq;
};
const handleSubmit = () => {
    form.post(route("customer.save"), {
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
    <Head title="Customer Add" />
    <BreezeAuthenticatedLayout>
        <div class="flex justify-center items-center w-full">
            <form @submit.prevent="handleSubmit" class="w-1/2">
                <div class="mt-4">
                    <Label for="bu" value="Business Unit " />
                    <select
                        @change="handleChange"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        v-model="form.bu_seq"
                        tabindex="1"
                        required
                    >
                        <option value="">Select Customer Type</option>
                        <option
                            :data-id="bu.id"
                            :value="bu.seq_code"
                            v-for="(bu, i) in business_units"
                            :key="i"
                        >
                            {{ bu.bu_name }}
                        </option>
                    </select>
                </div>
                <div class="mt-4">
                    <Label for="cus_code" value="Customer Code" />
                    <Input
                        type="text"
                        class="mt-1 block w-full disabled:opacity-70 disabled:cursor-not-allowed"
                        v-model="form.cus_code"
                        tabindex="2"
                        disabled
                    />
                    <small
                        v-if="form.errors.cus_code"
                        class="text-red-500 block"
                        >{{ form.errors.cus_code }}</small
                    >
                    <small class="text-blue-500"
                        >NOTE: Select a business unit to generate customer
                        code.</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="cus_name" value="Customer Name" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.cus_name"
                        tabindex="3"
                        required
                    />
                    <small
                        v-if="form.errors.cus_name"
                        class="text-red-500 block"
                        >{{ form.errors.cus_name }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="cus_type" value="Customer Type" />
                    <select
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        v-model="form.cus_type"
                        tabindex="4"
                        required
                    >
                        <option value="">Select Customer Type</option>
                        <option value="INTERNAL">INTERNAL</option>
                        <option value="EXTERNAL">EXTERNAL</option>
                    </select>
                    <small
                        v-if="form.errors.cus_type"
                        class="text-red-500 block"
                        >{{ form.errors.cus_type }}</small
                    >
                </div>
                <div class="flex justify-end items-center mt-4 gap-2">
                    <Link
                        :href="route('customer.show')"
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
