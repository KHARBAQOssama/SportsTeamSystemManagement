<template>
  <router-view></router-view>
  <Alert v-if="show" :message="message" @cancel="show = false"></Alert>
</template>

<script>
import api from '@/api';
import { useUserStore } from './stores/userStore';
import { useAuthStore } from './stores/authStore';
import { useRouter } from 'vue-router';

import Alert from './components/Alert.vue';

export default {
    components:{
      Alert,
    },
    data() {
        return {
          show : false ,
          message : '',
        };
    },
    async created(){
      await useAuthStore().me();
      if(!useAuthStore().user){
        useRouter().push('/sign');
      }
    },
    mounted(){
      this.$watch(
        () => useUserStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useAuthStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      setTimeout(()=>{
        AuthStore.refresh();
      },60000)
    },
    methods: {
      fillMessage(message) {
        this.show = true;
        this.message = message;
        setTimeout(function(){
          this.message = 'false'
        },1000)
      },
    }
}
</script>

<style lang="scss" scoped>

</style>


