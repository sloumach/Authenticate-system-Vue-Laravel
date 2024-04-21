<template>
    <div class="container mt-5">
      <h2>Dashboard</h2>
      <p>Welcome to your dashboard! You can upload an image here.</p>
      <form @submit.prevent="uploadImage">
        <div class="mb-3">
          <label for="image" class="form-label">Select image to upload:</label>
          <input type="file" class="form-control" id="image" @change="handleFileUpload">
        </div>
        <button type="submit" class="btn btn-primary">Upload Image</button>
      </form>
      <p v-if="message">{{ message }}</p>
      <img v-if="imageUrl" :src="imageUrl" alt="User Image" width="100" height="100">
      <button @click="logout" class="btn btn-danger">Logout</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        selectedFile: null,
        message: '',
        imageUrl: localStorage.getItem('image_url') || null  // Obtenez l'URL de l'image
      };
    },
    methods: {
      handleFileUpload(event) {
        this.selectedFile = event.target.files[0];
      },
      async uploadImage() {
        const formData = new FormData();
        formData.append('image', this.selectedFile);
  
        try {
          const response = await axios.post('http://localhost:8000/api/upload-image', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
          });
          this.message = response.data.message;
          this.imageUrl = 'http://localhost:8000/' + response.data.image; // Assurez-vous d'ajouter le chemin complet si nécessaire
        } catch (error) {
          this.message = error.response.data.message;
        }
      },
      async logout() { // Ajoutez async ici
        await axios.post('http://localhost:8000/api/logout', {}, {
            headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            }
        });
        localStorage.removeItem('auth_token');  // Supprimez le token du localStorage
        localStorage.removeItem('image_url');  // Supprimez l'image URL du localStorage
        this.$router.push('/login');  // Redirigez l'utilisateur vers la page de connexion
      }
    }
  }
  </script>
