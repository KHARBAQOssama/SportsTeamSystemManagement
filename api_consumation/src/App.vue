<template>
  <router-view @message="fillMessage"></router-view>
  <Alert v-if="show" :message="message" @cancel="show = false"></Alert>
</template>

<script>
import api from '@/api';
import { useUserStore } from './stores/userStore';
import { useAuthStore } from './stores/authStore';


export default {
    data() {
        return {
          show : false ,
          message : '',
        };
    },
    created(){
    },
    computed:{
    },
    methods: {
      fillMessage(message){
        this.message = message.message
        this.show = true
      }
    }
}
</script>

<style lang="scss" scoped>

</style>


