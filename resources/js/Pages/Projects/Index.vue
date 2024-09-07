<template>

    <head title="Projects Index"></head>
    <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-end m-2 p-2">
                <a href="Projects/create" class="create">Create New Project</a>
            </div>
            <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col" class="px-6 py-3">ID</th>
                  <th scope="col" class="px-6 py-3">Name</th>
                  <th scope="col" class="px-6 py-3">SKill</th>
                  <th scope="col" class="px-6 py-3">Project URL</th>

                  <th scope="col" class="px-6 py-3">Image</th>
                  <th scope="col" class="px-6 py-3">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="project in projects.data" :key="project.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ project.id }}
                  </th>
                  <td class="px-6 py-4">{{ project.name }}</td>
                  <td class="px-6 py-4">{{ project.skill.name }}</td>
                  <td class="px-6 py-4">{{ project.project_url }}</td>
                  <td class="px-6 py-4">
                    <img :src="project.image" alt="project Image" class="w-10 h-10 object-cover rounded-full">
                  </td>
                  <td class="px-6 py-4">
                    <a :href="`/Projects/${project.id}/edit`" class="text-indigo-600 hover:text-indigo-900">Edit</a> /
                    <Link :href="route('Projects.destroy', project.id)" method="delete" as="button" type="button"
                          class="text-red-500 hover:text-red-700">
                        Delete
                    </Link>
                </td>
                </tr>
              </tbody>
            </table>
          </div>
                </div>
            </div>
        </AuthenticatedLayout>

    </template>

    <script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';    const props = defineProps({
    projects: Object,
  });

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