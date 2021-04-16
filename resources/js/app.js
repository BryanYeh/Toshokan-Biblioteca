require("./bootstrap");

import { createApp } from "vue";
import routes from "./router/index";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).mount("#app");
