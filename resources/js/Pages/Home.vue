<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link as InertiaLink } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Homepage" />
        <!-- <TopBar /> -->
        <div class="hero bg-base-300 flex h-screen justify-center">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h1 class="text-5xl font-bold">
                        Sistem Pendukung Keputusan KARYAWAN SAW
                    </h1>
                    <p class="py-6">
                        Didalam sistem ini digunakan algoritma SAW atau yang
                        bisa disingkat dengan <i>Simple Additive Weighting</i>
                    </p>
                    <div class="flex justify-center gap-2">
                        <InertiaLink href="/login"
                            ><a class="btn btn-info"> Login </a></InertiaLink
                        >

                        <InertiaLink href="/rekomendasi">
                            <button class="btn btn-primary">Ranking</button>
                        </InertiaLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
