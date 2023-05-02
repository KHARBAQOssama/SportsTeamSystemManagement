<template>
  <nav class="navbar navbar-expand-lg w-100 bg-black mb-auto">
    <div class="container-fluid p-0">
      <router-link class="navbar-brand ms-3 logo-link" to="#"><img src="../assets/images/logo.png" height="45px" class="me-2" alt="">STM</router-link>
      <button class="navbar-toggler ms-auto me-5 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="uil uil-location-arrow-alt"></i>
      </button>
      <div class="collapse navbar-collapse px-4 pe-5 bg-black mt-3" id="navbarTogglerDemo01">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item mx-3" v-if="user && (user.role_id == 1 || user.role_id == 2)">
            <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
          </li>
          <li class="nav-item mx-3">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item mx-3">
            <router-link class="nav-link" to="/store">Store</router-link>
          </li>
          <li class="nav-item mx-3" v-if="user">
            <router-link class="nav-link" to="#"  @click="logOut">Log Out</router-link>
          </li>
        </ul>
      </div>
    </div>
</nav>
</template>

<script>
import { useAuthStore } from '../stores/authStore';


import router from '../routes';

export default {
  computed:{
    user(){
      return useAuthStore().user
    }
  },
  created(){
  },
  methods:{
    async logOut(){
      await useAuthStore().logOut();
      location.reload();
    }
  }
}
</script>

<style lang="scss" scoped>
.logo-link{
  color: goldenrod;
  font-size: 35px;
  font-weight: lighter;
}
.nav-link{
  color: white;
  text-shadow: 0 0 5px rgb(37, 30, 11);
  font-size: 18px;
}
.nav-link:hover{
  color: goldenrod;
  text-shadow: 0;
}
.navbar-toggler{ 
  transition: all 0.3s;
  &:focus{
    box-shadow: 0 !important;
  }
  i{
    color: goldenrod;
  }
}
.collapsed{
  transform: rotate(180deg) !important;
}

</style>