<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lend
            </h2>
        </template>

        <div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="card_number" value="Card Number" />
                <jet-input
                    id="card_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="card.number"
                />
                <jet-button type="button" @click.native="loadUser"
                    >Load</jet-button
                >
            </div>
        </div>
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
            card: {
                number: ""
            },
            patron: {},
            books: []
        };
    },
    methods: {
        loadUser() {
            this.$inertia.post(route("lend.load"), this.card, {
                onSuccess: data => (this.patron = data),
                onError: err => console.log(err)
            });
        }
    }
};
</script>
