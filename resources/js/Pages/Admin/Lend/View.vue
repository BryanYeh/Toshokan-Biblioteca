<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lend
            </h2>
        </template>

        <div v-if="!this.patron">
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="card_number" value="Card Number" />
                <jet-input
                    id="card_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="search.card_number"
                    v-on:keyup.enter.native="loadUser"
                />
                <jet-button type="button" @click.native="loadUser"
                    >Load</jet-button
                >
            </div>
        </div>

        <div v-if="this.patron">
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="barcode" value="Barcode" />
                <jet-input
                    id="barcode"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="search.barcode"
                    v-on:keyup.enter.native="lendBook"
                />
                <jet-button type="button" @click.native="lendBook"
                    >Lend</jet-button
                >
            </div>
        </div>

        <ul>
            <li v-for="book in books">{{ book.title }}</li>
        </ul>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";

export default {
    components: {
        AppLayout,
        JetInput,
        JetLabel,
        JetButton
    },
    data() {
        return {
            patron: null,
            books: [],
            search: {
                barcode: "",
                card_number: ""
            }
        };
    },
    methods: {
        loadUser() {
            this.$inertia.post(route("lend.load"), this.search, {
                onSuccess: data => (this.patron = data),
                onError: err => console.log(err)
            });
        },
        lendBook() {
            this.$inertia.post(route("lend.book"), this.search, {
                onSuccess: data => this.books.push({
                    title: data.props.book.title,
                    barcode: data.props.barcode,
                    image: data.props.book.image
                })
            });
        }
    }
};
</script>
