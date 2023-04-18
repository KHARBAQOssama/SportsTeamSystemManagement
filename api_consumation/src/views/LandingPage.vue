<template>  
    <div id="landing-page" class="position-relative">
      <Navbar></Navbar>
      <NextGame></NextGame>
      <JoinUs v-if="!user"></JoinUs>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import JoinUs from '../components/JoinUs.vue';
import NextGame from '../components/NextGame.vue'
import LandingStore from '../components/LandingStore.vue'
import { useAuthStore } from '../stores/authStore';
export default {
    components:{
      Navbar,
      JoinUs,
      NextGame,
      LandingStore
    },
    data() {
      return {

      };
    },
    computed:{
      user(){
        return useAuthStore().user
      }
    },
    created(){
    },
    methods: {
    }
}
</script>

<style lang="scss" scoped>
#landing-page{
  height: 100%;
  width: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  background-color: black;
}
</style>