<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Return Book
            </h2>
        </template>

            <form @submit.prevent="submit">
                <div>
                    <jet-label for="barcode" value="Barcode" />
                    <jet-input id="barcode" name="barcode" type="text" class="mt-1 block w-full" v-model="form.barcode" required/>
                </div>
                <div>
                    <jet-label for="is_damaged" value="Damaged?" />
                    <jet-checkbox name="is_damaged" id="is_damaged" v-model="form.is_damaged" />
                </div>
                <div>
                    <jet-label for="notes" value="Notes" />
                    <jet-input id="notes" name="notes" type="text" class="mt-1 block w-full" v-model="form.notes"/>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        Book has been returned!
                    </jet-action-message>
                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Return Book
                    </jet-button>
                </div>
            </form>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetActionMessage from "@/Jetstream/ActionMessage";

export default {
    components: {
        AppLayout,
        JetInput,
        JetLabel,
        JetButton,
        JetCheckbox,
        JetActionMessage
    },
    data() {
        return {
            form: this.$inertia.form({
                    barcode: "",
                    is_damged: false,
                    notes: "",
                }),
        };
    },
    methods: {
        submit() {
                this.form
                    .post(this.route('lend.return'), {
                        onSuccess: () => this.form.reset(),
                    })
            },
    }
};
</script>
