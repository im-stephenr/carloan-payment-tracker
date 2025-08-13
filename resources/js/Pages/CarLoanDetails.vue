<script setup>
import AuthLayout from "../Layouts/AuthLayout.vue";
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { route } from "../../../vendor/tightenco/ziggy/src/js";

const props = defineProps({
    brands: Object,
    carTypes: Object,
    carLoanDetails: Object,
});

const toast = useToast();

const form = useForm({
    id: props.carLoanDetails.id,
    brand: props.carLoanDetails.brand,
    model: props.carLoanDetails.model,
    variant: props.carLoanDetails.variant,
    color: props.carLoanDetails.color,
    type: props.carLoanDetails.type,
    car_nickname: props.carLoanDetails.car_nickname,
    purchase_date: props.carLoanDetails.purchase_date,
    paid_down_payment: props.carLoanDetails.paid_down_payment,
    monthly_payment_amount: props.carLoanDetails.monthly_payment_amount,
    car_srp: props.carLoanDetails.car_srp,
    dealer: props.carLoanDetails.dealer,
    branch: props.carLoanDetails.branch,
    agent_name: props.carLoanDetails.agent_name,
    agent_num: props.carLoanDetails.agent_num,
    payment_deadline_day: props.carLoanDetails.payment_deadline_day,
    term_years: props.carLoanDetails.term_years,
});

const models = ref(null);

const handleBrandChange = () => {
    // Get model from that brand
    models.value = props.brands[form.brand];
};
// Original code commented since the freehosting doesn't accepts PUT/DELETE
// const handleSubmit = () => {
//     form.put(route("car-loan-details"), {
//         preserveScroll: true,
//         onSuccess: () => {
//             toast.success("Car Loan Details Updated Successfully!");
//         },
//     });
// };

const handleSubmit = () => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("car-loan-details"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Car Loan Details Updated Successfully!");
        },
    });
};

// Suffix
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("payment_deadline_day");
    const options = select.querySelectorAll("option");

    options.forEach((option) => {
        const num = parseInt(option.textContent);
        let suffix = "th";

        if (num % 100 >= 11 && num % 100 <= 13) {
            suffix = "th"; // 11th, 12th, 13th
        } else {
            switch (num % 10) {
                case 1:
                    suffix = "st";
                    break;
                case 2:
                    suffix = "nd";
                    break;
                case 3:
                    suffix = "rd";
                    break;
            }
        }

        option.textContent = num + suffix;
    });
});

const formatNumber = (input) => {
    let value = typeof input === "object" ? input.target.value : input;

    // Remove all commas
    value = value.replace(/,/g, "");

    // Validate numeric format (digits + optional one decimal point)
    if (!/^\d*\.?\d*$/.test(value)) return "";

    // Split into integer and decimal parts
    const [integerPart, decimalPart] = value.split(".");

    // Format integer part
    const formattedInt = integerPart
        ? parseInt(integerPart, 10).toLocaleString("en-US")
        : "";

    // Return full formatted string
    return decimalPart !== undefined
        ? `${formattedInt}.${decimalPart}`
        : formattedInt;
};

