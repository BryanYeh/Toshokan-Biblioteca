<template>
    <div class="w-full">
        <table class="table w-full border border-gray-500 relative">
            <div v-if="is_loading" class="absolute bg-gray-600 flex flex-col h-full left-0 opacity-75 top-0 w-full">
                <div class="flex-1 flex items-center justify-center flex-col">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
	                <h2 class="text-center text-white text-xl font-semibold">Loading...</h2>
                </div>
            </div>
            <thead class="text-white bg-gray-600 border border-gray-400">
                <tr>
                    <th v-for="(col, index) in header" :key="index" :class="(col.width) ? col.width : 'w-auto'" class="border border-gray-400 p-3">
                        <div class="flex justify-between" @click="sortByColumn(col.sortable, col.field)">
                            {{ col.label }}
                            <svg v-if="col.sortable && col.field != sortColumn" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                            <svg v-if="col.sortable && sortType == 'desc' && col.field == sortColumn"  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                            <svg v-if="col.sortable && sortType == 'asc' && col.field == sortColumn" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody v-if="rows.length > 0">
                <tr v-for="(row, i) in rows.slice(fromRecord-1, toRecord)" :key="i">
                    <td v-for="(col, j) in header" :key="j" class="border border-gray-400 p-3">
                        <img v-if="col.type == 'image'" v-bind:src="row[col.field]"/>
                        <div v-if="col.type == 'link'">
                            <span v-for="(link, k) in row[col.field]" :key="k">
                                <app-link class="px-4 py-2 bg-yellow-200 mr-2" :to="{ name: link.name , params: link.params }">
                                    {{ link.title }}
                                </app-link>
                            </span>
                        </div>
                        <span v-else>{{ row[col.field] }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="w-full flex justify-between items-center mt-4" v-if="rows.length > 0">
            <div class="col">
                Showing {{ fromRecord }}-{{ toRecord }} of {{ rows.length }}
            </div>
            <div class="col" v-if="totalPages > 1">
                <button v-if="currentPage != 1" @click="changePage('previous')" class="focus:outline-none border border-gray-400 px-4 py-2 rounded hover:bg-gray-400 hover:text-white">Previous</button>
                <button v-if="currentPage != totalPages" @click="changePage('next')" class="focus:outline-none border border-gray-400 px-4 py-2 ml-2 rounded hover:bg-gray-400 hover:text-white">Next</button>
            </div>
        </div>
        <div class="w-full mt-4" v-else>
            No data
        </div>
    </div>
</template>

<script>
import AppLink from "../AppLink"
export default {
    components: {
        AppLink
    },
    props: {
        isLoading: {
            type: Boolean,
            require: false
        },
        columns: {
            type: Array,
            require: true
        },
        rows: {
            type: Array,
            require: true
        },
        perPage: {
            type: Number,
            default: 25
        }
    },
    data() {
        return {
            currentPage: 1,
            fromRecord: 1,
            sortColumn: 'id',
            sortType: 'asc',
            is_loading: this.isLoading,
            header: this.columns,
            toRecord: this.perPage
        }
    },
    methods:{
        sortByColumn(sortable, column){
            if(sortable) {
                this.is_loading = true

                if(this.sortColumn == column) {
                    if(this.sortType == 'asc') {
                        this.sortType = 'desc'
                        this.sortColumn = column
                    }
                    else if(this.sortType == 'desc') {
                        this.sortType = 'asc'
                        this.sortColumn = 'id'
                    }
                    else {
                        this.sortType = 'asc'
                        this.sortColumn = column
                    }
                }
                else{
                    this.sortType = 'asc'
                    this.sortColumn = column
                }

                this.rows.sort(this.compareValues(this.sortColumn, this.sortType))

                this.is_loading = false
            }
        },
        compareValues(key, order) {
            return function innerSort(a, b) {
                if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
                    // property doesn't exist on either object
                    return 0
                }

                const varA = (typeof a[key] === 'string') ? a[key].toUpperCase() : a[key]
                const varB = (typeof b[key] === 'string') ? b[key].toUpperCase() : b[key]

                let comparison = 0
                if (varA > varB) {
                    comparison = 1
                } else if (varA < varB) {
                    comparison = -1
                }

                return order === 'desc' ? (comparison * -1) : comparison
            }
        },
        changePage(direction){
            this.is_loading = true

            if(direction == 'next') {
                if(this.currentPage != this.totalPages){
                    this.currentPage++
                    this.fromRecord += this.perPage
                    this.toRecord += this.perPage

                    if(this.toRecord > this.totalRecords){
                        this.toRecord = this.totalRecords
                    }
                }
            }
            else {
                if(this.currentPage != 1){
                    this.currentPage--
                    this.fromRecord -= this.perPage
                    this.toRecord = this.fromRecord - 1 + this.perPage

                    if(this.fromRecord < 1){
                        this.fromRecord = 1
                    }
                    if(this.toRecord > this.totalRecords){
                        this.toRecord = this.totalRecords
                    }
                }
            }

            this.is_loading = false
        }
    },
    computed:{
        totalPages(){
            if (this.rows.length <= 0) {
                return 0
            }

            let maxPage = Math.floor(this.rows.length / this.perPage)
            let mod = this.rows.length % this.perPage

            if (mod > 0) {
                maxPage++
            }

            return maxPage
        },
        totalRecords() {
            return this.rows.length
        },
        ctoRecord() {
            if(this.perPage > this.totalRecords){
                this.toRecord = this.totalRecords
                return this.totalRecords
            }
            this.toRecord = this.perPage
            return this.perPage
        }
    },
}
</script>
