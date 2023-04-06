<template>
    <form class="d-flex flex-column">
      <h1>Add Tournament</h1>
      <input v-model="tournament.name" type="text" placeholder="name">
      <input v-model="tournament.win_points" type="number" placeholder="win points">
      <input v-model="tournament.loss_points" type="number" placeholder="lose points">
      <input v-model="tournament.draw_points" type="number" placeholder="draw points">
      <input v-model="tournament.start_date" type="date" placeholder="start date">
      <img v-show="tournament.image" height="100" width="100" :src="tournament.image" alt="">
      <input type="file" @change="$event=>onTournamentImageChange($event)">
      <input v-model="tournament.randomMatches" type="checkbox" name="" id="">


      <div class="border-2 border-dark p-5">
        <div v-for="(team, index) in tournament.teams" :key="index">
            <select name="" id="" :value="teamValue(index)" @change="setTeamValue(index, $event.target.value)">choose Team
              <option value="1">team 1</option>
              <option value="2">team 2</option>
              <option value="3">team 3</option>
              <option value="4">team 4</option>
              <option value="5">team 5</option>
              <option value="6">team 6</option>
              <option value="other">other</option>
            </select>
            <button @click.prevent="removeTeam(index)" v-if="tournament.teams.length > 1">Remove</button>
        </div>

        <div v-for="(team, index) in tournament.new_teams" :key="index">
          <input v-model="team.name" type="text" placeholder="name">
          <input v-model="team.slag" type="text" placeholder="slag">
          <input v-model="team.country" type="text" placeholder="country">
          <input v-model="team.city" type="text" placeholder="city">
          <input v-model="team.stadium" type="text" placeholder="stadium">
          <img v-show="team.image" height="100" :src="team.image" alt="">
          <input type="file" @change="$event=>onImageChange($event,index)">
          <button @click.prevent="removeNewTeam(index)" v-if="tournament.new_teams.length >= 1" >Remove</button>
        </div>

        <button @click.prevent="addTeam">Add Team</button>
        <button @click.prevent="submitTeams">Submit tournament.teams</button>
        <div v-for="team in tournament.teams" :key="team"> {{ team }} </div>
      </div> 
      <button @click.prevent="done()">done</button>
    </form>
</template>

<script>
import {useTournamentStore} from '../stores/tournamentStore'


export default {
    data() {
        return {
            tournament: {
                name:'',
                win_points:null,
                draw_points:null,
                loss_points:null,
                start_date:null,
                randomMatches: false,
                teams: [''],
                new_teams:[],
            },
        }
    },
    computed: {
      reversedNewTeams() {
        return this.tournament.new_teams.slice().reverse();
      }
    },
    methods: {
        addTeam() {
          this.tournament.teams.push(null);
        },
        removeTeam(index) {
          this.tournament.teams.splice(index, 1);
        },
        removeNewTeam(index) {
          this.tournament.new_teams.splice(index, 1);
        },
        submitTeams() {
          console.log(this.tournament.teams);
        },
        setTeamValue(index, value) {
          if(value == 'other'){
            let object = {
              name: '',
              slag: '',
              city: '',
              country: '',
              stadium: '',
              image: null,
            }
            this.tournament.new_teams.push(object);
            this.tournament.teams[index] = 'other';
          }else{
              this.tournament.teams[index] = value;
          }
        
        },
        onTournamentImageChange(event){
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.onload = () => {
            this.tournament.image = reader.result;
          };
          reader.readAsDataURL(file);
        },
        onImageChange(event,index){
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.onload = () => {
            this.tournament.new_teams[index].image = reader.result;
          };
          reader.readAsDataURL(file);
        },
        done(){
          useTournamentStore().store(this.tournament);
        }
    },
    computed: {
        teamValue() {
          return (index) => this.tournament.teams[index];
        }
    }
}
</script>

<style scoped>

input {
  margin-right: 10px;
}
button {
  margin-left: 10px;
}
</style>
