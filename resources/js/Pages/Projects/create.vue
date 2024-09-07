<template>

    <head title="New Project"></head>
    <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Project</h2>
            </template>

            <div class="py-12">
                <div class="max-w-md mx-auto sm:px-8 lg:px-8 bg-white">
                    <form @submit.prevent="submit" class="p-4" novalidate>
                        <div>
                        <InputLabel for="skill" value="Skill" />
                        <select id="skill" v-model="form.skill_id" class="mt-1 block w-full">
                            <option value="" disabled>Select a skill</option>
                            <option v-for="skill in skills" :key="skill.id" :value="skill.id">
                                {{ skill.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.skill_id" />
                    </div>
            <div>
                <InputLabel for="name" value="Project Name" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="project_url" value="Project Url" />
                <TextInput id="project_url" type="text" class="mt-1 block w-full" v-model="form.project_url" required autofocus />
                <InputError class="mt-2" :message="form.errors.project_url" />
            </div>
            <div class="mt-2">
                <InputLabel for="image" value="Image" />
                <TextInput id="image" type="file" class="mt-1 block w-full"  @input="form.image = $event.target.files[0]"  required  />
                <InputError class="mt-2" :message="form.errors.image" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                   Save
                </PrimaryButton>
            </div>
        </form>
                </div>
            </div>
        </AuthenticatedLayout>

    </template>

    <script setup>

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const props = defineProps(['skills']);

const form = useForm({
    name: '',
    image: null,
    skill_id:'',
    project_url:'',
});

const submit = () => {
    form.post(route('Projects.store'));
};
    </script>


    <style scoped>
    .create {
        padding-left: 1rem; /* or use the exact value you want */
        padding-right: 1rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        background-color: #6366F1; /* Tailwind's indigo-500 */
        color: white;
        border-radius: 0.375rem; /* Tailwind's rounded-md */

        &:hover {
            background-color: #4338CA; /* Tailwind's indigo-700 */
        }
    }
    </style>
