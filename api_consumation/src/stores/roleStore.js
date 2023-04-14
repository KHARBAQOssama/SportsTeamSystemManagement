import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useTeamStore = defineStore('team', {
    state: () => ({
        roles: [],
    }),
    actions: {
        async fetchRoles() {
            await api.get('/role')
            .then((response) => {
                this.roles = toRaw(response.data) ;
                localStorage.setItem('myTeams',JSON.stringify(this.teams))
            }).catch((err) => {
                console.log(err);
            });
        },
    }
})