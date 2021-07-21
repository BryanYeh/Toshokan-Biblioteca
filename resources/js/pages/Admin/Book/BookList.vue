<template>
  <div class="bg-white flex flex-wrap my-5 p-6 rounded-md shadow-md w-full">
    <smart-table
      :perPage="25"
      :is-loading="false"
      :columns="columns"
      :rows="books"
    ></smart-table>
  </div>
</template>

<script>
import SmartTable from '../../../components/SmartTable/SmartTable';
import AppLink from "../../../components/AppLink"

export default {
    components: {
        SmartTable,
        AppLink
    },
    data() {
        return {
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
                    label: "Cover",
                    field: "image",
                    sortable: false
                },
                {
                    label: "Title",
                    field: "title",
                    sortable: true,
                    sort: "default"
                }
            ]
        }
    },
    methods: {
        getBooks() {
            axios.get("/api/admin/books").then((response) => {
                this.books = response.data
            });
        },
    },
    created() {
        this.getBooks()
    },
}
</script>
