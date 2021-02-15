<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Patrons
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <table class="table w-full text-center">
                    <tr>
                        <th>Name</th>
                        <th>Card Number</th>
                        <th>Address Last Confirmed</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="patron in patrons.data">
                        <td class="py-2">{{ patron.first_name }} {{ patron.last_name }}</td>
                        <td class="py-2">{{ patron.card_number }}</td>
                        <td class="py-2">{{ patron.address_confirmed_at | fromNow }}</td>
                        <td class="py-2">
                            <a v-bind:href="route('edit.patron',{id:patron.id})" class="inline-block">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                </table>
                <Pagination v-bind:obj="patrons"></Pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Jetstream/Pagination'
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

export default {
    props: {
        patrons: {
            type: Object
        }
    },
    components :{
        AppLayout,
        Pagination
    },
    created() {
        dayjs.extend(relativeTime);
    },
    filters: {
        fromNow: (date) => {
            if (!date){
                return null;
            }
            return dayjs(date).fromNow();
        }
    }
}
</script>
