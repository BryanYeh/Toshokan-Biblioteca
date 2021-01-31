<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Librarian') }}
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
                    <form method="POST" action="{{ route('librarian.create.store') }}">
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
                            <x-label for="username" :value="__('Username')" />
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

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Add Librarian') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
