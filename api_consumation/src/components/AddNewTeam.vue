<template>
  <div v-if="addNew" class="w-100 h-100 d-flex bg-gold-300 justify-content-center align-items-center position-fixed top-0 left-0 background-div">
        <form v-show="addNew"  class="row col-lg-4 col-md-8 col-9 bg-white shadow-lg py-3 position-relative" action="" @submit.prevent="addNewTeam">
            <button class="position-absolute top-0 left-0 cancel-button event-button col-1 ms-5 mt-3" @click.prevent="cancelNewTeam"><i class="uil uil-cancel fs-2"></i></button>
            <h5 class="text-center my-2 col-10 ms-auto">Add New Team</h5>
            <input class="col-10 m-auto my-2 p-2" type="text" placeholder="name" v-model="newTeam.name">
            <input class="col-10 m-auto my-2 p-2" type="text" placeholder="slag" v-model="newTeam.slag">
            <input class="col-10 m-auto my-2 p-2" type="text" placeholder="country" v-model="newTeam.country">
            <input class="col-10 m-auto my-2 p-2" type="text" placeholder="city" v-model="newTeam.city">
            <input class="col-10 m-auto my-2 p-2" type="text" placeholder="stadium" v-model="newTeam.stadium">
            <img class="col-3 d-block ms-auto" v-if="newTeam.image" :src="newTeam.image" alt="">
            <div :class="newTeam.image ? 'col-7 my-2 me-auto d-flex align-items-center':'col-9 my-2 m-auto d-flex align-items-center'">
              <input class="" id="teamImage" type="file" @change="$event=>onTeamImageChange($event)">
              <label for="teamImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
            </div>
            <button class="col-6 mx-auto brand-gold-button">done</button>
        </form> 
    </div>
</template>

<script>
import {useTeamStore} from '../stores/TeamStore'
export default {

}
</script>

<style>

</style>