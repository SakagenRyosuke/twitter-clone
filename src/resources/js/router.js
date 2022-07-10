import HomeComponent from "./components/HomeComponent.vue";
import UserListComponent from "./components/UserListComponent.vue";
import UserListDetailComponent from "./components/UserListDetailComponent.vue";
import TweetDetailComponent from "./components/TweetDetailComponent.vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/home",
        component: HomeComponent,
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
    {
        path: "/home/tweet/detail/:id",
        component: TweetDetailComponent,
        name: "tweetDetail",
        props: true,
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(),
});

export default router;
