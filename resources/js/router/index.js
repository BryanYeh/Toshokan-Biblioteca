import Home from "../pages/Home";
import About from "../pages/About";
import NotFound from "../pages/NotFound"
import PatronProfile from "../pages/admin/PatronProfile"

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },

    { path: "/patron/:uuid", name: "patron.view", component: PatronProfile, props: true},

    { path: "/:catchAll(.*)", component: NotFound },
];

export default routes;
