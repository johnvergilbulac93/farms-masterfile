<script setup>
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    item: Object,
});

const form = useForm({
    itemcode: props.item.itemcode,
    description: props.item.description,
    id: props.item.id,
});

const handleUpdate = () => {
    form.post(route("item.update"), {
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
    <Head title="Supplier Edit" />
    <BreezeAuthenticatedLayout>
        <div class="flex justify-center items-center w-full">
            <form @submit.prevent="handleUpdate" class="w-1/2">
                <div class="mt-4">
                    <Label for="itemcode" value="Itemcode" />
                    <Input
                        type="text"
                        class="mt-1 block w-full disabled:opacity-70 disabled:cursor-not-allowed"
                        v-model="form.itemcode"
                        disabled
                    />
                    <small
                        v-if="form.errors.itemcode"
                        class="text-red-500 block"
                        >{{ form.errors.itemcode }}</small
                    >
                </div>
                <div class="mt-4">
                    <Label for="desc" value="Description" />
                    <Input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        tabindex="1"
                        autofocus
                    />
                    <small
                        v-if="form.errors.description"
                        class="text-red-500 block"
                        >{{ form.errors.description }}</small
                    >
                </div>
                <div class="flex justify-end items-center mt-4 gap-2">
                    <Link
                        :href="route('item.show')"
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
