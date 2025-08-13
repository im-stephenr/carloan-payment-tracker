<script setup></script>
<template>
    <section class="bg-gray-50">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0"
        >
            <a
                href="#"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900"
            >
                <img
                    class="w-10 mr-2"
                    src="../../../storage/app/public/images/caricon.png"
                    alt="logo"
                />
                CLPT
            </a>
            <div
                class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0"
            >
                <slot />
            </div>
        </div>
    </section>
</template>
