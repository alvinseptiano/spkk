<script setup>
import TopBar from '@/Components/TopBar.vue';
import { ref, watch } from 'vue';

const isOpen = ref(localStorage.getItem('sidebarOpen') === 'true' || false);

watch(isOpen, (newValue) => {
    localStorage.setItem('sidebarOpen', newValue);
});
</script>

<template>
    <div class="bg-base-100 fixed size-full min-h-svh">
        <div
            class="bg-base-300 fixed top-0 right-0 left-0 z-50 m-4 mx-8 mt-8 rounded-lg"
        >
            <TopBar />
        </div>

        <div class="flex flex-row justify-between pt-24">
            <main class="max-h-[86vh] w-full flex-1 overflow-auto p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
