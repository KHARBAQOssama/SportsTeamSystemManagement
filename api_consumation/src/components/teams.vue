<template>
  <div class="d-flex flex-column w-25">
    <input type="text" v-model="filter" @input="filterTeams" class="col-8 my-1 py-2 m-auto mb-auto" placeholder="Search A Team">
      <div class="search-display col-8 m-auto px-3">
        <div class="fs-5 my-1" v-for="team in searchTeams" :key="team.id" @click="chooseHomeTeam(team)">
          {{ team.name }}
        </div>
      </div>
    <select name="" id="">
      <option value="home">Home</option>
      <option value="away">Away</option>
    </select>
    <input type="number" v-model="game.new_home_team_name" placeholder="new_home">
    <input type="number" v-model="game.new_away_team_name" placeholder="new away">
    <input type="checkbox" v-model="game.fans" placeholder="fans">
    <input type="date" v-model="game.date" placeholder="">
    <input type="time" step="60" v-model="game.start_time" placeholder="">
    <input type="text" v-model="game.referee1" placeholder="first referee">
    <input type="text" v-model="game.referee2" placeholder="first referee">
    <input type="text" v-model="game.referee3" placeholder="first referee">
    <input type="text" v-model="game.referee" placeholder="first referee">
    <input type="number" v-model="game.ticket_price" placeholder="ticket price">

<button @click="storeGame"> done</button>

<div v-if="gameAdded"> {{gameAdded.referee1}}</div>
<div>{{ game.start_time }}</div>



  </div>
</template>

<script>
import { useGameStore } from '../stores/gameStore';
import {useTeamStore} from '../stores/TeamStore'

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
        game:{
          away : null,
          home : null,
          new_away_team_name : null,
          new_home_team_name : null,
          referee1 : null,
          referee2 : null,
          referee3 : null,
          referee : null,
          fans : true,
          date : null,
          start_time : null,
          ticket_price : 0,
        }
      }
    },
    created(){
      useTeamStore().fetchTeams();
      this.existingTeams = JSON.parse(localStorage.getItem('myTeams'));
    },
    computed:{
      gameAdded(){
        return useGameStore().gameAdded;
      },
      teamJustAdded(){
        return useTeamStore().teamAdded
      }
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
      storeGame(){
        useGameStore().store(this.game);
      },
      chooseHomeTeam(team){
        if(team.id != 'other'){
          this.game.home = team
        }else{
          this.addNew = true
        }
        this.filter = null
        this.searchTeams = []
      },
      chooseAwayTeam(team){
        if(team.id != 'other'){
          this.game.away = team
        }else{
          this.addNew = true
        }
        this.filter = null
        this.searchTeams = []
      },
    }
    //  computed:{
    //      teams(){
    //          return useTeamStore().teams;
    //      }
    // },
    // async created(){
    //     useTeamStore().fetchTeams()
    // },
}
</script>

<style>

</style>