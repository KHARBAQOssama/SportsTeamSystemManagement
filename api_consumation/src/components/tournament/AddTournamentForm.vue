<template>
  <div class="row add-tournament">
    <form class="col-lg-7 col-md-9 mx-auto row mb-auto" @submit.prevent="submitTournament">
      <h1 class="add tournament"></h1>
      <input class="col-8 m-auto my-2 p-2" type="text" name="" placeholder="name" v-model="tournament.name" id="">
      <div class="col-8 m-auto my-2 d-flex align-items-center p-0">
        <label for="start_date" class="me-3 w-50">Start Date</label>
        <input id="start_date" class="p-2 w-50 ms-auto" type="date" name="" placeholder="start_date" v-model="tournament.start_date">
      </div>
      <input class="col-8 m-auto my-2 p-2" type="number" name="" placeholder="win_points" v-model="tournament.win_points" id="">
      <input class="col-8 m-auto my-2 p-2" type="number" name="" placeholder="loss_points" v-model="tournament.loss_points" id="">
      <input class="col-8 m-auto my-2 p-2" type="number" name="" placeholder="draw_points" v-model="tournament.draw_points" id="">
      <input class="col-8 m-auto my-2 p-2" type="number" name="" placeholder="date_def" v-model="tournament.date_def" id="">
      <img class="col-5 d-block m-auto" v-show="tournament.image" :src="tournament.image" alt="">
      <div class="col-8 my-2 m-auto row">
        <input class="" id="tournamentImage" type="file" @change="$event=>onTournamentImageChange($event)">
        <label for="tournamentImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
      </div>
      
      <button class="col-5 mx-auto brand-gold-button">done</button>
    </form>
    <div class="col-lg-5 col-md-9 mx-auto mb-auto py-5 row setting-teams">
      <h5 class="text-center mb-3">Choose Teams For Tournament</h5>
         
      <input type="text" v-model="filter" @input="filterTeams" class="col-8 my-1 py-2 m-auto mb-auto" placeholder="Search A Team">
      <div class="search-display col-8 m-auto px-3">
        <div class="fs-5 my-1" v-for="team in searchTeams" :key="team.id" @click="chooseTeam(team)">
          {{ team.name }}
        </div>
      </div>
      <div v-if="teams.length" class="col-8 m-auto row teams-choosed">
        <div v-for="(team,index) in teams" :key="team" class="col-12 m-auto my-1 py-2 row item-choosed">
          <p class="col-8 overflow-hidden my-auto one-line-height">{{ team.name }}</p>
          <button class="col-2 ms-auto delete-button event-button" @click="deleteTeam(index)"><i class="uil uil-trash"></i></button>
        </div>
      </div> 
    </div>
    
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
  </div>
</template>

<script>
import {useTeamStore} from '../../stores/teamStore'
import {useTournamentStore} from '../../stores/tournamentStore'
export default {
  data(){
    return {
      searchTeams:[],
      teams:[],
      filter:null,
      existingTeams:null,
      newTeam:{
          name:null,
          slag:null,
          country:null,
          city:null,
          stadium:null,
          image:null,
      },
      addNew:false,
      tournament:{
          name:'',
          win_points:null,
          draw_points:null,
          loss_points:null,
          start_date:null,
          date_def:null,
          image:null
      }
    }
  },
  computed:{
    teamJustAdded(){
      return useTeamStore().teamAdded
    }
  },
  created(){
    useTeamStore().fetchTeams();
    this.existingTeams = JSON.parse(localStorage.getItem('myTeams'));
  },
  methods:{
    filterTeams(){
      this.searchTeams = this.existingTeams.filter(team => 
                            team.name.toLowerCase().search(this.filter.toLowerCase()) >= 0 
                            && !this.teams.includes(team))
      this.searchTeams.push({
        name : 'other',
        id:'other'
      })
    },

    chooseTeam(team){
      if(team.id != 'other'){
        this.teams.push(team)
      }else{
        this.addNew = true
      }
      this.filter = null
      this.searchTeams = []
    },

    async addNewTeam(){
      await useTeamStore().store(this.newTeam);
      console.log(this.teamJustAdded.id);
      this.newTeam = {
          name:null,
          slag:null,
          country:null,
          city:null,
          stadium:null,
          image:null,
      }
      this.teams.push(this.teamJustAdded)
      this.existingTeams.push(this.teamJustAdded)
      this.addNew = false
    },

    onTeamImageChange(event){
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = () => {
        this.newTeam.image = reader.result;
      };
      reader.readAsDataURL(file);
    },

    onTournamentImageChange(event){
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = () => {
          this.tournament.image = reader.result;
        };
        reader.readAsDataURL(file);
        console.log(this.tournament)
    },

    deleteTeam(index){
      this.teams.splice(index,1)
    },

    submitTournament(){
      this.tournament.teams = this.teams
      useTournamentStore().store(this.tournament)
    },

    cancelNewTeam(){
      this.addNew = null
    }
  }
}
</script>

<style scoped>
.add-tournament{
  overflow-y: scroll;
  overflow-x: hidden;
}
.background-div{
  overflow-y: scroll;
  overflow-x: hidden;
}
.setting-teams{
  max-height: 100vh;
  overflow: hidden;
  
}
.teams-choosed{
  max-height: 64vh;
  overflow-y: scroll;
}
</style>
