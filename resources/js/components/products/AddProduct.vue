<template>
    <div>
        <h2>Add Product</h2>
        <form @submit.prevent="addProduct">
            <input type="text" v-model="newProduct.name" placeholder="Product Name">
            <input type="text" v-model="newProduct.description" placeholder="Description">
            <input type="number" v-model="newProduct.price" placeholder="Price">
            <select v-model="newProduct.category_id" required>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                </option>
            </select>
            <button type="submit">Add Product</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            newProduct: {
                name: '',
                description: '',
                price: null,
                category_id: null
            }
        };
    },
    methods: {
        addProduct() {
            axios.post('/api/products', this.newProduct)
            .then(response => {
                this.$emit('productAdded', response.data);
                this.clearNewProduct();
            })
            .catch(error => {
                console.error('Error adding product:', error);
            });
        },
        clearNewProduct() {
            this.newProduct = {
                name: '',
                description: '',
                price: null,
                category_id: null
            };
        }
    }
};
</script>
