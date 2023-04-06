<template>

  <!-- <div>
    <form @submit="formSubmit" enctype="multipart/form-data">
      <img v-show="imageUrl" :src="baseURL + imageUrl" alt="">
      <input type="file" class="form-control" v-on:change="onChange">
      <button class="btn btn-primary btn-block">Upload</button>
  </form>
    <form @submit.prevent="login" enctype="multipart/form-data">
      <input type="text" v-model="email">
      <input type="password" v-model="password">
      <button class="btn btn-primary btn-block">login</button>
  </form>
  <div>
    <div v-if="user">{{ user.first_name }} <img :src="baseURL + user.image_url" height="30" alt=""></div>
    <div v-if="user">{{ user.last_name }} </div>
    <div v-if="user">{{ user.id }} </div>
    <div v-if="user">{{ user.email }} </div>
  </div>
      <div v-for="user in users" :key="user.id">{{ user.first_name }} </div>
  </div> -->
  <!-- <MyNavbar></MyNavbar> -->
<!-- <SignPage></SignPage> -->
<AddTournamentForm></AddTournamentForm>
  <!-- <LandingGames></LandingGames>
  <JoinUs></JoinUs> -->
</template>

<script>
import api from '@/api';
import { useUserStore } from './stores/userStore';
import { useAuthStore } from './stores/authStore';
import MyNavbar from './components/Navbar.vue'
import LandingGames from './components/LandingGames.vue'
import AddTournamentForm from './components/AddTournamentForm.vue'
import SignPage from './views/SignPage.vue'
import JoinUs from './components/JoinUs.vue'
import Footer from './components/Footer.vue'
export default {
        components:{
          MyNavbar,
          Footer,
          JoinUs,
          LandingGames,
          AddTournamentForm,
          SignPage
        },
        data() {
            return {
                imageUrl: null,
                image: '',
                success: '',
                baseURL: 'http://localhost:8000',
                email: '',
                password: '',
            };
        },
        
        // mounted(){
        //   useUserStore().fetchUsers();
        // },
        
        // computed:{
        //     users(){
        //       return useUserStore().users
        //     },
        //     user(){
        //       return useAuthStore().user
        //     },
        //     async images(){
        //         await api.get('/images')
        //             .then(function (res) {
        //                 console.log(res.data);
        //                 return res.data
        //             })
        //             .catch(function (err) {
        //                 console.log(err)
        //             });
        //     },
        // },
        // methods: {
        //     onChange(e) {
        //         this.image = e.target.files[0];
        //     },
        //     formSubmit(e) {
        //         e.preventDefault();
        //         let existingObj = this;
        //         let data = new FormData();
        //         data.append('image', this.image);
        //         api.post('/image', data)
        //             .then(function (res) {
        //                 existingObj.imageUrl = res.data.url
        //                 console.log(res.data.url)
        //             })
        //             .catch(function (err) {
        //                 console.log(err)
        //             });
        //     },
        //     login(){
        //       let data = new FormData();
        //       data.append('email', this.email);
        //       data.append('password', this.password);

        //       useAuthStore().login(data);
        //     }

        // }
    }
</script>

<style lang="scss" scoped>

</style>


