<script setup>
import Sidebar from "../Components/Sidebar.vue";
import Header from "../Components/Header.vue";
</script>
<template>
    <Sidebar />
    <Header />
    <div class="flex flex-row flex-wrap flex-1 flex-grow content-start pl-16">
        <slot />
    </div>
</template>
