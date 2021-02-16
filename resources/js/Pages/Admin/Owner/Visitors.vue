<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Visitors
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <table class="table w-full text-center">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="visitor in visitors.data">
                        <td class="py-2">{{ visitor.first_name }} {{ visitor.last_name }}</td>
                        <td class="py-2">{{ visitor.email }}</td>
                        <td class="py-2">
                            <a v-bind:href="route('edit.visitor',{id:visitor.id})" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </table>
                <Pagination v-bind:obj="visitors"></Pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Jetstream/Pagination'

export default {
    props: {
        visitors: {
            type: Object
        }
    },
    components :{
        AppLayout,
        Pagination
    },
}
</script>
