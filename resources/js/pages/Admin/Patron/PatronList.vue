<template>
    <div class="w-full">
        <h1 class="font-bold text-2xl mt-4">Patrons</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            <div class="rounded-md shadow-md bg-white p-4 hover:bg-yellow-100" v-for="patron in patrons" :key="patron.uuid">
                <app-link :to="{ name: 'patron.view', params: { uuid: patron.uuid }}">
                    <h3 class="font-bold text-lg text-center text-yellow-500">{{ patron.first_name }} {{ patron.last_name }}</h3>
                    <p><span class="font-semibold">Card Number</span>: {{ patron.card_number }}</p>
                    <p><span class="font-semibold">Last Confirmed</span>: {{ patron.address_confirmed_at }}</p>
                </app-link>
            </div>
        </div>
        <div class="flex mt-4 gap-4">
            <div v-if="currentPage > 1" v-on:click="previousPage()" class="bg-white rounded-md shadow-md px-4 py-2 cursor-pointer hover:bg-gray-100 hover:text-blue-600">Previous Page</div>
            <div v-if="currentPage < pages" v-on:click="nextPage()" class="bg-white rounded-md shadow-md px-4 py-2 cursor-pointer hover:bg-gray-100 hover:text-blue-600">Next Page</div>
        </div>
    </div>
</template>

<script>
import AppLink from "../../../components/AppLink"

export default {
    components: { AppLink },
    data() {
        return {
            patrons: [],
            currentPage: this.page,
            pages: 0
        }
    },
    methods: {
        getPatrons() {
            axios.get("/api/admin/patrons?page="+this.currentPage).then((response) => {
                this.patrons = response.data.data
                this.pages = response.data.last_page
            });
        },
        previousPage() {
            this.currentPage = this.currentPage - 1
            this.updatePage()
        },
        nextPage() {
            this.currentPage = this.currentPage + 1
            this.updatePage()
        },
        updatePage() {
            this.getPatrons()
            this.$router.push({ name: 'patrons', query: { page: this.currentPage }})
        }
    },
    created() {
        this.currentPage = this.$route.query.page ? this.$route.query.page : 1
        this.getPatrons()
    }
}
</script>
