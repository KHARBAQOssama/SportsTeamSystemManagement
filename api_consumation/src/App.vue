<template>

  <!-- <MyNavbar></MyNavbar> -->
<!-- <SignPage></SignPage> -->
<!-- <AddTournamentForm></AddTournamentForm> -->
  <!-- <LandingGames></LandingGames> -->
  <!-- <teams></teams> -->
  <router-view></router-view>
  <!-- <Profile></Profile> -->
  <Alert v-if="show" :message="message" @cancel="show = false"></Alert>
</template>

<script>
import api from '@/api';
import { useUserStore } from './stores/userStore';
import { useAuthStore } from './stores/authStore';

export default {
        components:{
        },
        data() {
            return {
              show : false ,
              message : 'nothing to say'
            };
        },
        
        mounted(){
        },
        
        computed:{
        },
        methods: {
        }
    }
</script>

<style lang="scss" scoped>

</style>


