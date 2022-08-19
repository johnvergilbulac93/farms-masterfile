<script setup>
const props = defineProps({
    item: Number,
    customer: Number,
    supplier: Number,
    business_unit: Number,
});
</script>

<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <div class="flex flex-wrap">
            <Card
                :image="`/images/supplier.png`"
                :link="`/supplier`"
                :count="supplier"
                :title="`SUPPLIER`"
            />
            <Card
                :image="`/images/customer.png`"
                :link="`/customer`"
                :count="customer"
                :title="`CUSTOMER`"
            />
            <Card
                :image="`/images/item.png`"
                :link="`/item`"
                :count="item"
                :title="`ITEM`"
            />
            <Card
                :image="`/images/bu.png`"
                :link="`/business-unit`"
                :count="business_unit"
                :title="`BUSINESS UNIT`"
            />
        </div>
        <div class="flex">
            <Card2
                :image="`/images/www.png`"
                :link="`http://172.16.161.37/uploading-ar`"
                :title="`DC Middleware`"
            />
            <Card2
                :image="`/images/www.png`"
                :link="`http://172.16.161.43/onlinetorrfs/index2`"
                :title="`TOR and RFS`"
            />
        </div>
    </BreezeAuthenticatedLayout>
</template>
