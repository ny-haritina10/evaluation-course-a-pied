import { createApp } from 'vue';
import router from './router';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import App from './App.vue';

const app = createApp(App);

app.use(router);
app.mount('#app');