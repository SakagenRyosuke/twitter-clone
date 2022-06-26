import ExampleComponent from "./components/ExampleComponent.vue";
import UserListComponent from "./components/UserListComponent.vue";
import UserListDetailComponent from "./components/UserListDetailComponent.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/home",
        component: ExampleComponent,
        name: "home",
    },
    {
        path: "/home/user-list",
        component: UserListComponent,
        name: "userList",
    },
    {
        path: "/home/user-profile/:id",
        component: UserListDetailComponent,
        name: "userListDetail",
        props: true,
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
});

export default router;
