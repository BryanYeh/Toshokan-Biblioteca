<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Librarians
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <table class="table w-full text-center">
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(librarian, index) in localLibrarians.data" v-bind:index="index">
                        <td class="py-2">{{ librarian.first_name }} {{ librarian.last_name }}</td>
                        <td class="py-2">{{ librarian.username }}</td>
                        <td class="py-2">
                            <a v-bind:href="route('librarian.profile',{id:librarian.id})" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a v-on:click="del(librarian.id,index)" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </table>
                <Pagination v-bind:obj="localLibrarians"></Pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Jetstream/Pagination'

export default {
    props: ['librarians'],
    data() {
        return {
            localLibrarians: this.librarians
        }
    },
    components :{
        AppLayout,
        Pagination
    },
    methods: {
        del: function (id,index) {
            // TODO: delete librarian then update the list
            axios.delete(route('librarian.delete',{id:id}))
            .then(function (response) {
                // getting TypeError: Cannot read property 'localLibrarians' of undefined
                // this.localLibrarians.data.splice(a,1);
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
