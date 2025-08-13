<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import MainContainer from "../Components/MainContainer.vue";
import AuthLayout from "../Layouts/AuthLayout.vue";
import { route } from "../../../vendor/tightenco/ziggy/src/js";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    userInfo: Object,
    otherSettings: Object,
});

const toast = useToast();

const profile_form = useForm({
    user_photo: props.userInfo?.user_photo,
    name: props.userInfo?.name,
});

const other_form = useForm({
    hide_total_dp_flag: props.otherSettings?.hide_total_dp_flag || 0,
    hide_total_paid_flag: props.otherSettings?.hide_total_paid_flag || 0,
    hide_total_balance_flag: props.otherSettings?.hide_total_balance_flag || 0,
    hide_remaining_months_flag:
        props.otherSettings?.hide_remaining_months_flag || 0,
});

const password_form = useForm({
    password_old: null,
    password: null,
    password_confirmation: null,
});

const uploadPhoto = (e) => {
    document.getElementById("user_photo_display").src =
        window.URL.createObjectURL(e.target.files[0]);
    profile_form.user_photo = e.target.files[0];
};

const updateUserProfile = () => {
    profile_form.post(route("settings-update-profile"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Profile Updated Successfully!");
        },
    });
};

const updatePassword = () => {
    password_form.post(route("settings-update-password"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Password Updated Successfully!");
        },
    });
};

const handleCheckboxSettings = (event, category) => {
    other_form[category] = event.target.checked ? 1 : 0;
};

const updateOtherSettings = () => {
    other_form.post(route("settings-update-other"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Other Settings Updated Successfully!");
        },
    });
};
</script>
<template>
    <Head title="Settings" />
    <AuthLayout>
        <MainContainer pageTitle="Settings">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-2">
                <!-- UPDATE PROFILE -->
                <div class="w-full">
                    <form
                        @submit.prevent="updateUserProfile"
                        id="user_profile_form"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    >
                        <div class="mb-4 font-bold text-2xl text-gray-500">
                            Profile
                        </div>
                        <div class="mb-4">
                            <img
                                id="user_photo_display"
                                class="rounded-full w-40 h-40 mx-auto p-1 border-1 border-gray-200"
                                :src="`${
                                    userInfo?.user_photo !== null
                                        ? 'storage/' + userInfo.user_photo
                                        : 'storage/images/anon.png'
                                }`"
                                alt="image description"
                            />
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input"
                                >Upload Profile Photo</label
                            >
                            <input
                                @input="uploadPhoto"
                                id="user_photo"
                                type="file"
                                class="w-full text-slate-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-[#a59a8e] hover:file:bg-[#806446] file:text-white rounded"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="name"
                            >
                                Name
                            </label>
                            <input
                                v-model="profile_form.name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="name"
                                type="text"
                            />
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="profile_form.errors"
                                >{{ profile_form.errors.name }}</span
                            >
                        </div>
                        <div class="mb-4">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="email"
                            >
                                Email
                            </label>
                            <input
                                class="border-none disabled appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                disabled
                                id="email"
                                type="email"
                                :value="`${userInfo.email}`"
                            />
                        </div>
                        <button
                            form="user_profile_form"
                            type="submit"
                            class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2 mb-2"
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
                            Update Profile
                        </button>
                    </form>
                </div>
                <!-- CHANGE PASSWORD -->
                <div class="w-full">
                    <form
                        @submit.prevent="updatePassword"
                        id="update_password_form"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    >
                        <div class="mb-4 font-bold text-2xl text-gray-500">
                            Change Password
                        </div>
                        <div class="mb-6">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="password"
                            >
                                Old Password
                            </label>
                            <input
                                v-model="password_form.password_old"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="password"
                                type="password"
                                placeholder="******************"
                            />
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="password_form.errors"
                                >{{ password_form.errors.password_old }}</span
                            >
                        </div>
                        <div class="mb-6">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="new_password"
                            >
                                New Password
                            </label>
                            <input
                                v-model="password_form.password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="new_password"
                                type="password"
                                placeholder="******************"
                            />
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="password_form.errors"
                                >{{ password_form.errors.password }}</span
                            >
                        </div>
                        <div class="mb-6">
                            <label
                                class="block text-gray-700 text-sm font-bold mb-2"
                                for="confirm_password"
                            >
                                Confirm New Password
                            </label>
                            <input
                                v-model="password_form.password_confirmation"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="confirm_password"
                                type="password"
                                placeholder="******************"
                            />
                            <span
                                class="text-xs text-red-500 italic"
                                v-if="password_form.errors"
                                >{{
                                    password_form.errors.password_confirmation
                                }}</span
                            >
                        </div>
                        <button
                            form="update_password_form"
                            type="submit"
                            class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2 mb-2"
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
                            Update Password
                        </button>
                    </form>
                </div>
                <!-- OTHER SETTINGS -->
                <div class="w-full">
                    <form
                        @submit.prevent="updateOtherSettings"
                        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                    >
                        <div class="mb-4 font-bold text-2xl text-gray-500">
                            Other Settings
                        </div>
                        <div class="mb-6">
                            <label
                                class="inline-flex items-center cursor-pointer"
                            >
                                <input
                                    @change="
                                        handleCheckboxSettings(
                                            $event,
                                            'hide_total_dp_flag'
                                        )
                                    "
                                    type="checkbox"
                                    class="sr-only peer"
                                    :checked="
                                        otherSettings?.hide_total_dp_flag == 1
                                    "
                                />
                                <div
                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
                                ></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Hide Total DP</span
                                >
                            </label>
                        </div>

                        <div class="mb-6">
                            <label
                                class="inline-flex items-center cursor-pointer"
                            >
                                <input
                                    @change="
                                        handleCheckboxSettings(
                                            $event,
                                            'hide_total_paid_flag'
                                        )
                                    "
                                    type="checkbox"
                                    class="sr-only peer"
                                    :checked="
                                        otherSettings?.hide_total_paid_flag == 1
                                    "
                                />
                                <div
                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
                                ></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Hide Total Paid</span
                                >
                            </label>
                        </div>
                        <div class="mb-6">
                            <label
                                class="inline-flex items-center cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="sr-only peer"
                                    @change="
                                        handleCheckboxSettings(
                                            $event,
                                            'hide_total_balance_flag'
                                        )
                                    "
                                    :checked="
                                        otherSettings?.hide_total_balance_flag ==
                                        1
                                    "
                                />
                                <div
                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
                                ></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Hide Total Balance</span
                                >
                            </label>
                        </div>
                        <div class="mb-6">
                            <label
                                class="inline-flex items-center cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="sr-only peer"
                                    @change="
                                        handleCheckboxSettings(
                                            $event,
                                            'hide_remaining_months_flag'
                                        )
                                    "
                                    :checked="
                                        otherSettings?.hide_remaining_months_flag ==
                                        1
                                    "
                                />
                                <div
                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
                                ></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Hide Remaining Months</span
                                >
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2 mb-2"
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
                            Update Other Settings
                        </button>
                    </form>
                </div>
            </div>
        </MainContainer>
    </AuthLayout>
</template>
