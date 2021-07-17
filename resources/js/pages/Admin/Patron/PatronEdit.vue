<template>
<div class="flex flex-col w-full">
    <div class="flex justify-end mt-4">
        <button v-on:click="update" class="px-4 py-2 bg-blue-500 font-semibold text-white rounded-md hover:shadow-lg">Save</button>
    </div>
    <div class="bg-white flex flex-wrap my-5 p-6 rounded-md shadow-md w-full md:w-1/2 mx-auto">
        <form class="flex flex-col w-full">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" v-model="patron.first_name" class="rounded w-full">
            <label for="last_name" class="mt-4">Last Name</label>
            <input type="text" name="last_name" v-model="patron.last_name" class="rounded w-full">
            <label for="email" class="mt-4">Email</label>
            <input type="email" name="email" v-model="patron.email" class="rounded w-full">
            <label for="address1" class="mt-4">Address 1</label>
            <input type="text" name="address1" v-model="patron.address1" class="rounded w-full">
            <label for="address2" class="mt-4">Address 2</label>
            <input type="text" name="address2" v-model="patron.address2" class="rounded w-full">
            <label for="city" class="mt-4">City</label>
            <input type="text" name="city" v-model="patron.city" class="rounded w-full">
            <label for="state" class="mt-4">State</label>
            <input type="text" name="state" v-model="patron.state" class="rounded w-full">
            <label for="postal_code" class="mt-4">Postal Code</label>
            <input type="text" name="postal_code" v-model="patron.postal_code" class="rounded w-full">
            <label for="country" class="mt-4">Country</label>
            <input type="text" name="country" v-model="patron.country" class="rounded w-full">
            <label for="phone" class="mt-4">Phone Number</label>
            <input type="text" name="phone" v-model="patron.phone" class="rounded w-full">
        </form>
    </div>
</div>

</template>

<script>
import dayjs from 'dayjs';

export default {
    props: {
        uuid: { required: true },
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            patron: {},
            message: "hello"
        }
    },
    methods: {
        getUser() {
            axios.get("/api/admin/patron/" + this.uuid).then((response) => {
                this.patron = response.data
            });
        },
        update() {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;
            delete this.patron.overdue_books
            delete this.patron.email_verified_at

            let vm = this
            axios.post("/api/admin/patron/update/" + this.uuid, this.patron).then((response) => {
                vm.message = response.data.success
            })
            this.message = vm.message
        }
    },
    created() {
        this.getUser()
    },
}
</script>
