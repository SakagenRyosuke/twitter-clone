import ExampleComponent from "./components/ExampleComponent.vue";
import UserListComponent from "./components/UserListComponent.vue";
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
];

const router = createRouter({
    routes,
    history: createWebHistory(),
});

export default router;
