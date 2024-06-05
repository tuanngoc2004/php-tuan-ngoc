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
                    </template>
                </a-table>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <a-modal v-model:open="editModalOpen" title="Edit Category" @ok="updateCategory"
            :confirmLoading="confirmLoading">
            <a-input v-model:value="editedCategory.name" placeholder="Category Name"></a-input>
        </a-modal>

        <!-- Add Category Modal -->
        <a-modal v-model:open="addModalOpen" title="Add Category" @ok="addCategory" :confirmLoading="confirmLoading">
            <a-input v-model:value="newCategoryName" placeholder="Category Name"></a-input>
        </a-modal>
    </a-card>
</template>

<script>
import axios from "axios";
import { Modal, Button, Table, Card, message, Input } from 'ant-design-vue';

export default {
    components: {
        'a-button': Button,
        'a-table': Table,
        'a-card': Card,
        'a-modal': Modal,
        'a-input': Input
    },
    data() {
        return {
            categories: [],
            newCategoryName: '',
            columns: [
                {
                    title: 'ID',
                    dataIndex: 'id',
                    key: 'id',
                },
                {
                    title: 'Name',
                    dataIndex: 'name',
                    key: 'name',
                },
                {
                    title: 'Actions',
                    key: 'action',
                    scopedSlots: { customRender: 'action' },
                },
            ],
            editModalOpen: false,
            addModalOpen: false,
            editedCategory: {},
            confirmLoading: false
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
                    console.error('Error fetching categories:', error);
                });
        },
        showAddCategoryModal() {
            this.addModalOpen = true;
        },
        addCategory() {
            this.confirmLoading = true;
            axios.post('/api/categories', { name: this.newCategoryName })
                .then(response => {
                    if (response.status === 201) {
                        message.success("Category added successfully");
                        this.fetchCategories();
                        this.addModalOpen = false;
                        this.newCategoryName = ''; // Clear the input field
                    }
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    this.confirmLoading = false;
                });
        },
        editCategory(category) {
            this.editedCategory = { ...category };
            this.editModalOpen = true;
        },
        updateCategory() {
            this.confirmLoading = true;
            axios.put(`http://127.0.0.1:8000/api/categories/${this.editedCategory.id}`, this.editedCategory)
                .then(response => {
                    if (response.status === 200) {
                        message.success("Category updated successfully");
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
                content: 'Are you sure you want to delete this category?',
                onOk: () => {
                    axios.delete(`http://127.0.0.1:8000/api/categories/${id}`)
                        .then(response => {
                            if (response.status == 200) {
                                message.success("Category deleted successfully");
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