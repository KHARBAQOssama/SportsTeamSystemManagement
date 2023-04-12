import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useGameStore = defineStore('game', {
    state: () => ({
        games: [],
        gameAdded: {}
    }),
    actions: {
        async fetchTeams() {
            await api.get('/game')
            .then((response) => {
                this.teams = toRaw(response.data) ;
            }).catch((err) => {
                console.log(err);
            });
        },
        async store(data) {
            await api.post('/game',data)
            .then((response) => {
                this.gameAdded = toRaw(response.data.team)
                console.log(response)
            }).catch((err) => {
                console.log(err);
            });
        },
    }
})