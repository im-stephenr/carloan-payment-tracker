<script setup>
const props = defineProps({
    modalStatus: Boolean,
    handleToggleModal: Function,
});
</script>
<template>
    <!-- Main modal -->
    <Transition v-if="modalStatus" name="modal">
        <div class="modal-mask overflow-y-scroll">
            <div class="modal-container relative">
                <div
                    class="modal-header flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200"
                >
                    <slot name="header">Modal</slot>
                    <button
                        @click.prevent="handleToggleModal('close')"
                        type="button"
                        class="cursor-pointer absolute right-[10px] top-[10px]"
                        title="Close Modal"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="size-4 text-gray-400 hover:text-gray-700"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <div class="modal-body p-4 md:p-5 space-y-4">
                    <slot name="body">No Content</slot>
                </div>

                <div
                    class="modal-footer flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"
                >
                    <slot name="footer">
                        Footer
                        <button
                            type="button"
                            class="modal-default-button bg-blue-500 py-1 px-4 text-white"
                        >
                            OK
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </Transition>
</template>
