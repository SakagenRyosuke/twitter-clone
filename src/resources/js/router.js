import ExampleComponent from "./components/ExampleComponent.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/home",
        component: ExampleComponent,
        name: "home",
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
});

export default router;
