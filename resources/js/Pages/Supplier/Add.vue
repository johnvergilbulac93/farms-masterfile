<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    sequence: Number,
});

const form = useForm({
    sup_code: props.sequence,
    sup_name: "",
    sup_addr: "",
});
const handleSubmit = () => {
    form.post(route("supplier.save"), {
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
    <Head title="Supplier Add" />
    <BreezeAuthenticatedLayout>
        <div class="flex justify-center items-center w-full">
            <form @submit.prevent="handleSubmit" class="w-1/2">
                <div class="mt-4">
                    <Label for="sup_code" value="Supplier Code" />
                    <Input
                        type="text"
                        class="mt-1 block w-full disabled:opacity-70 disabled:cursor-not-allowed"
                        v-model="form.sup_code"
                        disabled
                    />
                    <small
                        v-if="form.errors.sup_code"
                        class="text-red-500 block"
                        >{{ form.errors.sup_code }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="sup_name" value="Supplier Name" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.sup_name"
                        tabindex="1"
                    />
                    <small
                        v-if="form.errors.sup_name"
                        class="text-red-500 block"
                        >{{ form.errors.sup_name }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="sup_addr" value="Supplier Address" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.sup_addr"
                        tabindex="2"
                    />
                    <small
                        v-if="form.errors.sup_addr"
                        class="text-red-500 block"
                        >{{ form.errors.sup_addr }}</small
                    >
                </div>

                <div class="flex justify-end items-center mt-4 gap-2">
                    <Link
                        :href="route('supplier.show')"
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
