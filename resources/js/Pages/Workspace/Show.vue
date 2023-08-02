<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const photoPreview = ref(null);
const photoInput = ref(null);

const props = defineProps({
    workspace: Object,
    tasks: Array
})

const form = useForm({
    _method: 'PUT',
    background_photo: null,
})

const save = () => {
    if (photoInput.value) {
        form.background_photo = photoInput.value.files[0];
    }

    form.post('/workspaces/update-bg-photo/' + props.workspace.id , {
        preserveScroll: true,
    });
}

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

function search(ev) {
    router.visit('/workspaces/view-tasks/' + props.workspace.id + '/search/' + ev.target.value)
}

function toggleFinish(id) {
    router.visit('/workspaces/view-tasks/' + props.workspace.id + '/toggle-finish/' + id, {
        method: 'POST',
        preserveScroll: true
    })
}

// onMounted(() => {
//     const searchInput = document.getElementById('search')
//     const searchButton = document.getElementById('searchBtn')

//     function handleFocus() {
//         searchButton.classList.toggle('hidden')
//     }

//     searchInput.addEventListener("focus", handleFocus)
//     searchInput.addEventListener("blur", handleFocus)
// })

function getFormattedDate(date) {
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });

    return formattedDate;
}
</script>

<template>
    <AppLayout :title="props.workspace.title">
        <template #header>
            <Link href="/workspaces" 
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
              </svg>
              &nbsp;
                Go back
            </Link>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="w-full relative" @click="selectNewPhoto">
                        <img v-show="! photoPreview" :src="props.workspace.background_photo_url" class="w-full h-[250px] object-cover object-center" alt="">
                        <img v-show="photoPreview" :src="photoPreview" class="w-full h-[250px] object-cover object-center" alt="">
                        <input
                            ref="photoInput"
                            type="file"
                            class="hidden"
                            @change="updatePhotoPreview"
                        >
                </div>

                <div v-show="photoPreview" class="flex justify-end">
                    <SecondaryButton 
                    class="mt-4"
                    type="button"
                    @click.prevent="save">
                        Save Changes
                    </SecondaryButton>
                </div>

                <div class="mt-4">
                    <h4 class="text-3xl font-semibold text-gray-600">{{ props.workspace.title }}</h4>
                    <p class="text-base font-normal text-gray-600">{{ props.workspace.description }}</p>
                </div>
                <hr class="mb-4 mt-4">
                
                <div class="flex justify-between items-center mb-2">

                    <TextInput 
                    id="search"
                    type="text"
                    @keyup.enter="search($event)"
                    class="w-[150px] focus:w-[300px] transition ease-in-out duration-300"
                    placeholder="Search task.." />



                    <Link :href="'/workspaces/' + props.workspace.id + '/add-new-task'" 
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    >Add New Task</Link>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Task
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Scheduled Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="task in tasks" :key="task.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <span :class="{'line-through text-green-500' : task.status}">{{ task.taskname }}</span>
                                </th>
                                <td class="px-6 py-4">
                                    <span :class="{'line-through text-green-500' : task.status}">{{ getFormattedDate(task.date_sched) }}</span>
                                </td>
                                <td class="px-6 py-4 space-x-2 text-start">
                                    <input :id="'status-' + task.id" type="checkbox" :checked="task.status" @change.prevent="toggleFinish(task.id)">
                                    <label :for="'status-' + task.id">
                                        <span v-if="task.status == 1" class="text-green-500">Finished</span>
                                        <span v-else>On-going</span>
                                    </label>
                                </td>
                                <td class="flex px-6 py-4 text-center space-x-4">
                                    <Link :href="'/workspaces/view-tasks/'  + props.workspace.id + '/edit/' + task.id" 
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                    </Link>
                                    <Link :href="'/workspaces/view-tasks/' + props.workspace.id + '/delete/' + task.id"
                                    as="button"
                                    method="DELETE"
                                    class="font-medium text-red-600 hover:underline"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                      </svg>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AppLayout>
</template>