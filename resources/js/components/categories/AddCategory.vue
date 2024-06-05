<template>
    <form @submit.prevent="createUsers()">
        <a-card title="Tạo mới Tài khoản" style="width: 100%">
            <div class="row mb-3">

                <div class="col-12 col-sm-8">

                    <div class="row mb-3">
                        <div class="col-12 col-sm-3 text-start text-sm-end">
                            <label>
                                <span class="text-danger me-1">*</span>
                                <span :class="{
                                    'text-danger': errors.name
                                }">
                                    Category name:
                                </span>
                            </label>
                        </div>

                        <div class="col-12 col-sm-5">
                            <a-input placeholder="Category name" 
                                allow-clear 
                                v-model:value="name" 
                                :class="{
                                'input-danger': errors.name
                            }" />

                            <div class="w-100"></div>

                            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 d-grid d-sm-flex justify-content-sm-end mx-auto">
                    <a-button class="me-0 me-sm-2 mb-3 mb-sm-0">
                        <!-- <router-link :to="{ name: 'admin-users' }"> -->
                            <span>Hủy</span>
                        <!-- </router-link> -->
                    </a-button>

                    <a-button type="primary" html-type="submit">
                        <span>Lưu</span>
                    </a-button>
                </div>
            </div>
        </a-card>
    </form>
</template>

<script>
import { defineComponent, ref, reactive, toRefs } from "vue";
import { useRouter } from "vue-router";
import { message } from 'ant-design-vue';
import { Button, Table, Card,Input } from 'ant-design-vue';


export default defineComponent({
    components: {
  'a-button': Button,
  'a-table': Table,
  'a-card': Card,
  'a-input': Input,
},

    setup() {
   
        const router = useRouter();
        const category = reactive({
            name: ""
        });

        const errors = ref({});


        const createUsers = () => {
            axios.post("http://127.0.0.1:8000/api/categories", category)
                .then((response) => {
                    if (response.status == 200) {
                        message.success("Tạo mới thành công!");
                        // router.push({ name: "admin-users" });
                    }
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        }

        return {
            ...toRefs(category),
            errors,
            createUsers
        }
    },
});
</script>
<style>
    .select-danger {
        border: 1px solid red;
    }

    .input-danger {
        border-color: red;
    }
</style>





<!-- <template>
    <div>
        <h1>Categories</h1>
        <form @submit.prevent="addCategory">
            <input type="text" v-model="newCategoryName">
            <button type="submit">Add Category</button>
        </form>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id">
                    <span v-if="editingCategory !== category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <button @click="editCategory(category.id)">Edit</button>
                            <button @click="deleteCategory(category.id)">Delete</button>
                        </td>
                    </span>
                    <span v-else>
                        <input type="text" v-model="category.name">
                        <td>
                            <button @click="cancelEdit(category.id)">Cancel</button>
                            <button @click="updateCategory(category)">Save</button>
                        </td>
                    </span>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
// import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            newCategoryName: '',
            editingCategory: null
        };
    },
    created() {
        this.fetchCategories();
    },
    methods: {
        fetchCategories() {
            axios.get('/api/categories')
            .then(response => {
                this.categories = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        },
        addCategory() {
            axios.post('/api/categories', { name: this.newCategoryName })
            .then(response => {
                this.categories.push(response.data);
                this.newCategoryName = '';
            })
            .catch(error => {
                console.log(error);
            });
        },
        editCategory(categoryId) {
            this.editingCategory = categoryId;
        },
        cancelEdit() {
            this.editingCategory = null;
        },
        updateCategory(category) {
            axios.put(`/api/categories/${category.id}`, category)
            .then(response => {
                this.editingCategory = null;
            })
            .catch(error => {
                console.log(error);
            });
        },
        deleteCategory(categoryId) {
            axios.delete(`/api/categories/${categoryId}`)
            .then(response => {
                this.categories = this.categories.filter(category => category.id !== categoryId);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
};
</script> -->
