import Home from "../pages/Home";
import About from "../pages/About";
import NotFound from "../pages/NotFound"
import PatronProfile from "../pages/Admin/Patron/PatronProfile"
import PatronList from "../pages/Admin/Patron/PatronList"
import PatronEdit from "../pages/Admin/Patron/PatronEdit"
import VisitorList from "../pages/Admin/Visitor/VisitorList"
import VisitorProfile from "../pages/Admin/Visitor/VisitorProfile"
import VisitorUpgrade from "../pages/Admin/Visitor/VisitorUpgrade"

const routes = [
    { path: "/", name: "home", component: Home },
    { path: "/about", name: "about", component: About },

    { path: "/patrons", name: "patrons", component: PatronList},
    { path: "/patron/:uuid", name: "patron.view", component: PatronProfile, props: true},
    { path: "/patron/edit/:uuid", name: "patron.edit", component: PatronEdit, props: true},

    { path: "/visitors", name: "visitors", component: VisitorList},
    { path: "/visitor/:uuid", name: "visitor.view", component: VisitorProfile, props: true},
    { path: "/visitor/upgrade/:uuid", name: "visitor.upgrade", component: VisitorUpgrade, props: true},


    { path: "/:catchAll(.*)", component: NotFound },
];

export default routes;
