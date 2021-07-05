import Home from "../pages/Home";
import About from "../pages/About";
import NotFound from "../pages/NotFound"
import PatronProfile from "../pages/Admin/Patron/PatronProfile"
import PatronList from "../pages/Admin/Patron/PatronList"

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },

    { path: "/patrons", name: "patrons", component: PatronList},
    { path: "/patron/:uuid", name: "patron.view", component: PatronProfile, props: true},

    { path: "/:catchAll(.*)", component: NotFound },
];

export default routes;
