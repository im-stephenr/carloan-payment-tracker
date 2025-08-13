<script setup>
const props = defineProps({
    icon: String,
    textInfo: String,
    description: String,
});
</script>
<template>
    <div class="w-1/2 lg:w-full">
        <div
            class="border-2 border-gray-400 border-dashed hover:border-transparent hover:bg-white hover:shadow-xl rounded p-6 m-2 md:mx-10 md:my-6"
        >
            <div class="flex flex-col items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-3 bg-gray-300">
                        <slot name="icon"></slot>
                    </div>
                </div>
                <div class="flex-1">
                    <h3
                        class="font-bold text-md lg:text-3xl text-center text-gray-700"
                    >
                        {{ textInfo }}
                    </h3>
                    <h5 class="font-bold text-gray-500">{{ description }}</h5>
                </div>
            </div>
        </div>
    </div>
</template>
