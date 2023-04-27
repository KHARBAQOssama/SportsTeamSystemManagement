<template>
  <router-view></router-view>
  <Alert v-if="show" :message="message" @cancel="show = false"></Alert>
</template>

<script>
import api from '@/api';
import { useUserStore } from './stores/userStore';
import { useBlogStore } from './stores/blogStore';
import { useAuthStore } from './stores/authStore';
import { useGameStore } from './stores/gameStore';
import { useTournamentStore } from './stores/tournamentStore';
import { useBranchStore } from './stores/branchStore';
import { useProductStore } from './stores/productStore';
import { useCartStore } from './stores/cartStore';
import { useTeamStore } from './stores/teamStore';
import { useRouter } from 'vue-router';

import Alert from './components/Alert.vue';

import router from './routes';

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
        router.push('/');
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
        () => useCartStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useProductStore().message,
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
      this.$watch(
        () => useGameStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useTournamentStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useBranchStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useTeamStore().message,
        (newMessage, oldMessage) => {
          this.fillMessage(newMessage)
        }
      );
      this.$watch(
        () => useBlogStore().message,
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
          // this.show = false
        },3000)
      },
    }
}
</script>

<style lang="scss" scoped>

</style>


