<template>
    <div class="w-full">
        <h1 class="font-bold text-2xl mt-4">Visitors</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
            <div class="rounded-md shadow-md bg-white p-4 hover:bg-yellow-100" v-for="visitor in visitors" :key="visitor.uuid">
                <app-link :to="{ name: 'visitor.view', params: { uuid: visitor.uuid }}">
                    <h3 class="font-bold text-lg text-center text-yellow-500">{{ visitor.first_name }} {{ visitor.last_name }}</h3>
                    <p class="text-center">{{ visitor.email }}</p>
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
            visitors: [],
            currentPage: this.page,
            pages: 0
        }
    },
    methods: {
        getVisitors() {
            axios.get("/api/admin/visitors?page="+this.currentPage).then((response) => {
                this.visitors = response.data.data
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
            this.getVisitors()
            this.$router.push({ name: 'visitors', query: { page: this.currentPage }})
        }
    },
    created() {
        this.currentPage = this.$route.query.page ? this.$route.query.page : 1
        this.getVisitors()
    }
}
</script>
