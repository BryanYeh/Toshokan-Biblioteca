<template>
    <jet-authentication-card>
        <template #logo>
            <jet-authentication-card-logo />
        </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <jet-input id="invitation_code" name="invitation_token" type="hidden" class="mt-1 block w-full" v-model="form.invitation_token"/>

            <div>
                <jet-label for="first_name" value="First Name" />
                <jet-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" disabled/>
            </div>

            <div class="mt-4">
                <jet-label for="last_name" value="Last Name" />
                <jet-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" disabled/>
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" name="email" type="email" class="mt-1 block w-full" v-model="form.email" disabled />
            </div>

            <div class="mt-4">
                <jet-label for="username" value="Username" />
                <jet-input id="username" name="username" type="text" class="mt-1 block w-full" v-model="form.username" autofocus />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" name="password" type="password" class="mt-1 block w-full" v-model="form.password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Account Created!
                </jet-action-message>
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Accept Invite
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
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
        props:['email','first_name','last_name','token'],
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
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                    invitation_token: this.token,
                    username: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('accept'), {
                    onFinish: () => this.form.reset('password','password_confirmation'),
                })
            }
        }
    }
</script>
