<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Reactive variables
const tableData = ref(null);
const alternativeData = ref({});
const criteriaData = ref([]);
const subcriteriaData = ref([]);
const scoreData = ref([]);

// Function to fetch data
const fetchItems = async () => {
    try {
        const dataResponse = await axios.get('/getdata');
        tableData.value = dataResponse.data.data;
        alternativeData.value = tableData.value.alternative;
        criteriaData.value = tableData.value.criteria;
        subcriteriaData.value = tableData.value.subcriteria;
        scoreData.value = tableData.value.score;
    } catch (error) {
        console.error('Error fetching items:', error);
    }
};

// Lifecycle hook
onMounted(async () => {
    await fetchItems();
});
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium">Nilai Karyawan</h2>
            <p class="mt-1 text-sm">Disini rangkuman nilai anda:</p>
            <div class="container flex items-center justify-end pt-4"></div>
        </header>

        <!-- Alternative Data -->
        <ul>
            ID:
            <b>{{ alternativeData.id }}</b>
        </ul>
        <ul>
            Nama Lengkap:
            <b>{{ alternativeData.name }}</b>
        </ul>
        <ul>
            Tanggal Lahir:
            <b>{{
                new Date(alternativeData.dob).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                })
            }}</b>
        </ul>
        <ul>
            Jabatan:
            <b>{{ alternativeData.role }}</b>
        </ul>

        <!-- Scores Header -->
        <header>
            <h2>Nilai:</h2>
        </header>

        <!-- Score Table -->
        <div class="flex-center mb-20">
            <div class="flex-center container items-center">
                <table class="table-bordered table items-center">
                    <thead>
                        <th
                            v-for="criterion in criteriaData"
                            :key="criterion.id"
                            class="text-center"
                        >
                            {{ criterion.name }}
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td v-for="(item, index) in scoreData">
                                {{ item.value }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</template>
