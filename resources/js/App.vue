<template>
  <div>
    <h1>Categories</h1>
    <form @submit.prevent="addCategory">
      <input type="text" v-model="newCategoryName">
      <button type="submit">Add Category</button>
    </form>
    
    <table class="table table-striped table-dark">
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
  </script>
  





  <!-- <template>
    <div>
      <h1>Products</h1>
      <ul>
        <li v-for="product in products" :key="product.id">
          {{ product.name }} - Category: {{ getCategoryName(product.category_id) }} -
          Name: {{ product.name }} - Description: {{ product.description }}
          <button @click="editProduct(product)">Edit</button>
          <button @click="deleteProduct(product.id)">Delete</button>
        </li>
      </ul>
      <h2>Add Product</h2>
      <form @submit.prevent="addProduct">
        <input type="text" v-model="newProduct.name" placeholder="Product Name">
        <input type="text" v-model="newProduct.description" placeholder="Description">
        <input type="number" v-model="newProduct.price" placeholder="Price">
        <select v-model="newProduct.category_id" required>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
        </select>
        <button type="submit">Add Product</button>
      </form>
      <h2>Edit Product</h2>
      <form v-if="editingProduct" @submit.prevent="updateProduct">
        <input type="text" v-model="editingProduct.name" placeholder="Product Name">
        <input type="text" v-model="editingProduct.description" placeholder="Description">
        <input type="number" v-model="editingProduct.price" placeholder="Price">
        <select v-model="editingProduct.category_id" required>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name}}</option>
        </select>
        <button type="submit">Update Product</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        products: [],
        categories: [],
        newProduct: {
          name: '',
          description: '',
          price: null,
          category_id: null
        },
        editingProduct: null
      };
    },
    mounted() {
      this.fetchProducts();
      this.fetchCategories();
    },
    methods: {
      fetchProducts() {
        axios.get('/api/products')
          .then(response => {
            this.products = response.data;
          })
          .catch(error => {
            console.error('Error fetching products:', error);
          });
      },
      fetchCategories() {
        axios.get('/api/categories')
          .then(response => {
            this.categories = response.data;
          })
          .catch(error => {
            console.error('Error fetching categories:', error);
          });
      },
      addProduct() {
        axios.post('/api/products', this.newProduct)
          .then(response => {
            this.products.push(response.data);
            this.clearNewProduct();
          })
          .catch(error => {
            console.error('Error adding product:', error);
          });
      },
      editProduct(product) {
        this.editingProduct = { ...product };
      },
      updateProduct() {
        axios.put(`/api/products/${this.editingProduct.id}`, this.editingProduct)
          .then(() => {
            const index = this.products.findIndex(p => p.id === this.editingProduct.id);
            if (index !== -1) {
              this.products[index] = { ...this.editingProduct };
              this.editingProduct = null;
            }
          })
          .catch(error => {
            console.error('Error updating product:', error);
          });
      },
      deleteProduct(productId) {
        axios.delete(`/api/products/${productId}`)
          .then(() => {
            this.products = this.products.filter(product => product.id !== productId);
          })
          .catch(error => {
            console.error('Error deleting product:', error);
          });
      },
      clearNewProduct() {
        this.newProduct = {
          name: '',
          description: '',
          price: null,
          category_id: null
        };
      },
      getCategoryName(categoryId) {
      const category = this.categories.find(cat => cat.id === categoryId);
      return category ? category.name : '';
    }
    }
  };
  </script>
   -->