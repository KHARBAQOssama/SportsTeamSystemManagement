<template>
    <form class="d-flex flex-column">
      <h1>Add Tournament</h1>
      <input v-model="tournament.name" type="text" placeholder="name">
      <input v-model="tournament.win_points" type="number" placeholder="win points">
      <input v-model="tournament.lost_points" type="number" placeholder="lose points">
      <input v-model="tournament.draw_points" type="number" placeholder="draw points">
      <input v-model="tournament.start_date" type="date" placeholder="start date">
      <input type="file" placeholder="image">
      <input v-model="tournament.randomMatches" type="checkbox" name="" id="">

      <div class="border-2 border-dark p-5">
        <div v-for="(team, index) in teams" :key="index">
            <input type="text" :value="teamValue(index)" @input="setTeamValue(index, $event.target.value)">
            <button @click.prevent="removeTeam(index)" v-if="teams.length > 1">Remove</button>
        </div>
        <button @click.prevent="addTeam">Add Team</button>
        <button @click.prevent="submitTeams">Submit Teams</button>
        <div v-for="team in teams" :key="team"> {{ team }} </div>
      </div>
      <button @click.prevent="done()">done</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            teams: [''],
            new_teams:[{}],
            tournament: {
                name:'',
                win_points:'',
                draw_points:'',
                lost_points:'',
                start_date:'',
                randomMatches: false,
            },
        }
    },
    methods: {
        addTeam() {
        this.teams.push(null);
        },
        removeTeam(index) {
        this.teams.splice(index, 1);
        },
        submitTeams() {
        console.log(this.teams);
        },
        setTeamValue(index, value) {
        this.teams[index] = value;
        }
    },
    computed: {
        teamValue() {
        return (index) => this.teams[index];
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
