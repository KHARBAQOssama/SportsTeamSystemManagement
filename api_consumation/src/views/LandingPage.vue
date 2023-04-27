<template>  
    <div id="landing-page" class="position-relative">
      <Navbar></Navbar>
      <router-view></router-view>
    </div>
</template>

<script>
import Navbar from '../components/Navbar.vue';

import { useAuthStore } from '../stores/authStore';
export default {
    components:{
      Navbar,

    },
    data() {
      return {

      };
    },
    // computed:{
    //   user(){
    //     return useAuthStore().user
    //   }
    // },
    // created(){
    //     // useProductStore().fetchProducts()
    // },
    // methods: {
    // }
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