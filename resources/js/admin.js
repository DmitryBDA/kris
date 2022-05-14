import { createApp } from "vue";
import router from "./router-admin";

require('./bootstrap');

const app = createApp({});

app.component('admin', require('./components/admin/layout/admin.vue').default);
app.use(router)
app.mount("#app")
