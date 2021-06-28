<template>
    <nav class="bg-white container flex flex-col mt-5 mx-auto p-4 rounded-md shadow-md w-11/12 md:flex-row">
        <navbar-link :to="{ name: 'home' }">Dashboard</navbar-link>
        <dropdown top="top-16" width="w-52">
            <template v-slot:dropdown_head>
                <div class="hover:bg-gray-100 hover:text-blue-600 px-4 py-2 rounded-md cursor-pointer">
                    Patrons
                </div>
            </template>
            <template v-slot:dropdown_body>
                <dropdown-link :to="{ name: 'patrons' }">Patrons</dropdown-link>
                <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex">
                    Checkout
                </a>
            </template>
        </dropdown>
        <dropdown top="top-16" width="w-52">
            <template v-slot:dropdown_head>
                <div class="hover:bg-gray-100 hover:text-blue-600 px-4 py-2 rounded-md cursor-pointer">
                    Books
                </div>
            </template>
            <template v-slot:dropdown_body>
                <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex border-b">
                    Books
                </a>
                <a href="#" class="hover:bg-gray-100 hover:text-blue-600 p-4 w-full flex">
                    Subjects
                </a>
            </template>
        </dropdown>
        <navbar-link :to="{ name: 'home' }">Visitors</navbar-link>
    </nav>
</template>

<script>
import Dropdown from './Dropdown';
import NavbarLink from './NavbarLink'
import DropdownLink from './DropdownLink'

export default {
    components: { Dropdown, NavbarLink, DropdownLink },
}
</script>
