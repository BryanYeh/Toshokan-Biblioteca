<template>
    <div class="w-full mt-6">
        <app-link :to="{ name: 'visitor.upgrade', params: { uuid: visitor.uuid }}" class="px-4 py-2 bg-yellow-100 text-yellow-500 rounded-md shadow-md hover:bg-yellow-500 hover:text-white">
            Upgrade
        </app-link>
    </div>
    <div class="w-full rounded-md shadow-md bg-white mt-4 p-4">
        <p><span class="font-semibold">First Name</span>: {{ visitor.first_name }}</p>
        <p><span class="font-semibold">Last Name</span>: {{ visitor.last_name }}</p>
        <p><span class="font-semibold">Email</span>: {{ visitor.email }}</p>
        <p><span class="font-semibold">Username</span>: {{ visitor.username }}</p>
    </div>
</template>

<script>
import AppLink from "../../../components/AppLink"

export default {
    components: {
      AppLink
    },
    props: {
        uuid: { required: true },
    },
    data() {
        return {
            visitor: {}
        }
    },
    methods: {
        getUser() {
            axios.get("/api/admin/visitor/" + this.uuid).then((response) => {
                this.visitor = response.data
            });
        },
    },
    created() {
        this.getUser()
    }
}
</script>
