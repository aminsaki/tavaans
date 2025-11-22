
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './commons/App.vue'
import axios from 'axios';
import VueAxios from 'vue-axios'
import router from './commons/router'
import "@/commons/assets/css/iransans.css"
import Toast from "vue-toastification";
import 'sweetalert2/dist/sweetalert2.min.css';
import './assets/tailwind.css'
import "@/commons/assets/fonts/fontawesome-free/css/all.css"
/// bootstrap
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";

import webUrl from "../config/dev.json"
 // import webUrl from "../Config/prod.json";

let token = localStorage.getItem('token');
const options = {
    // You can set your default options here
};

axios.defaults.headers.common['Authorization'] = (token) ? token :  delete axios.defaults.headers.common['Authorization'];
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'X-Requested-With';
axios.defaults.baseURL = webUrl.BASE_URL


const app = createApp(App)
app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)
app.use(router)
app.use(Toast, options);
app.mount('#app')