onMounted(function () {
    handleBrandChange(props.carLoanDetails.brand);
});
</script>
<template>
    <AuthLayout>
        <Head title="Car Loan Details" />
        <div class="w-full">
            <div class="w-full p-10 flex">
                <h3 class="text-3xl font-medium text-shadow-xs">
                    Car Loan Details
                </h3>
            </div>
            <form id="carLoanForm" @submit.prevent="handleSubmit">
                <div
                    class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 w-full"
                >
                    <!-- CAR -->
                    <div class="p-2">
                        <div
                            class="w-full pt-5 pr-10 pb-10 pl-10 mx-auto bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100"
                        >
                            <h1 class="font-bold text-md">Car</h1>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="countries"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Brand</label
                                >
                                <select
                                    v-model="form.brand"
                                    @change.prevent="handleBrandChange"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option
                                        :key="brand"
                                        v-for="(model, brand) in brands"
                                    >
                                        {{ brand }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.brand }}</span
                                >
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="countries"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Model</label
                                >
                                <select
                                    v-model="form.model"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option
                                        :key="index"
                                        v-for="(model, index) in models"
                                    >
                                        {{ model }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.model }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="carType"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Car Type</label
                                >
                                <select
                                    v-model="form.type"
                                    id="carType"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option
                                        :key="index"
                                        v-for="(type, index) in carTypes"
                                    >
                                        {{ type }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.type }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="variant"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Variant</label
                                >
                                <input
                                    v-model="form.variant"
                                    type="text"
                                    id="variant"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.variant }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="color"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Color</label
                                >
                                <input
                                    v-model="form.color"
                                    type="text"
                                    id="color"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.color }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="car_nickname"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Nickname</label
                                >
                                <input
                                    v-model="form.car_nickname"
                                    type="text"
                                    id="car_nickname"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.car_nickname }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <!-- LOAN -->
                    <div class="p-2">
                        <div
                            class="w-full pt-5 pr-10 pb-10 pl-10 mx-auto bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100"
                        >
                            <h1 class="font-bold text-md">Loan</h1>

                            <div class="relative z-0 w-full mt-2 mb-5 group">
                                <label
                                    for="purchase_date"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Purchase Date</label
                                >
                                <input
                                    v-model="form.purchase_date"
                                    type="date"
                                    id="purchase_date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.purchase_date }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="car_srp"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >SRP</label
                                >
                                <input
                                    v-model="form.car_srp"
                                    @input="form.car_srp = formatNumber($event)"
                                    type="text"
                                    id="car_srp"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.car_srp }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="paid_down_payment"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Paid Down Payment</label
                                >
                                <input
                                    v-model="form.paid_down_payment"
                                    @input="
                                        form.paid_down_payment =
                                            formatNumber($event)
                                    "
                                    type="text"
                                    id="paid_down_payment"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.paid_down_payment }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="monthly_payment_amount"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Monthly Payment Amount</label
                                >
                                <input
                                    v-model="form.monthly_payment_amount"
                                    @input="
                                        form.monthly_payment_amount =
                                            formatNumber($event)
                                    "
                                    type="text"
                                    id="monthly_payment_amount"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.paid_down_payment }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="term_years"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Term (years)</label
                                >
                                <select
                                    v-model="form.term_years"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option
                                        v-for="index in 6"
                                        :value="`${index}`"
                                        :key="index"
                                    >
                                        {{ index }}
                                        {{ index > 1 ? "years" : "year" }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.term_years }}</span
                                >
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <label
                                    for="payment_deadline_day"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Every which day of the month (Payment
                                    Deadline)</label
                                >
                                <select
                                    id="payment_deadline_day"
                                    v-model="form.payment_deadline_day"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                >
                                    <option
                                        v-for="index in 31"
                                        :value="`${index}`"
                                        :key="index"
                                    >
                                        {{ index }}
                                    </option>
                                </select>
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{
                                        form.errors.payment_deadline_day
                                    }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <!-- DEALER -->
                    <div class="p-2">
                        <div
                            class="w-full pt-5 pr-10 pb-10 pl-10 mx-auto bg-white border border-gray-200 rounded-lg shadow-sm md:flex-row md:max-w-xl hover:bg-gray-100"
                        >
                            <h1 class="font-bold text-md">Dealer</h1>

                            <div class="relative mt-2 z-0 w-full mb-5 group">
                                <label
                                    for="dealer"
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                    >Dealer</label
                                >
                                <input
                                    v-model="form.dealer"
                                    type="text"
                                    id="dealer"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.dealer }}</span
                                >
                            </div>

                            <div class="relative mt-2 z-0 w-full mb-5 group">
                                <label
                                    for="branch"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Branch</label
                                >
                                <input
                                    v-model="form.branch"
                                    type="text"
                                    id="branch"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.branch }}</span
                                >
                            </div>

                            <div class="relative mt-2 z-0 w-full mb-5 group">
                                <label
                                    for="agent_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Agent Name</label
                                >
                                <input
                                    v-model="form.agent_name"
                                    type="text"
                                    id="agent_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.agent_name }}</span
                                >
                            </div>

                            <div class="relative mt-2 z-0 w-full mb-5 group">
                                <label
                                    for="agent_num"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Agent Contact Number</label
                                >
                                <input
                                    v-model="form.agent_num"
                                    type="text"
                                    id="agent_num"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                />
                                <span
                                    class="text-xs text-red-500 italic"
                                    v-if="form.errors"
                                    >{{ form.errors.agent_num }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="mt-10 w-full">
                <button
                    form="carLoanForm"
                    type="submit"
                    class="text-white ml-10 bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2 mb-2"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-floppy mr-2"
                        viewBox="0 0 16 16"
                    >
                        <path d="M11 2H9v3h2z" />
                        <path
                            d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"
                        />
                    </svg>
                    Update
                </button>
            </div>
        </div>
    </AuthLayout>
</template>
