<template>  
    <div class="w-100">
      <NextGame></NextGame>
      <LandingStore></LandingStore>
      <LandingBlog></LandingBlog>
      <JoinUs v-if="!user"></JoinUs>
    </div>
</template>

<script>
import JoinUs from '../components/JoinUs.vue';
import NextGame from '../components/NextGame.vue'
import LandingStore from '../components/LandingStore.vue'
import LandingBlog from '../components/LandingBlogs.vue'
import { useAuthStore } from '../stores/authStore';
export default {
    components:{
      JoinUs,
      NextGame,
      LandingStore,
      LandingBlog
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
        // useProductStore().fetchProducts()
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