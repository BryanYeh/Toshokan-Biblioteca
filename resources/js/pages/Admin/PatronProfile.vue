<template>
    <div class="bg-white flex flex-wrap mt-5 p-6 rounded-md shadow-md w-full lg:w-8/12">
        <div class="w-full md:w-1/2 mb-4">
            <h1 class="text-lg font-bold">{{ patron.first_name }} {{ patron.last_name }}</h1>
            {{ patron.email }}
            <div class="flex flex-wrap mt-2">
                <a href="#" class="px-4 py-2 bg-blue-500 font-semibold text-white rounded-md hover:shadow-lg">Edit</a>
                <a href="#" class="ml-4 px-4 py-2 text-red-500 bg-white border border-red-500 rounded-md hover:bg-red-100">Downgrade</a>
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
    <div class="bg-white flex flex-wrap mt-5 p-6 rounded-md shadow-md w-full lg:w-4/12">
        Something
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
            patron: {},
        }
    },
    methods: {
        getUser() {
            axios.get("/api/admin/patron/" + this.uuid).then((response) => {
                this.patron = response.data
            });
        },
        formatDate(date) {
            if (!date){
                return null;
            }
            return dayjs(date).format('MM-DD-YYYY');
        }
    },
    created() {
        this.getUser()
    },
};
</script>
