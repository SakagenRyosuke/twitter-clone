require('./bootstrap');
import router from "./router.js";
import App from './App.vue';

import { createApp } from 'vue';

const app = createApp({});
app.component('app-vue',App);
app.use(router);
app.mount('#app');
