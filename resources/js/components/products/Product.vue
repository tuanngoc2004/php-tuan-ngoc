<template>
    <a-card title="Categories" style="width: 100%;">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a-button type="primary" @click="showAddCategoryModal">
                    <i class="fa-solid fa-plus"></i>
                </a-button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a-table :dataSource="categories" :columns="columns">
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'action'">
                            <a-button type="primary" class="me-sm-2 mb-2" @click="editCategory(record)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a-button>
                            <a-button type="primary" danger @click="deleteCategory(record.id)">
                                <i class="fa-solid fa-trash-can"></i>
                            </a-button>
                        </template>
                        <template v-else>
                            {{ column.dataIndex === 'category_id' ? getCategoryName(record.category_id) : record[column.dataIndex] }}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <a-modal v-model:open="editModalOpen" title="Edit Category" @ok="updateCategory" :confirmLoading="confirmLoading">
            <a-input v-model:value="editedProduct.name" placeholder="Product Name"></a-input>
            <a-input v-model:value="editedProduct.description" placeholder="Description"></a-input>
            <a-input-number v-model:value="editedProduct.price" placeholder="Price" style="width: 100%;"></a-input-number>
            <a-select v-model:value="editedProduct.category_id" placeholder="Select Category" style="width: 100%;">
                <a-select-option v-for="category in categoriesList" :key="category.id" :value="category.id">
                    {{ category.name }}
                </a-select-option>
            </a-select>
        </a-modal>

        <!-- Add Category Modal -->
        <a-modal v-model:open="addModalOpen" title="Add Category" @ok="addCategory" :confirmLoading="confirmLoading">
            <a-input v-model:value="newCategory.name" placeholder="Product Name"></a-input>
            <a-input v-model:value="newCategory.description" placeholder="Description"></a-input>
            <a-input-number v-model:value="newCategory.price" placeholder="Price" style="width: 100%;"></a-input-number>
            <a-select v-model:value="newCategory.category_id" placeholder="Select Category" style="width: 100%;">
                <a-select-option v-for="category in categoriesList" :key="category.id" :value="category.id">
                    {{ category.name }}
                </a-select-option>
            </a-select>
        </a-modal>
    </a-card>
</template>



<script>
import axios from "axios";
import { Modal, Button, Table, Card, message, Input, InputNumber, Select } from 'ant-design-vue';

export default {
    components: {
        'a-button': Button,
        'a-table': Table,
        'a-card': Card,
        'a-modal': Modal,
        'a-input': Input,
        'a-input-number': InputNumber,
        'a-select': Select,
        'a-select-option': Select.Option
    },
    data() {
        return {
            categories: [],
            categoriesList: [],
            newCategory: {
                name: '',
                description: '',
                price: null,
                category_id: null
            },
            columns: [
                {
                    title: 'ID',
                    dataIndex: 'id',
                    key: 'id',
                },
                {
                    title: 'Category',
                    dataIndex: 'category_id',
                    key: 'category_id',
                },
                {
                    title: 'Name',
                    dataIndex: 'name',
                    key: 'name',
                },
                {
                    title: 'Description',
                    dataIndex: 'description',
                    key: 'description',
                },
                {
                    title: 'Price',
                    dataIndex: 'price',
                    key: 'price',
                },
                {
                    title: 'Actions',
                    key: 'action',
                    scopedSlots: { customRender: 'action' },
                },
            ],
            editModalOpen: false,
            addModalOpen: false,
            editedProduct: {},
            confirmLoading: false
        };
    },
    created() {
        this.fetchCategories();
        this.fetchCategoriesList();
    },
    methods: {
        fetchCategories() {
            axios.get('/api/products')
                .then(response => {
                    this.categories = response.data;
                })
                .catch(error => {
                    console.error('Error fetching categories:', error);
                });
        },
        fetchCategoriesList() {
            axios.get('/api/categories')
                .then(response => {
                    this.categoriesList = response.data;
                })
                .catch(error => {
                    console.error('Error fetching categories list:', error);
                });
        },
        getCategoryName(categoryId) {
            const category = this.categoriesList.find(cat => cat.id === categoryId);
            return category ? category.name : '';
        },
        showAddCategoryModal() {
            this.addModalOpen = true;
        },
        addCategory() {
            this.confirmLoading = true;
            axios.post('/api/products', this.newCategory)
                .then(response => {
                    if (response.status === 200) {
                        message.success("Product added successfully");
                        this.fetchCategories();
                        this.addModalOpen = false;
                        this.newCategory = { name: '', description: '', price: null, category_id: null };
                    }
                })
                .catch(error => {
                    console.error(error)
                })
                .finally(() => {
                    this.confirmLoading = false;
                });
        },
        editCategory(category) {
            this.editedProduct = { ...category };
            this.editModalOpen = true;
        },
        updateCategory() {
            this.confirmLoading = true;
            axios.put(`/api/products/${this.editedProduct.id}`, this.editedProduct)
                .then(response => {
                    if (response.status === 200) {
                        message.success("Product updated successfully");
                        this.fetchCategories();
                        this.editModalOpen = false;
                    }
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.confirmLoading = false;
                });
        },
        deleteCategory(id) {
            Modal.confirm({
                content: 'Are you sure you want to delete this product?',
                onOk: () => {
                    axios.delete(`/api/products/${id}`)
                        .then(response => {
                            if (response.status === 200) {
                                message.success("Product deleted successfully");
                                this.fetchCategories();
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
                cancelText: "Cancel",
                onCancel() {
                    Modal.destroyAll();
                },
            });
        }
    }
};
</script>
