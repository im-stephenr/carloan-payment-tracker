<script setup>
import { onMounted, ref } from "vue";
import MainContainer from "../Components/MainContainer.vue";
import Modal from "../Components/Modal.vue";
import PaymentsListTable from "../Components/PaymentsListTable.vue";
import AuthLayout from "../Layouts/AuthLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    years: Array,
    months: Array,
    paymentsList: Array,
    monthlyAmount: Number,
});

const formType = ref("");
const toast = useToast();
const modalStatus = ref(false);
const currentDate = new Date();
const currentMonthName = currentDate.toLocaleString("default", {
    month: "long",
});
const currentYear = currentDate.getFullYear();

const handleToggleModal = (status) => {
    if (status === "open") {
        modalStatus.value = true;
    } else {
        modalStatus.value = false;
        resetForm();
    }
};

const form = useForm({
    id: null,
    amount_paid: null,
    month_due: currentMonthName,
    year: currentYear,
    paid_date: null,
    receipt_image: null,
    payment_method: null,
});

const resetForm = () => {
    form.id = null;
    form.amount_paid = null;
    form.month_due = currentMonthName;
    form.year = currentYear;
    form.paid_date = null;
    form.receipt_image = null;
    form.payment_method = null;
};

const handleAddPayment = () => {
    formType.value = "add";
    handleToggleModal("open");
};

const handleSubmit = () => {
    if (formType.value === "add") {
        form.post(route("payments-create"), {
            preserveScroll: true,
            onSuccess: () => {
                handleToggleModal("close");
                toast.success("Payment added successfully!");
            },
        });
    } else {
        form.post(route("payments-update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                handleToggleModal("close");
                toast.success("Payment updated successfully!");
            },
        });
    }
};

const handleEdit = (data) => {
    formType.value = "edit";
    handleToggleModal("open");
    form.id = data.id;
    form.amount_paid = data.amount_paid;
    form.month_due = data.month_due;
    form.year = data.year;
    form.paid_date = data.paid_date;
    form.receipt_image = data.receipt_image;
    form.payment_method = data.payment_method;
};

// Original code commented since the freehosting doesn't accepts PUT/DELETE
// const handleDelete = (data) => {
//     if (!confirm("Are you sure you want to delete this payment?")) {
//         return false;
//     }

//     form.delete(route("payments-delete", data.id), {
//         preserveScroll: true,
//         onSuccess: () => {
//             modalStatus.value = false;
//             toast.success("Payment deleted successfully!");
//         },
//     });
// };

const handleDelete = (data) => {
    if (!confirm("Are you sure you want to delete this payment?")) {
        return false;
    }
    form.post(route("payments-delete", data.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalStatus.value = false;
            toast.success("Payment deleted successfully!");
        },
        data: {
            _method: "DELETE",
        },
    });
};

// Set the form receipt image data
const uploadPhoto = (e) => {
    form.receipt_image = e.target.files[0];
};

// Copy monthly amount
const copyMonthlyAmount = () => {
    form.amount_paid = props.monthlyAmount.toLocaleString("en-US", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
};
</script>
<template>
    <Head title="Payments" />
    <AuthLayout>
        <Teleport to="body">
            <Modal
                :handleToggleModal="handleToggleModal"
                :modalStatus="modalStatus"
            >
                <template #header>
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Add Payment
                    </h3>
                </template>
                <template #body>
                    <form
                        class="max-w-sm mx-auto"
                        id="payment_form"
                        @submit.prevent="handleSubmit"
                    >
                        <div class="mb-5">
                            <label
                                for="amount_paid"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Amount</label
                            >
                            <div class="flex gap-2">
                                <input
                                    v-model="form.amount_paid"
                                    type="text"
                                    id="amount_paid"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="0.00"
                                />
                                <button
                                    type="button"
                                    @click.prevent="copyMonthlyAmount"
                                    class="p-2 bg-green-500 hover:bg-green-600 rounded text-white"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <span
                                class="text-xs text-red-500 italic"
                                v-if="form.errors"
                                >{{ form.errors.amount_paid }}</span
                            >
                        </div>
                        <div class="mb-5">
                            <label
                                for="month_due"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Month</label
                            >
                            <select
                                v-model="form.month_due"
                                id="month_due"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option v-for="(month, key) in months">
                                    {{ month }}
                                </option>
                            </select>
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="form.errors"
                                >{{ form.errors.month_due }}</span
                            >
                        </div>
                        <div class="mb-5">
                            <label
                                for="year"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Year</label
                            >
                            <select
                                v-model="form.year"
                                id="year"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option :key="key" v-for="(year, key) in years">
                                    {{ year }}
                                </option>
                            </select>
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="form.errors"
                                >{{ form.errors.year }}</span
                            >
                        </div>
                        <div class="mb-5">
                            <label
                                for="paid_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Date Paid</label
                            >
                            <input
                                type="date"
                                v-model="form.paid_date"
                                name="paid_date"
                                id="paid_date"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" "
                            />
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="form.errors"
                                >{{ form.errors.paid_date }}</span
                            >
                        </div>
                        <div class="mb-5">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input"
                                >Upload Receipt</label
                            >
                            <input
                                @input="uploadPhoto"
                                id="receipt_image"
                                type="file"
                                class="w-full text-slate-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-[#a59a8e] hover:file:bg-[#806446] file:text-white rounded"
                            />
                            <!-- This is from inertiajs feature that automatically pass reactive props from backend -->
                            <span
                                class="text-xs text-red-600"
                                v-if="form.errors"
                                >{{ form.errors.receipt_image }}</span
                            >
                        </div>
                        <div class="mb-5">
                            <label
                                for="payment_method"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Payment Method</label
                            >
                            <select
                                v-model="form.payment_method"
                                id="payment_method"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option>Credit Card</option>
                                <option>Debit Card</option>
                                <option>Gcash</option>
                                <option>Cash</option>
                            </select>
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="form.errors"
                                >{{ form.errors.payment_method }}</span
                            >
                        </div>
                    </form>
                </template>
                <template #footer>
                    <button
                        type="submit"
                        form="payment_form"
                        class="text-white bg-blue-600 p-2 rounded-lg hover:bg-blue-700 text-sm font-medium"
                    >
                        Submit
                    </button>
                </template>
            </Modal>
        </Teleport>
        <MainContainer pageTitle="Payments">
            <button
                @click.prevent="handleAddPayment"
                type="button"
                class="text-white ml-10 bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2 mb-2"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 float-left"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                    />
                </svg>
                Add Payment
            </button>

            <PaymentsListTable
                :actionColumn="true"
                :handleEdit="handleEdit"
                :handleDelete="handleDelete"
                :paymentsList="paymentsList"
            />
        </MainContainer>
    </AuthLayout>
</template>
