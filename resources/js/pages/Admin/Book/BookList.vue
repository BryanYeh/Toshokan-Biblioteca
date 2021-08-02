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
                    sortable: false,
                    type: "image"
                },
                {
                    label: "Title",
                    field: "title",
                    sortable: true,
                    sort: "default"
                },
                {
                    label: "Options",
                    field: "links",
                    sortable: false,
                    type: 'link'
                }
            ]
        }
    },
    methods: {
        getBooks() {
            axios.get("/api/admin/books").then((response) => {
                response.data.forEach((element, index) => {
                    this.books.push({
                        id: index + 1,
                        title: element.title,
                        image: element.image,
                        links: [
                            { params: { uuid: element.uuid }, name: 'book.view', title: 'View'},
                            { params: { uuid: element.uuid }, name: 'book.edit', title: 'Edit'}
                        ]
                    })
                });
            });
        },
    },
    created() {
        this.getBooks()
    },
}
</script>
