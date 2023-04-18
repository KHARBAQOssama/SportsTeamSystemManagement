<template>
  <div class="d-flex" id="dashboard">
      <Sidebar></Sidebar>
    <div id="content" class="p-4 py-1 h-100">
        <GlobalSearch></GlobalSearch>
        <div class="w-100">
            <router-view></router-view>
        </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue'
import GlobalSearch from '../components/GlobalSearch.vue'
export default {
    components:{
        Sidebar,
        GlobalSearch
    }

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