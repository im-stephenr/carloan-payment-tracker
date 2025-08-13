<script setup>
import AuthLayout from "../Layouts/AuthLayout.vue";
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { route } from "../../../vendor/tightenco/ziggy/src/js";

const toast = useToast();

const form = useForm({
    brand: null,
    model: null,
    variant: null,
    color: null,
    type: null,
    car_nickname: null,
    purchase_date: null,
    paid_down_payment: null,
    monthly_payment_amount: null,
    car_srp: null,
    dealer: null,
    branch: null,
    agent_name: null,
    agent_num: null,
    payment_deadline_day: null,
    term_years: null,
});

const models = ref(null);

const props = defineProps({
    brands: Array,
    carTypes: Array,
});

const handleBrandChange = () => {
    // Get model from that brand
    models.value = props.brands[form.brand];
};

const handleSubmit = () => {
    form.post(route("car-loan-register"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success(
                "Car Loan Registered Successfully! Redirecting to dashboard"
            );
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
</script>
<template>
    <AuthLayout>
        <Head title="Car Loan Register" />
        <div class="w-full p-5">
            <h1 class="text-center mt-10 text-3xl fade-in-text" id="text1">
                Congratulations on your new Car!
            </h1>
            <h1 class="text-center mt-5 text-xl fade-in-text" id="text2">
                Please fill out the required details for your Car Loan.
            </h1>
            <!-- FORM -->
            <form
                @submit.prevent="handleSubmit"
                class="max-w-3xl mx-auto mt-20 fade-in-text"
                id="text3"
            >
                <div class="relative z-0 w-full mb-5 group">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Select Brand</label
                    >
                    <select
                        v-model="form.brand"
                        @change.prevent="handleBrandChange"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option :key="brand" v-for="(model, brand) in brands">
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
                        >Select Model</label
                    >
                    <select
                        v-model="form.model"
                        v-if="models !== null"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option :key="index" v-for="(model, index) in models">
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
                        >Select Car Type</label
                    >
                    <select
                        v-model="form.type"
                        id="carType"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option :key="index" v-for="(type, index) in carTypes">
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
                    <input
                        v-model="form.variant"
                        type="text"
                        name="floating_variant"
                        id="floating_variant"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_variant"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Variant</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.variant }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.color"
                        type="text"
                        name="floating_color"
                        id="floating_color"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_color"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Color</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.color }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.car_nickname"
                        type="text"
                        name="car_nickname"
                        id="car_nickname"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="car_nickname"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Car Nickname (optional)</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.car_nickname }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.purchase_date"
                        type="date"
                        name="purchase_date"
                        id="purchase_date"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="purchase_date"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Date Purchased</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.purchase_date }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        @input="form.car_srp = formatNumber($event)"
                        v-model="form.car_srp"
                        type="text"
                        name="car_srp"
                        id="car_srp"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="car_srp"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >SRP (₱)</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.car_srp }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        @input="form.paid_down_payment = formatNumber($event)"
                        v-model="form.paid_down_payment"
                        type="text"
                        name="paid_down_payment"
                        id="paid_down_payment"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="paid_down_payment"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Down Payment Amount (₱)</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.paid_down_payment }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        @input="
                            form.monthly_payment_amount = formatNumber($event)
                        "
                        v-model="form.monthly_payment_amount"
                        type="text"
                        name="monthly_payment_amount"
                        id="monthly_payment_amount"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="monthly_payment_amount"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Monthly Payment Amount (₱)</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.monthly_payment_amount }}</span
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option
                            v-for="index in 6"
                            :value="`${index}`"
                            :key="index"
                        >
                            {{ index }} {{ index > 1 ? "years" : "year" }}
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
                        >Every which day of the month (Payment Deadline)</label
                    >
                    <select
                        id="payment_deadline_day"
                        v-model="form.payment_deadline_day"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
                        >{{ form.errors.payment_deadline_day }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.dealer"
                        type="text"
                        id="dealer"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="dealer"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Dealer</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.dealer }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.branch"
                        type="text"
                        id="branch"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="branch"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Branch</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.branch }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.agent_name"
                        type="text"
                        id="agent_name"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="agent_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Agent Full Name</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.agent_name }}</span
                    >
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input
                        v-model="form.agent_num"
                        type="text"
                        id="agent_num"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="agent_num"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Agent Contact Number</label
                    >
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.agent_num }}</span
                    >
                </div>

                <button
                    type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Submit
                </button>
            </form>
        </div>
    </AuthLayout>
</template>
