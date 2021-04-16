import Home from "../pages/Home";
import About from "../pages/About";
import NotFound from "../pages/NotFound"

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },
    { path: "/:catchAll(.*)", component: NotFound },
];

export default routes;
