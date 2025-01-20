<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { ExclamationTriangleIcon } from '@heroicons/vue/24/solid';

// Refs
const currentPath = ref('');
const items = ref([]);
const showNewFolderModal = ref(false);
const newFolderName = ref('');
const fileInput = ref(null);

// Computed
const pathSegments = computed(() => {
    return currentPath.value ? currentPath.value.split('/') : [];
});

// Methods
const fetchItems = async () => {
    try {
        const response = await axios.get(
            `/api/file-manager?path=${currentPath.value}`,
        );
        items.value = response.data.items;
    } catch (error) {
        console.error('Error fetching items:', error);
    }
};

const navigateToPath = (path) => {
    currentPath.value = path;
    fetchItems();
};

const getPathUpToIndex = (index) => {
    return pathSegments.value.slice(0, index + 1).join('/');
};

const handleFileUpload = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);
    formData.append('path', currentPath.value);

    try {
        await axios.post('/api/file-manager/upload', formData);
        fetchItems();
    } catch (error) {
        console.error('Error uploading file:', error);
    }
};

const createFolder = async () => {
    if (!newFolderName.value) return;

    try {
        await axios.post('/api/file-manager/create-directory', {
            path: currentPath.value,
            name: newFolderName.value,
        });
        showNewFolderModal.value = false;
        newFolderName.value = '';
        fetchItems();
    } catch (error) {
        console.error('Error creating folder:', error);
    }
};

const deleteItem = async (item) => {
    if (!confirm(`Are you sure you want to delete ${item.name}?`)) return;

    try {
        await axios.delete('/api/file-manager/delete', {
            data: {
                path: item.path,
                is_file: item.is_file,
            },
        });
        fetchItems();
    } catch (error) {
        console.error('Error deleting item:', error);
    }
};

const downloadFile = (path) => {
    window.location.href = `/api/file-manager/download/${encodeURIComponent(path)}`;
};

const formatSize = (bytes) => {
    const units = ['B', 'KB', 'MB', 'GB'];
    let size = bytes;
    let unitIndex = 0;

    while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024;
        unitIndex++;
    }

    return `${size.toFixed(1)} ${units[unitIndex]}`;
};

const formatDate = (timestamp) => {
    return new Date(timestamp * 1000).toLocaleString();
};

// Lifecycle
onMounted(() => {
    fetchItems();
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-col gap-4">
            <div class="file-manager flex flex-col overflow-auto">
                <div class="my-4 flex-1 items-center justify-between">
                    <!-- File error -->
                    <div v-if="true" class="mb-4 block">
                        <div role="alert" class="alert">
                            <ExclamationTriangleIcon
                                class="text-error h-5 w-5"
                            />
                            <span>Error Request</span>
                        </div>
                    </div>
                    <div class="breadcrumbs bg-base-200 rounded-lg text-lg">
                        <ul class="flex items-center">
                            <li>
                                <button
                                    @click="navigateToPath('')"
                                    class="text-accent px-2 text-lg"
                                >
                                    ..
                                </button>
                            </li>
                            <li>
                                <template
                                    v-for="(segment, index) in pathSegments"
                                    :key="index"
                                >
                                    <button
                                        @click="
                                            navigateToPath(
                                                getPathUpToIndex(index),
                                            )
                                        "
                                        class="text-accent px-2 text-lg"
                                    >
                                        {{ segment }}
                                    </button>
                                </template>
                            </li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input
                                type="file"
                                ref="fileInput"
                                @change="handleFileUpload"
                                class="hidden"
                            />
                        </div>

                        <button
                            @click="showNewFolderModal = true"
                            class="rounded p-2"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="pi pi-trash"></div>
                                <div class="pi pi-download mr-5"></div>
                                <div class="pi pi-folder-plus"></div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Files and Folders List -->
                <div class="bg-base-100 rounded-lg">
                    <div class="overflow-auto">
                        <table
                            class="table-pin-rows table-sm z-10 table w-full"
                        >
                            <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input
                                                type="checkbox"
                                                class="checkbox"
                                            />
                                        </label>
                                    </th>
                                    <th
                                        class="py-3 text-left text-xs font-medium uppercase"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="py-3 text-left text-xs font-medium uppercase"
                                    >
                                        Size
                                    </th>
                                    <th
                                        class="py-3 text-left text-xs font-medium uppercase"
                                    >
                                        Last Modified
                                    </th>
                                    <th
                                        class="py-3 text-left text-xs font-medium uppercase"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="item in items"
                                    :key="item.path"
                                    class="hover bg-base-200"
                                >
                                    <td>
                                        <label>
                                            <input
                                                type="checkbox"
                                                class="checkbox"
                                            />
                                        </label>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <span
                                                v-if="item.is_file"
                                                class="pi pi-file mr-2"
                                            ></span>
                                            <span
                                                v-else
                                                class="pi pi-folder mr-2"
                                            ></span>
                                            <button
                                                @click="
                                                    item.is_file
                                                        ? downloadFile(
                                                              item.path,
                                                          )
                                                        : navigateToPath(
                                                              item.path,
                                                          )
                                                "
                                                class="text-sm"
                                            >
                                                {{ item.name }}
                                            </button>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm">
                                        {{
                                            item.is_file
                                                ? formatSize(item.size)
                                                : '-'
                                        }}
                                    </td>
                                    <td class="py-4 text-sm">
                                        {{
                                            item.is_file
                                                ? formatDate(item.last_modified)
                                                : '-'
                                        }}
                                    </td>
                                    <td class="py-4 text-sm">
                                        <div class="dropdown dropdown-end">
                                            <button
                                                tabindex="0"
                                                class="pi pi-ellipsis-v"
                                            ></button>
                                            <ul
                                                tabindex="0"
                                                class="menu dropdown-content rounded-box bg-base-200 p-2 shadow"
                                            >
                                                <li>
                                                    <button
                                                        @click="
                                                            downloadFile(
                                                                item.path,
                                                            )
                                                        "
                                                        v-if="item.is_file"
                                                    >
                                                        Download
                                                    </button>
                                                </li>
                                                <li>
                                                    <button
                                                        @click="
                                                            deleteItem(item)
                                                        "
                                                        class="text-error"
                                                    >
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- New Folder Modal -->
            <dialog :class="['modal', { 'modal-open': showNewFolderModal }]">
                <div class="modal-box">
                    <h3 class="mb-4 text-lg font-medium">Create New Folder</h3>
                    <div class="modal-action">
                        <form method="dialog" class="w-full">
                            <input
                                v-model="newFolderName"
                                type="text"
                                placeholder="Folder name"
                                class="mb-4 w-full rounded border px-3 py-2"
                            />
                            <div class="flex justify-end gap-2">
                                <button
                                    @click="showNewFolderModal = false"
                                    class="btn btn-error"
                                >
                                    Close
                                </button>
                                <button
                                    @click="createFolder"
                                    class="btn btn-success"
                                >
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </dialog>
        </div>
    </AuthenticatedLayout>
</template>
