<template>
    <div class="container mt-5">
      <h2>Login</h2>
      <form @submit.prevent="loginUser">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" v-model="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" v-model="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <p v-if="message">{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        message: ''
      };
    },
    methods: {
    async loginUser() {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: this.email,
          password: this.password
        });
        this.message = 'Logged in successfully!';
        // Stockez le token reçu pour l'authentification future
        localStorage.setItem('auth_token', response.data.access_token);
        localStorage.setItem('image_url', response.data.image || ''); // Stockez l'URL de l'image
        // Redirection vers le Dashboard
        this.$router.push('/dashboard');
      } catch (error) {
        this.message = 'Failed to login: ' + error.response.data.message;
      }
    }
  }
  }
  </script>
  