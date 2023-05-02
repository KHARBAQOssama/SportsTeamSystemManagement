<template>
  <div class="w-100 row justify-content-around align-items-stretch gap-3 py-3">
    <h3>Statics</h3>
    <div v-if="tournaments" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{tournaments}}</h3>
        <p>Tournaments</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="trophy-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
    <div v-if="products" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{products}}</h3>
        <p>Products</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="pricetags-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
    <div v-if="blogs" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{blogs}}</h3>
        <p>Blogs</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="albums-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
    <div v-if="users" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{users}}</h3>
        <p>Users</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="people-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
    <div v-if="games" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{games.played.length}}</h3>
        <p>Old Games</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="flash-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
    <div v-if="games" class="col-md-4 col-lg-3 col-10 m-auto d-flex align-items-center justify-content-between shadow px-3 py-2 my-2 text-gold rounded-2 border">
      <div class="w-75 justify-content-center d-flex flex-column py-2">
        <h3 style="margin-bottom:-5px;">{{games.notPlayed.length}}</h3>
        <p>Coming Games</p>
      </div>
      <div class="w-25 justify-content-center align-items-center d-flex">
        <div class="rounded-circle overflow hidden bg-gold justify-content-center align-items-center d-flex" style="width:60px; height:60px;">
          <ion-icon name="flash-outline" class="text-white fs-4"></ion-icon>
        </div>
      </div>
    </div>
  </div>
  
</template>

<script>
import { useUserStore } from '../stores/userStore';
import { useBlogStore } from '../stores/blogStore';
import { useGameStore } from '../stores/gameStore';
import { useTournamentStore } from '../stores/tournamentStore';
import { useProductStore } from '../stores/productStore';
import NextGame from './NextGame.vue';
export default {
  components:{
    NextGame,
  },
  created(){
        useTournamentStore().fetchTournaments()
        useBlogStore().fetchBlogs()
        useGameStore().fetchGames()
        useUserStore().fetchUsers()
        useProductStore().fetchProducts()
    },
  computed:{
        tournaments(){
          return useTournamentStore().tournaments.length
        },
        blogs(){
          return useBlogStore().blogs.length
        },
        products(){
          return useProductStore().products.length
        },
        users(){
          return useUserStore().users.length
        },
        games(){
          return useGameStore().games
        },
  }
}
</script>

<style>

</style>