<template>
<div class="flex flex-col w-full">
    <div class="flex justify-end mt-4">
        <button v-on:click="update" class="px-4 py-2 bg-blue-500 font-semibold text-white rounded-md hover:shadow-lg">Save</button>
    </div>
    <div class="bg-white flex flex-wrap my-5 p-6 rounded-md shadow-md w-full md:w-1/2 mx-auto">
        <form class="flex flex-col w-full">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" v-model="visitor.first_name" class="rounded w-full">
            <label for="last_name" class="mt-4">Last Name</label>
            <input type="text" name="last_name" v-model="visitor.last_name" class="rounded w-full">
            <label for="email" class="mt-4">Email</label>
            <input type="email" name="email" v-model="visitor.email" class="rounded w-full">
            <label for="address1" class="mt-4">Address 1</label>
            <input type="text" name="address1" v-model="visitor.address1" class="rounded w-full">
            <label for="address2" class="mt-4">Address 2</label>
            <input type="text" name="address2" v-model="visitor.address2" class="rounded w-full">
            <label for="city" class="mt-4">City</label>
            <input type="text" name="city" v-model="visitor.city" class="rounded w-full">
            <label for="state" class="mt-4">State</label>
            <input type="text" name="state" v-model="visitor.state" class="rounded w-full">
            <label for="postal_code" class="mt-4">Postal Code</label>
            <input type="text" name="postal_code" v-model="visitor.postal_code" class="rounded w-full">
            <label for="country" class="mt-4">Country</label>
            <input type="text" name="country" v-model="visitor.country" class="rounded w-full">
            <label for="dob" class="mt-4">Date of Birth</label>
            <input type="text" name="dob" v-model="visitor.dob" class="rounded w-full">
            <label for="phone" class="mt-4">Phone Number</label>
            <input type="text" name="phone" v-model="visitor.phone" class="rounded w-full">
            <label for="card_number" class="mt-4">Card Number</label>
            <input type="text" name="card_number" v-model="visitor.card_number" class="rounded w-full">
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
            visitor: {},
            message: ""
        }
    },
    methods: {
        getUser() {
            axios.get("/api/admin/visitor/" + this.uuid).then((response) => {
                this.visitor = response.data
            });
        },
        update() {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf;

            let vm = this
            axios.post("/api/admin/visitor/upgrade/" + this.uuid, this.visitor).then((response) => {
                vm.message = response.data.success
                vm.$router.replace({ name: 'patron.view', params: { uuid: vm.uuid } })
            })
            this.message = vm.message
        }
    },
    created() {
        this.getUser()
    },
}
</script>
