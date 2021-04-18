<template>
    <div class="bg-white px-6 py-2 flex justify-between items-center">
        <div>
            <a href="/">
                <img class="h-14" src="images/logo.svg" alt="Toshokan Biblioteca">
            </a>
        </div>
        <ul class="flex items-center">
            <li class="px-2">
                <div class="relative">
                    <div class="flex cursor-pointer" @click="toggle_notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="absolute bg-white flex flex-col -right-32 rounded-md shadow-md top-16 w-72 border border-gray-200 py-1" v-if="show_notifications">
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
                    </div>
                </div>
            </li>
            <li class="px-2">
                <div class="relative">
                    <div class="flex cursor-pointer" @click="toggle_show">
                        <img
                            class="h-10 w-10 rounded-full"
                            src="https://avatars.dicebear.com/api/avataaars/4c2a904bafba06591225113ad17b5cec.svg?background=%23f00f0f"
                            alt="John Doe"
                        />
                        <div class="flex flex-col ml-2">
                            <span class="font-semibold">John Doe</span>
                            <small>admin</small>
                        </div>
                    </div>
                    <div class="absolute bg-white flex flex-col right-1 rounded-md shadow-md top-16 w-40 border border-gray-200 py-1" v-if="show">
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
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px">
            <span class="text-secondary">Laravel Vue CRUD Example</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link
                        :to="{ name: 'home' }"
                        class="nav-item nav-link"
                        >Home</router-link
                    >
                    <router-link
                        :to="{ name: 'about' }"
                        class="nav-item nav-link"
                        >Add Post</router-link
                    >
                </div>
            </div>
        </nav>
        <br />
        <example-component />
        <router-view></router-view>
    </div>
</template>

<script>
import ExampleComponent from "./components/ExampleComponent";
export default {
    components: { ExampleComponent },
    data() {
        return {
            show: false,
            show_notifications: false,
        };
    },
    methods: {
        toggle_show(){
            this.show = !this.show;
            this.show_notifications = false;
        },
        toggle_notifications(){
            this.show_notifications = !this.show_notifications
            this.show = false;
        }
    }
};
</script>
