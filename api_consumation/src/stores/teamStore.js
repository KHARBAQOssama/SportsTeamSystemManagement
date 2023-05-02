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
                this.teams = response.data ;
                // return toRaw(response.data) ;
                localStorage.setItem('myTeams',JSON.stringify(this.teams))
            }).catch((err) => {
                if(err.response.status == 404){
                    router.push('/404');
                  }
                  if(err.response.status == 403){
                    router.push('/403');
                  }
                console.log(err);
            });
        },
        async store(data) {
            await api.post('/team',data)
            .then((response) => {
                this.teamAdded = toRaw(response.data.team)
            }).catch((err) => {
                if(err.response.status == 404){
                    router.push('/404');
                  }
                  if(err.response.status == 403){
                    router.push('/403');
                  }
                console.log(err);
            });
        },
    }
})