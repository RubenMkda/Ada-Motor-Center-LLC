<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-primary 
                              border-gray-300 rounded-md font-semibold text-xs
                             text-gray-700 uppercase tracking-widest shadow-sm 
                            hover:bg-greenBold hover:text-gray-100 focus:outline-none 
                            disabled:opacity-25 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
