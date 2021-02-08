<template>
    <app-layout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Librarian Invite
            </h2>
        </template>

        <jet-authentication-card>
            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <div>
                    <jet-label for="first_name" value="First Name" />
                    <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus/>
                </div>

                <div class="mt-4">
                    <jet-label for="last_name" value="Last Name" />
                    <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required/>
                </div>

                <div class="mt-4">
                    <jet-label for="email" value="Email" />
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        Invitation Sent!
                    </jet-action-message>
                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Invite
                    </jet-button>
                </div>
            </form>
        </jet-authentication-card>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'

    export default {
        components: {
            AppLayout,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
            JetActionMessage
        },

        data() {
            return {
                form: this.$inertia.form({
                    first_name: '',
                    last_name: '',
                    email: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('inviteLibrarian'), {
                    onFinish: () => this.form.reset('first_name','last_name','email'),
                })
            }
        }
    }
</script>
