<template>
    <nav 
        :class="collapsed ? 'h-100 px-2 py-3 bg-black  d-flex flex-column collapsed' : 'h-100 px-2 py-3 bg-black  d-flex flex-column'" id="sidebar">
            <div class="w-100 mb-3" id="toggler" @click="toggle()">
                <div class="ps-5 py-2 nav-item overflow-hidden d-flex position-relative">
                    <ion-icon name="menu-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                     <span class="ms-1 text-gold text-nowrap fs-5 fw-bold"><img class="nav-logo me-3" src="../assets/images/logo.png" height="25px" alt=""> STM</span>
                </div>
            </div>
            <div class="w-100">
                <router-link to="/sign" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="home-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Dashboard</span>
                </router-link>
                <router-link to="/dashboard/users" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="people-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Users</span>
                </router-link>
                <router-link to="/dashboard/branches" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="football-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Branches</span>
                </router-link>
                <router-link to="/dashboard/games" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="flash-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Games</span>
                </router-link>
                <router-link to="/dashboard/tournaments" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="trophy-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Tournaments</span>
                </router-link>
                <router-link to="/dashboard/blogs" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="albums-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Blogs</span>
                </router-link>
                <router-link to="/dashboard/products" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="pricetags-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Products</span>
                </router-link>
                <router-link to="/dashboard/profile" class="ps-5 py-2 nav-item my-1 overflow-hidden d-flex position-relative">
                    <ion-icon name="person-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold">Profile</span>
                </router-link>
                
            </div>
            <div class="w-100 mt-auto py-2">
                <router-link to="/"  @click="logOut" class="ps-5 py-2 nav-item overflow-hidden d-flex  position-relative">
                    <ion-icon name="log-out-outline" class="text-gold fs-4 me-2 position-absolute left-- nav-icon"></ion-icon>
                    <span class="ms-1 text-gold text-nowrap">Log Out</span>
                </router-link>
            </div>
    </nav>
</template>

<script>
import { useAuthStore } from '../stores/authStore';
import router from '../routes';

export default {
    components:{
    },
    data(){
        return {
            collapsed:true
        }
    },
    methods:{
        toggle(){
            this.collapsed = !this.collapsed
        },
        async logOut(){
            await useAuthStore().logOut();
            router.push('/')
        }
    }

}
</script>

<style lang="scss" scoped>
nav{
  width: 65px;
  transition: width .5s;
  flex-shrink: 0; 
  @media (max-width: 760px) {
    position: absolute;
    top: 0;
    left: 0;
    box-shadow: 0 0 20px rgba(75, 55, 4, 0.164);
    z-index: 99;
  }
    .left--{
        left: .7rem;
    }

    .nav-item{
        color:white;
        border-radius: .3em;
        &:hover ,&:hover > .nav-icon{
            background-color: rgb(249, 221, 150);
            color: rgb(200, 148, 18) !important;
        }
    }
    .nav-logo{
        filter:drop-shadow(2px 2px 0px#ffffff), drop-shadow(-2px -2px 0px #ffffff);
        -webkit-filter:drop-shadow(2px 2px 0px#ffffff), drop-shadow(-2px -2px 0px #ffffff);
    }
    
}
.collapsed{
  width: 220px;
}
</style>