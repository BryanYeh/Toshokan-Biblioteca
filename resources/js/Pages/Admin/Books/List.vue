<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="bg-white border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md mb-6" role="alert" v-if="flash.message">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ flash.message }}</p>
                        </div>
                    </div>
                </div>

                <table class="table w-full text-center">
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="book in books.data">
                        <td class="py-2">{{ book.image }}</td>
                        <td class="py-2">{{ book.title }} {{ book.edition }}</td>
                        <td class="py-2">{{ book.isbn }}</td>
                        <td class="py-2">
                            <a v-bind:href="route('book.detail',{id:book.id})" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </a>
                            <a v-bind:href="route('book.edit',{id:book.id})" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </table>
                <Pagination v-bind:obj="books"></Pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Jetstream/Pagination'

export default {
    props: ['books','errors','flash'],
    components :{
        AppLayout,
        Pagination
    },
    methods: {
        del: function (id) {
            this.$inertia.delete(route('librarian.delete',{id:id}))
        }
    }
}
</script>
