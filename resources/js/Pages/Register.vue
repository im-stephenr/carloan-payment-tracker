<script setup>
import { useForm } from "@inertiajs/vue3";
import { route } from "../../../vendor/tightenco/ziggy/src/js";
import GuestLayout from "../Layouts/GuestLayout.vue";

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
});

const handleSubmit = () => {
    form.post(route("register"), {
        preserveScroll: true,
        onSuccess: () => {
            console.log("SUBMITTED");
        },
    });
};
</script>
<template>
    <Head title="Register" />
    <GuestLayout>
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1
                class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
            >
                Create new account
            </h1>
            <form
                @submit.prevent="handleSubmit"
                class="space-y-4 md:space-y-6"
                action="#"
            >
                <div>
                    <label
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your email</label
                    >
                    <input
                        type="email"
                        name="email"
                        v-model="form.email"
                        id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="email@email.com"
                        required=""
                    />
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.email }}</span
                    >
                </div>
                <div>
                    <label
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Your Name</label
                    >
                    <input
                        type="text"
                        name="name"
                        id="name"
                        v-model="form.name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Juan Dela Cruz"
                        required=""
                    />
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.name }}</span
                    >
                </div>
                <div>
                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Password</label
                    >
                    <input
                        type="password"
                        name="password"
                        id="password"
                        v-model="form.password"
                        placeholder="••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required=""
                    />
                    <span
                        class="text-xs text-red-500 italic"
                        v-if="form.errors"
                        >{{ form.errors.password }}</span
                    >
                </div>
                <div>
                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        placeholder="••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required=""
                    />
                </div>

                <button
                    type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Submit
                </button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        preserve-scroll
                        class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                        >Login</Link
                    >
                </p>
            </form>
        </div>
    </GuestLayout>
</template>
