import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useTeamStore = defineStore('team', {
    state: () => ({
        teams: [],
        teamAdded: {}
    }),
    actions: {
        async fetchTeams() {
            await api.get('/team')
            .then((response) => {
                this.teams = toRaw(response.data) ;
                // console.log(response.data) ;
                // return toRaw(response.data) ;
                localStorage.setItem('myTeams',JSON.stringify(this.teams))
            }).catch((err) => {
                console.log(err);
            });
        },
        async store(data) {
            await api.post('/team',data)
            .then((response) => {
                this.teamAdded = toRaw(response.data.team)
            }).catch((err) => {
                console.log(err);
            });
        },
    }
})