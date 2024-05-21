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

  
  





