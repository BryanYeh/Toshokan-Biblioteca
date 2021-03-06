<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Book
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="bg-white border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md mb-6" role="alert" v-if="flash.message">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ flash.message }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div>
                    <jet-label for="title" value="Title" />
                    <jet-input id="title" name="title" type="text" class="mt-1 block w-full" v-model="form.title" required/>
                </div>
                <div>
                    <jet-label for="isbn" value="ISBN" />
                    <jet-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" v-model="form.isbn" required/>
                </div>
                <div>
                    <jet-label for="edition" value="Edition" />
                    <jet-input id="edition" name="edition" type="text" class="mt-1 block w-full" v-model="form.edition"/>
                </div>
                <div>
                    <jet-label for="summary" value="Summary" />
                    <jet-input id="summary" name="summary" type="text" class="mt-1 block w-full" v-model="form.summary" required/>
                </div>
                <div>
                    <jet-label for="language" value="Language" />
                    <jet-input id="language" name="language" type="text" class="mt-1 block w-full" v-model="form.language" required/>
                </div>
                <div>
                    <jet-label for="author" value="Author" />
                    <jet-input id="author" name="author" type="text" class="mt-1 block w-full" v-model="form.author" required/>
                </div>
                <div>
                    <jet-label for="publisher" value="Publisher" />
                    <jet-input id="publisher" name="publisher" type="text" class="mt-1 block w-full" v-model="form.publisher" required/>
                </div>
                <div>
                    <jet-label for="publication_date" value="Publication Date" />
                    <jet-input id="publication_date" publication_date="publication_date" type="date" class="mt-1 block w-full" v-model="form.publication_date" required/>
                </div>
                <div>
                    <jet-label for="dewey_decimal" value="Dewey Decimal" />
                    <jet-input id="dewey_decimal" name="dewey_decimal" type="text" class="mt-1 block w-full" v-model="form.dewey_decimal"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" v-on:click="addCopy" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                        Add a copy
                    </button>
                </div>

                <div v-for="(location,counter) in form.locations" class="border border-gray-500 p-2">
                    <div>
                        <jet-label for="library" value="Library" />
                        <jet-select name="library"
                            :options="libraries"
                            :default="location.library.id"
                            v-on:select:change="location.location_id = $event" />
                    </div>
                    <div>
                        <jet-label for="barcode" value="Barcode" />
                        <jet-input name="barcode" type="text" class="mt-1 block w-full" v-model="location.barcode"/>
                    </div>
                    <div>
                        <jet-label for="call_number" value="Call Number" />
                        <jet-input name="call_number" type="text" class="mt-1 block w-full" v-model="location.call_number"/>
                    </div>
                    <div>
                        <jet-label for="location" value="Location" />
                        <jet-input name="location" type="text" class="mt-1 block w-full" v-model="location.location"/>
                    </div>
                    <div>
                        <jet-label for="price" value="Price" />
                        <jet-input name="price" type="text" class="mt-1 block w-full" v-model="location.price"/>
                    </div>
                </div>


                <div class="flex items-center justify-end mt-4">
                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                        Successfully Added Book!
                    </jet-action-message>
                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Add
                    </jet-button>
                </div>
            </form>
        </div>
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
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSelect from '@/Jetstream/Select'

    export default {
        props: ['errors','flash','libraries'],
        components: {
            AppLayout,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            JetActionMessage,
            JetSelect
        },

        data() {
            return {
                form: this.$inertia.form({
                    title: '',
                    isbn: '',
                    edition: '',
                    summary: '',
                    language: '',
                    author: '',
                    publisher: '',
                    publication_date: '',
                    dewey_decimal: '',
                    locations: []
                }),
            }
        },
        mounted: function() {
            this.addCopy()
        },
        methods: {
            submit() {
                this.form
                    .post(this.route('book.save', {id:this.book.id}), {
                        onSuccess: () => window.location.href=this.route('books'),
                    })
            },
            addCopy() {
                this.form.locations.push({
                    barcode :'',
                    book_id : '',
                    call_number : '',
                    location : '',
                    location_id: this.libraries[0]['id'],
                    price : '',
                    library: {
                        id: this.libraries[0]['id'],
                        name: this.libraries[0]['name']
                    }
                })
            }
        }
    }
</script>
