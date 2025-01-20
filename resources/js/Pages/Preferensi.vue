<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowLeftCircleIcon } from '@heroicons/vue/24/solid';
import { Head, Link as InertiaLink } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const tableData = ref(null);
const isLoading = ref(true);

const fetchItems = async () => {
    try {
        const response = await axios.get('/saw/calculate');
        tableData.value = response.data.data;
    } catch (error) {
        console.error('Error fetching items:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchItems();
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Preferensi" />
        <InertiaLink href="/matrix" class="btn btn-primary mb-10">
            <ArrowLeftCircleIcon class="size-5" />
            Kembali
        </InertiaLink>
        <!-- Loading State -->
        <div v-if="isLoading" class="flex h-64 items-center justify-center">
            <p>Loading data...</p>
        </div>

        <!-- Tables -->
        <div v-else>
            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['matrix']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, key) in tableData['matrix'][1]"
                                :key="key"
                                class="text-center"
                            >
                                C{{ key }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index) in tableData['matrix']"
                            :key="index"
                        >
                            <td>A{{ index }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ child }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['weighted']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, key) in tableData['matrix'][1]"
                                :key="key"
                                class="text-center"
                            >
                                C{{ key }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index) in tableData['weighted']"
                            :key="index"
                        >
                            <td>A{{ index }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ parseFloat(child).toFixed(3) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['normalization']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th
                                v-for="(value, key) in tableData['matrix'][1]"
                                :key="key"
                                class="text-center"
                            >
                                C{{ key }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index) in tableData['normalization']"
                            :key="index"
                        >
                            <td>A{{ index }}</td>
                            <td v-for="(child, key) in item" :key="key">
                                {{ parseFloat(child).toFixed(3) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex overflow-auto"
                v-if="tableData && tableData['ranking']"
            >
                <table class="table-pin-cols table">
                    <thead class="bg-base-300 text-center text-lg font-bold">
                        <tr>
                            <th style="width: 25%">Alternatif</th>
                            <th style="width: 25%">Nama</th>
                            <th style="width: 25%">Nilai</th>
                            <th style="width: 25%">Ranking</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr
                            v-for="(item, index) in tableData['ranking']"
                            :key="item.id"
                        >
                            <td>A{{ index + 1 }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ parseFloat(item.score).toFixed(3) }}</td>
                            <td class="font-bold">{{ item.rank }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
