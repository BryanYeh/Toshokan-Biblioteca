<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Patron') }}
        </h2>
    </x-slot>
    <div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100">
        @if (count($errors) > 0)
            <div class="md:w-7/12 pt-12 w-10/12">
                <div class="border border-red-800 bg-red-700 text-white p-6 shadow-md rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="md:w-7/12 py-12 w-10/12">
            <div class="w-full p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('patron.create.store') }}">
                        @csrf

                        <div>
                            <x-label for="first_name" :value="__('First Name')" />
                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="last_name" :value="__('Last Name')" />
                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="username" :value="__('Library Card #')" />
                            <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Password')" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="password" :value="__('Confirm Password')" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
                        </div>

                        <div class="mt-4">
                            <x-label for="dob" :value="__('Date of Birth')" />
                            <x-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="address1" :value="__('Address 1')" />
                            <x-input id="address1" class="block mt-1 w-full" type="text" name="address1" :value="old('address1')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="address2" :value="__('Address 2')" />
                            <x-input id="address2" class="block mt-1 w-full" type="text" name="address2" :value="old('address2')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="city" :value="__('City')" />
                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="state" :value="__('State')" />
                            <x-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="postal_code" :value="__('Postal Code')" />
                            <x-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="country" :value="__('Country')" />
                            <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"/>
                        </div>

                        <div class="mt-4">
                            <x-label for="phone" :value="__('Phone')" />
                            <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Add Patron') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
