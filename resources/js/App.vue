<template>
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
};
</script>
