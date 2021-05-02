<template>
    <topbar />
    <navbar />
    <div class="container flex flex-wrap lg:flex-nowrap lg:space-x-4 mx-auto w-11/12">
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
