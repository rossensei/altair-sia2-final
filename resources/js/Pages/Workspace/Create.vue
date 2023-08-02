<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import ActionSection from '@/Components/ActionSection.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { router, Link, useForm } from '@inertiajs/vue3';


const form = useForm({
    title: null,
    description: null,
})

function createWorkspace() {
    form.post('/workspaces')
}
</script>

<template>
    <AppLayout title="Add Workspace">
        <template #header>
            <Link href="/workspaces" method="GET"
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
                <FormSection @submitted="createWorkspace">
                    <template #title>
                        Add new workspace
                    </template>
            
                    <template #description>
                        Update your account's profile information and email address.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="workspace" value="Name your workspace"/>
                            <TextInput
                            type="text"
                            id="workspace"
                            v-model="form.title"
                            class="mt-1 block w-full" 
                            />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="desc" value="Add description"/>
                            <TextInput
                            type="text"
                            id="desc"
                            v-model="form.description"
                            class="mt-1 block w-full" 
                            />
                            <InputError :message="form.errors.description" />
                        </div>
                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </ActionMessage>
            
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            create
                        </PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </div>
    </AppLayout>
</template>