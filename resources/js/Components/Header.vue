<script setup>
import { ref } from "vue";
import { route } from "../../../vendor/tightenco/ziggy/src/js";

const toggleMenuStatus = ref(false);

const handleToggleMenu = () => {
    if (!toggleMenuStatus.value) {
        toggleMenuStatus.value = true;
    } else {
        toggleMenuStatus.value = false;
    }
};
</script>
<template>
    <div class="h-40 lg:h-20 w-full flex flex-wrap">
        <nav
            id="header1"
            class="bg-gray-[#CF0F47] w-auto flex-1 border-b-1 border-gray-300 order-1 lg:order-2"
        >
            <div class="flex h-full justify-between items-center">
                <div class="relative w-full px-6">
                    <div class="w-fit mx-auto flex">
                        <img
                            class="w-10 h-auto mr-2"
                            src="../../../storage/app/public/images/caricon.png"
                            alt="logo"
                        />
                        <h3 class="text-3xl text-center text-shadow-lg">
                            CLPT
                        </h3>
                    </div>
                </div>
                <!--Menu-->
                <div class="flex relative pr-6">
                    <div class="relative text-sm">
                        <button
                            id="userButton"
                            class="flex items-center focus:outline-none mr-3"
                            @click.prevent="handleToggleMenu"
                        >
                            <img
                                class="w-8 h-8 rounded-full mr-4"
                                :src="`${
                                    $page.props.auth.user.user_photo !== null
                                        ? 'storage/' +
                                          $page.props.auth.user.user_photo
                                        : 'storage/images/anon.png'
                                }`"
                                alt="Avatar of User"
                            />
                            <span class="hidden md:inline-block"
                                >Hi, {{ $page.props.auth.user.name }}
                            </span>
                            <svg
                                class="pl-2 h-2"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 129 129"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                enable-background="new 0 0 129 129"
                            >
                                <g>
                                    <path
                                        d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"
                                    ></path>
                                </g>
                            </svg>
                        </button>
                        <div
                            id="userMenu"
                            :class="`bg-white nunito rounded shadow-md absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 ${
                                !toggleMenuStatus ? 'invisible' : ''
                            }`"
                        >
                            <ul class="list-reset">
                                <li>
                                    <a
                                        :href="route('settings')"
                                        class="px-4 py-2 block text-gray-900 hover:bg-red-400 hover:text-white no-underline hover:no-underline"
                                        >Settings</a
                                    >
                                </li>
                                <li>
                                    <hr class="border-t mx-2 border-gray-400" />
                                </li>
                                <li>
                                    <Link
                                        :href="route('logout')"
                                        class="px-4 py-2 block text-gray-900 hover:bg-red-400 hover:text-white no-underline hover:no-underline"
                                        >Logout</Link
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- / Menu -->
            </div>
        </nav>
    </div>
</template>
