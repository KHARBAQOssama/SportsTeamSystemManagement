<template>
  <div class="d-flex" id="dashboard">
      <Sidebar></Sidebar>
    <div id="content" class="p-4 py-1 h-100">
        <div class="w-100">
            <router-view></router-view>
        </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue'
import { useUserStore } from '../stores/userStore'
import { useAuthStore } from '../stores/authStore'
import { useBranchStore } from '../stores/branchStore'
import { useTeamStore } from '../stores/teamStore'
import { useRoleStore } from '../stores/roleStore'

import router from '../routes';

export default {
    components:{
        Sidebar,
    },
    async created(){
        await useAuthStore().me()
        if(useAuthStore().user == null) router.push('/')
        useRoleStore().fetchRoles()
        useBranchStore().fetchBranches()
        
    },

}
</script>

<style>
#dashboard{
    height: 100vh !important;
    width: 100vw !important;
    overflow: hidden;
    position: relative;
}
#content{
  flex: 1;
  overflow-y: scroll;
}
@media (max-width: 760px) {
  #content{
    margin-left: 65px;
  }
}
</style>