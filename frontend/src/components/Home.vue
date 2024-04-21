<template>
    <div class="container mt-5">
      <h1>Welcome to the Application</h1>
      <button class="btn btn-primary" @click="goToRegister">Register</button>
      <button class="btn btn-secondary ml-2" @click="goToLogin">Login</button>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      goToRegister() {
        this.$router.push('/register');
      },
      goToLogin() {
        this.$router.push('/login');
      }
    }
  }
  </script>
  