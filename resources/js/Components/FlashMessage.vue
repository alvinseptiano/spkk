<!-- <script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const page = usePage();
const showToast = ref(false);

// Watch the flash message and set the toast visibility
// watch(
//     () => page.props.flash.message,
//     (message) => {
//         if (message) {
//             // await nextTick();
//             showToast.value = true;
//             setTimeout(() => {
//                 showToast.value = false;
//             }, 40000); // 3 seconds
//         }
//     },
//     { immediate: true },
// );
</script>

<template>
    <div v-if="showToast" class="toast toast-top toast-end z-50">
        <div class="alert alert-info">
            <span>{{ page.props.flash.message }}</span>
        </div>
    </div>
</template> -->
<!-- Toast Component -->
<script setup>
defineProps({
    show: Boolean,
    message: String,
});
</script>

<template>
    <div v-if="show" class="toast toast-top toast-end z-50">
        <div class="alert alert-info min-h-24 min-w-[300px]">
            <span>{{ message }}</span>
        </div>
    </div>
</template>
