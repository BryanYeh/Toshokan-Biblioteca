<template>
    <topbar />
    <navbar />
    <div class="bg-white container flex mt-5 mx-auto p-4 rounded-md shadow-md w-11/12">
        <router-view />
    </div>
</template>

<script>
import Topbar from "./components/TheTopbar"
import Navbar from "./components/TheNavbar"
export default {
    components: { Topbar, Navbar },

};
</script>
