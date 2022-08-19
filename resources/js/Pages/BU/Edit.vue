<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    business_unit: Object,
});

const form = useForm({
    id: props.business_unit.id,
    bu_name: props.business_unit.bu_name,
    bu_code: props.business_unit.bu_code,
    bu_seq_code: props.business_unit.bu_seq_code,
    bu_server: props.business_unit.server,
    bu_type: props.business_unit.bu_type,
});
const handleSubmit = () => {
    form.post(route("bu.update"), {
        onSuccess: (data) => {
            notyf.success({
                message: `${data.props.flash.message}`,
                position: {
                    x: "right",
                    y: "bottom",
                },
            });
        },
    });
};
</script>
<template>
    <Head title="Item Add" />
    <BreezeAuthenticatedLayout>
        <div class="flex justify-center items-center w-full">
            <form @submit.prevent="handleSubmit" class="w-1/2">
                <div class="mt-4">
                    <Label for="bu_code" value="Business Unit Code" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.bu_code"
                        autofocus
                        tabindex="1"
                        required
                    />
                    <small
                        v-if="form.errors.bu_code"
                        class="text-red-500 block"
                        >{{ form.errors.bu_code }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="bu_name" value="Business Unit Name" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.bu_name"
                        required
                        tabindex="2"
                    />
                    <small
                        v-if="form.errors.bu_name"
                        class="text-red-500 block"
                        >{{ form.errors.bu_name }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="bu_seq_code" value="Sequence Code" />
                    <Input
                        type="text"
                        class="mt-1 block w-full placeholder:text-sm"
                        v-model="form.bu_seq_code"
                        maxlength="4"
                        placeholder="e.g PGRY,LILA,BMC"
                        required
                    />
                    <small
                        v-if="form.errors.bu_seq_code"
                        class="text-red-500 block"
                        >{{ form.errors.bu_seq_code }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="server" value="Server" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.bu_server"
                        required
                        tabindex="3"
                    />
                    <small
                        v-if="form.errors.bu_server"
                        class="text-red-500 block"
                        >{{ form.errors.bu_server }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="type" value="Type" />
                    <select
                        class="block w-full text-base font-medium text-gray-600 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        v-model="form.bu_type"
                        tabindex="4"
                        required
                    >
                        <option value="">Select Type</option>
                        <option value="1">AQUA</option>
                        <option value="2">AGRI</option>
                        <option value="3">NON-FARM</option>
                    </select>
                    <small
                        v-if="form.errors.bu_type"
                        class="text-red-500 block"
                        >{{ form.errors.bu_type }}</small
                    >
                </div>
                <div class="flex justify-end items-center mt-4 gap-2">
                    <Link
                        :href="route('bu.show')"
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
