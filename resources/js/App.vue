<template>
    <topbar />
    <navbar />
    <div class="container flex flex-wrap justify-between mx-auto w-11/12 mb-6">
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
