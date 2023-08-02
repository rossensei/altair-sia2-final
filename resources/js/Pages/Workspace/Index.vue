<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    workspaces: Array
})

function open(id) {
    router.visit('/workspaces/view-tasks/' + id)
}

function create() {
    router.visit('/workspaces/create');
}

function removeWorkspace(id) {
    router.visit('/workspaces/remove/' + id, {
        method: 'DELETE'
    })
}
</script>

<template>
    <AppLayout title="Workspaces">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Workspaces
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 lg:gap-4 gap-2">
                        <div v-for="workspace in workspaces" :key="workspace.id" class="relative border border-gray-600 shadow-lg rounded-lg h-[150px]" >
                            <!-- <img :src="workspace.background_photo_url" class="h-[300px] object-cover object-center" alt="">
                            <div class="absolute top-0 w-full bg-gray-500 opacity-25 min-h-full"></div> -->
                            <div class="absolute top-0 flex justify-center items-center w-full min-h-full" @click="open(workspace.id)">
                                <p class="z-20 text-center text-black text-xl font-semibold">{{ workspace.title }}</p>
                            </div>
                            <span 
                            @click="removeWorkspace(workspace.id)"
                            class="absolute bottom-2 right-3 hover:text-red-500 px-2 py-1 border border-gray-600 hover:border-red-500 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                  </svg>
                            </span>
                        </div>
    
                        <div class="relative border border-gray-600 shadow-lg rounded-lg h-[150px]" @click="create">
                            <!-- <div class="absolute top-0 w-full bg-gray-500 opacity-25 min-h-full" ></div> -->
                            <div class="absolute top-0 flex justify-center items-center w-full min-h-full">
                                <p class="z-20 text-center text-black text-xl font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                  </svg></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>