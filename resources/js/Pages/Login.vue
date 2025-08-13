<script setup>
import { useForm } from "@inertiajs/vue3";
import { route } from "../../../vendor/tightenco/ziggy/src/js";
import GuestLayout from "../Layouts/GuestLayout.vue";
import { onMounted, ref } from "vue";

const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const handleSubmit = () => {
    form.post(route("login"), {
        preserveScroll: true,
        onSuccess: () => {
            console.log("Submitted!");
        },
    });
};

const deferredPrompt = ref(null);
const canInstall = ref(false);

onMounted(() => {
    console.log("Mounted and waiting for beforeinstallprompt...");
    window.addEventListener("beforeinstallprompt", (e) => {
        console.log("beforeinstallprompt event fired");
        e.preventDefault();
        deferredPrompt.value = e;
        canInstall.value = true;
    });
});

const handleInstallApp = async () => {
    if (!deferredPrompt.value) {
        console.warn("No install prompt available");
        return;
    }

    deferredPrompt.value.prompt();

    const result = await deferredPrompt.value.userChoice;
    console.log("User response to install:", result);

    deferredPrompt.value = null;
    canInstall.value = false;
};

onMounted(() => {
    setTimeout(() => {
        window.addEventListener("beforeinstallprompt", (e) => {
            e.preventDefault();
            deferredPrompt.value = e;
            canInstall.value = true;
        });
    }, 2000);
});
</script>
<template>
    <Head title="Login" />
    <GuestLayout>
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1
                class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl"
            >
                Sign in to your account
            </h1>
            <form
                @submit.prevent="handleSubmit"
                class="space-y-4 md:space-y-6"
                action="#"
            >
                <div>
                    <label
                        for="email"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Your email</label
                    >
                    <input
                        type="email"
                        name="email"
                        id="email"
                        v-model="form.email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
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
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Password</label
                    >
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        v-model="form.password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                        required=""
                    />
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="remember"
                                aria-describedby="remember"
                                type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"
                                v-model="form.remember"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500"
                                >Remember me</label
                            >
                        </div>
                    </div>
                    <a
                        href="#"
                        class="text-sm font-medium text-blue-600 hover:underline"
                        >Forgot password?</a
                    >
                </div>
                <button
                    type="submit"
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Sign in
                </button>
                <p class="text-sm font-light text-gray-500">
                    Don’t have an account yet?
                    <Link
                        :href="route('register')"
                        preserve-scroll
                        class="font-medium text-blue-600 hover:underline"
                        >Sign up</Link
                    >
                </p>
            </form>
            <div v-if="canInstall">
                <button
                    type="button"
                    @click.prevent="handleInstallApp"
                    class="w-full flex justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"
                        />
                    </svg>

                    Install App
                </button>
            </div>
        </div>
    </GuestLayout>
</template>
