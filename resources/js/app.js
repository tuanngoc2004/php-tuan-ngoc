import './bootstrap';
import { createApp } from 'vue';
// import App from './App.vue'
import Category from './components/categories/Category.vue';
import Product from './components/products/Product.vue';
import AddCategory from './components/categories/AddCategory.vue';
import axios from 'axios'
window.axios = axios;
import { 
    Checkbox,
    Input,
    InputPassword,
    Select,
    Avatar,
    Table,
    Card,
    Menu,
    List, 
    Drawer,
    Button, 
    message, 
} from 'ant-design-vue';

import 'bootstrap/dist/css/bootstrap-grid.min.css'
import 'bootstrap/dist/css/bootstrap-utilities.min.css'
import '../static/fontawesome-free-6.5.2-web (1)/fontawesome-free-6.5.2-web/css/all.min.css';
// import 'bootstrap/dist/css/bootstrap-grid.min.css'

const product = createApp(Product);
const category = createApp(Category);
const add_category = createApp(AddCategory);
category.mount("#add_category");
product.mount("#product");
category.mount("#category");
category.use(Card);
category.use(Button);
category.use(Table);
category.use(Input);

