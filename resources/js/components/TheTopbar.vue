<template>
    <div class="bg-white px-6 py-2 flex justify-between items-center">
        <div>
            <a href="/">
                <img class="h-14" src="images/logo.svg" alt="Toshokan Biblioteca">
            </a>
        </div>
        <ul class="flex items-center">
            <li class="px-2">
                <dropdown top="top-16" right="-right-32" width="w-72">
                    <template v-slot:dropdown_head>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </template>
                    <template v-slot:dropdown_body>
                        <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex border-b">
                            <div class="flex flex-col">
                                <span class="font-semibold">5 new patrons today</span>
                                <small>See who are the patrons</small>
                            </div>
                        </a>
                        <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex border-b">
                            <div class="flex flex-col">
                                <span class="font-semibold">5 new patrons today</span>
                                <small>See who are the patrons</small>
                            </div>
                        </a>
                        <div class="pb-2 pt-4 text-center">
                            <a href="#" class="bg-green-400 hover:bg-gray-200 hover:text-green-600 inline-flex px-4 py-2 rounded-md text-white" >
                                View all Notifications
                            </a>
                        </div>
                    </template>
                </dropdown>
            </li>
            <li class="px-2">
                <dropdown top="top-16" right="right-0" width="w-56">
                    <template v-slot:dropdown_head>
                        <div class="flex cursor-pointer items-center leading-none">
                            <div class="flex flex-col mr-2 text-right">
                                <div class="font-semibold">John Doe</div>
                                <div class="text-sm">admin</div>
                            </div>
                            <img
                                class="h-12 w-12 rounded-full"
                                src="https://avatars.dicebear.com/api/avataaars/4c2a904bafba06591225113ad17b5cec.svg?background=%23f00f0f"
                                alt="John Doe"
                            />
                        </div>
                    </template>
                    <template v-slot:dropdown_body :class="w-56">
                        <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Profile
                        </a>
                        <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </a>
                    </template>
                </dropdown>
            </li>
        </ul>
    </div>
</template>

<script>
import Dropdown from './Dropdown';
export default {
    components: { Dropdown },
    methods: {
        toggleDropdownMenu(x){
            /**
             * event.target //the element currently clicked
             * event.currentTarget //Element of the current binding event
             */
            x.currentTarget.lastElementChild.classList.toggle('hidden')
        },
        closeDropdown() {
            document.querySelectorAll(".dropdown-menu").forEach((dropdown_menu) => {
                dropdown_menu.classList.add("hidden");
            });
        },
    }
}
</script>
