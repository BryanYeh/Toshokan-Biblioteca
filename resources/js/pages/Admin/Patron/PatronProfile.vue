<template>
    <div class="bg-white flex flex-wrap mt-5 p-6 rounded-md shadow-md w-full lg:w-7/12">
        <div class="w-full md:w-1/2 mb-4">
            <h1 class="text-lg font-bold">{{ patron.first_name }} {{ patron.last_name }}</h1>
            {{ patron.email }}
            <div class="flex flex-wrap mt-2">
                <app-link :to="{ name: 'patron.edit', params: { uuid: patron.uuid }}" class="px-4 py-2 bg-blue-500 font-semibold text-white rounded-md hover:shadow-lg">
                    Edit
                </app-link>
                <a v-on:click="downgradePatron($event)" class="ml-4 px-4 py-2 text-red-500 bg-white border border-red-500 rounded-md hover:bg-red-100">Downgrade</a>
            </div>
        </div>
        <div class="w-full md:w-1/2">
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Username</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.username }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Card Number</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.card_number }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Status</div>
                <div class="w-2/3 group-hover:bg-yellow-100" >
                    <span v-if="patron.is_disabled">Inactive</span>
                    <span v-else>Active</span>
                </div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Date of Birth</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ formatDate(patron.dob) }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Address</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.address1 }}</div>
            </div>
            <div class="flex group" v-if="patron.address2 != ''">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Address 2</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.address2 }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">City</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.city }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">State</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.state }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Postal Code</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.postal_code }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Country</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.country }}</div>
            </div>
            <div class="flex group">
                <div class="w-1/3 font-semibold pl-2 group-hover:bg-yellow-100">Phone</div>
                <div class="w-2/3 group-hover:bg-yellow-100">{{ patron.phone }}</div>
            </div>
        </div>
    </div>
    <div class="bg-white mt-5 p-6 border border-red-600 rounded-md shadow-md w-full lg:w-4/12 animate-pulse">
        <h2 class="text-lg font-semibold text-red-600">Fines Owe</h2>
        <ul>
            <li>
                <div class="flex flex-wrap">
                    <div class="w-3/4">Late Fee</div>
                    <div class="text-red-600 text-sm w-1/4">${{ parseFloat(fees.late).toFixed(2) }}</div>
                </div>
            </li>
            <li>
                <div class="flex flex-wrap">
                    <div class="w-3/4">Damaged Fee</div>
                    <div class="text-red-600 text-sm w-1/4">${{ parseFloat(fees.damaged).toFixed(2) }}</div>
                </div>
            </li>
        </ul>
        <h2 class="text-lg font-semibold text-red-600">
            Overdue Books
            <span class="text-xs text-white px-3 rounded-xl bg-red-500" v-if="patron.overdue_books && patron.overdue_books.length > 0">{{ patron.overdue_books.length }}</span>
        </h2>
        <ul v-if="patron.overdue_books.length > 0">
            <li v-for="item in patron.overdue_books.slice(0,4)" :key="item.id">
                <div class="flex flex-wrap">
                    <div class="w-3/4">{{ item.location.book.title }}</div>
                    <div class="text-red-600 text-sm w-1/4">{{ formatDate(item.lend_date,14) }}</div>
                </div>
            </li>
            <li class="text-center" v-if="patron.overdue_books.length > 4">
                <a href="#" class="mt-2 inline-block rounded px-4 py-2 bg-red-600 text-white border border-red-600 hover:text-red-600 hover:bg-white">View All Overdue Books</a>
            </li>
        </ul>
    </div>
    <div class="bg-white flex flex-wrap my-5 p-6 rounded-md shadow-md w-full">
        <smart-table
            :perPage=25
            :is-loading=false
            :columns=columns
            :rows=books
        ></smart-table>
    </div>
</template>

<script>
import dayjs from 'dayjs';
import SmartTable from '../../../components/SmartTable/SmartTable';
import AppLink from "../../../components/AppLink"

export default {
    components: {
      SmartTable,
      AppLink
    },
    props: {
        uuid: { required: true },
    },
    data() {
        return {
            patron: {
                overdue_books: []
            },
            fees: {
                late: 0.00,
                damaged: 0.00
            },
            books: [],
            columns: [
                {
                    label: "ID",
                    field: "id",
                    width: "w-2",
                    sort: 'asc',
                    sortable: true
                },
                {
                    label: "Barcode",
                    field: "barcode",
                    width: "w-1/12",
                    sort: 'default',
                    sortable: true
                },
                {
                    label: "Title",
                    field: "title",
                    sortable: true,
                    sort: "default"
                },
                {
                    label: "Lend Date",
                    field: "lend_date",
                    sortable: false,
                    sort: "default"
                }
            ]
        }
    },
    methods: {
        downgradePatron(event) {
            event.preventDefault()
            axios.post("/api/admin/patron/downgrade/" + this.uuid).then((response) => {
                // TODO: show message
                // redirect to visitor/uuid
                console.log(response.data.message)
            });
        },
        getUser() {
            axios.get("/api/admin/patron/" + this.uuid).then((response) => {
                this.patron = response.data
            });
        },
        formatDate(date, add = 0) {
            if (!date){
                return null;
            }
            return dayjs(date).add(add,'days').format('MM-DD-YYYY');
        },
        getFees(){
            axios.get("/api/admin/lend/returned/fees/" + this.uuid).then((response) => {
                this.fees.late = response.data.late_fee
                this.fees.damaged = response.data.damaged_fee
            });
        },
        getBooks(){
            axios.get("/api/admin/lend/books/patron/" + this.uuid).then((response) => {
                response.data.books.forEach((element, index) => {
                    this.books.push({
                        id: index + 1,
                        title: element.book.title,
                        lend_date: element.lend_date,
                        barcode: element.location.barcode
                    })
                });
            });
        }
    },
    created() {
        this.getUser()
        this.getFees()
        this.getBooks()
    },
};
</script>
