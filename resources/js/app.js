import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'
import axios from 'axios'
window.axios = axios;


import 'bootstrap/dist/css/bootstrap-grid.min.css'
import 'bootstrap/dist/css/bootstrap-utilities.min.css'
// import 'bootstrap/dist/css/bootstrap-grid.min.css'

const app = createApp(App);
app.mount("#app");
