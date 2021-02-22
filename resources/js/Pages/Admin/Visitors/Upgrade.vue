<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Convert Visitor to Patron
            </h2>
        </template>

        <jet-validation-errors class="mb-4" />

        <div class="bg-white border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md mb-6" role="alert" v-if="flash.message">
            <div class="flex">
                <div>
                    <p class="text-sm">{{ flash.message }}</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div>
                <jet-label for="first_name" value="First Name" />
                <jet-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required/>
            </div>

            <div>
                <jet-label for="last_name" value="Last Name" />
                <jet-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required/>
            </div>

            <div>
                <jet-label for="email" value="Email" />
                <jet-input id="email" name="email" type="text" class="mt-1 block w-full" v-model="form.email" required/>
            </div>

            <div>
                <jet-label for="card_number" value="Card Number" />
                <jet-input id="card_number" name="card_number" type="text" class="mt-1 block w-full" v-model="form.card_number" required/>
            </div>

            <div>
                <jet-label for="dob" value="Date of Birth" />
                <jet-input id="dob" name="dob" type="date" class="mt-1 block w-full" v-model="form.dob" required/>
            </div>

            <div>
                <jet-label for="address1" value="Address 1" />
                <jet-input id="address1" name="address1" type="text" class="mt-1 block w-full" v-model="form.address1" required />
            </div>

            <div>
                <jet-label for="address2" value="Address 2" />
                <jet-input id="address2" name="address2" type="text" class="mt-1 block w-full" v-model="form.address2" />
            </div>

            <div>
                <jet-label for="city" value="City" />
                <jet-input id="city" name="city" type="text" class="mt-1 block w-full" v-model="form.city" required />
            </div>

            <div>
                <jet-label for="state" value="State" />
                <jet-input id="state" name="state" type="text" class="mt-1 block w-full" v-model="form.state" required />
            </div>

            <div>
                <jet-label for="postal_code" value="Postal Code" />
                <jet-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" v-model="form.postal_code" required/>
            </div>

            <div>
                <jet-label for="country" value="Country" />
                <jet-input id="country" name="country" type="text" class="mt-1 block w-full" v-model="form.country" required />
            </div>

            <div>
                <jet-label for="phone" value="Phone Number" />
                <jet-input id="phone" name="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Convert
                </jet-button>
            </div>
        </form>
    </app-layout>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        props: ['visitor','errors','flash'],
        components: {
            AppLayout,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    first_name: this.visitor.first_name,
                    last_name: this.visitor.last_name,
                    email: this.visitor.email,
                    card_number: '',
                    dob: '',
                    address1: '',
                    address2: '',
                    city: '',
                    state: '',
                    postal_code: '',
                    country: '',
                    phone: ''
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .post(this.route('visitor.upgrade', {id:this.visitor.id}), {
                        onSuccess: () => window.location.href=this.route('patron.profile',{id:this.visitor.id}),
                    })
            }
        }
    }
</script>
