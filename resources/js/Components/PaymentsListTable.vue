<script setup>
const currentDate = new Date();
import Vue3EasyDataTable from "vue3-easy-data-table";

const props = defineProps({
    paymentsList: Array,
    handleEdit: Function,
    handleDelete: Function,
    actionColumn: Boolean,
});

// Amount
// Month
// Year
// Date Paid
// Receipt
// Action

const headers = [
    {
        text: "Amount",
        value: "amount_paid",
    },
    {
        text: "Month",
        value: "month_due",
    },
    {
        text: "Year",
        value: "year",
    },
    {
        text: "Date Paid",
        value: "paid_date",
    },
    {
        text: "Payment Method",
        value: "payment_method",
    },
    {
        text: "Receipt",
        value: "receipt_image",
    },
];
// Show/Hide action column
if (props.actionColumn !== false) {
    headers.push({
        text: "Action",
        value: "actions",
        sortable: false,
    });
}
</script>
<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <Vue3EasyDataTable
            class="mt-10"
            :theme-color="'#99BC85'"
            :headers="headers"
            :items="paymentsList"
        >
            <!-- IMAGE COLUMN -->
            <template #item-receipt_image="item">
                <img
                    v-if="
                        item.receipt_image !== null && item.receipt_image != ''
                    "
                    :src="`storage/${item.receipt_image}`"
                    width="100"
                    class="p-1 border-1 border-gray-300 rounded m-1"
                />
            </template>
            <!-- ACTIONS COLUMN -->
            <template #item-actions="item" v-if="actionColumn !== false">
                <button
                    @click="handleEdit(item)"
                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                        />
                    </svg>
                </button>
                <button
                    @click="handleDelete(item)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 ml-2 rounded cursor-pointer"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        />
                    </svg>
                </button>
            </template>
        </Vue3EasyDataTable>
    </div>
</template>
