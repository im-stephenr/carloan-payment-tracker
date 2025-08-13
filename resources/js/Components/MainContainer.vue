<script setup>
defineProps({
    pageTitle: String,
});
</script>
<template>
    <div id="main-content" class="w-full flex-1 bg-white">
        <div class="flex flex-1 flex-wrap">
            <div class="w-full">
                <!--"Container" for the graphs"-->
                <div class="max-w-full">
                    <div class="border-b p-3">
                        <h5 class="font-bold text-black">{{ pageTitle }}</h5>
                    </div>
                    <div class="p-5">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
