import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useGameStore = defineStore('game', {
    state: () => ({
        games: {
            played : [],
            notPlayed : [],
        },
        gameAdded: {},
        nextGame:{},
        message:''
    }),
    actions: {
        async fetchGames() {
            await api.get('/game')
            .then((response) => {
                this.games = toRaw(response.data);
                console.log(this.games)
            }).catch((err) => {
                console.log(err);
            });
        },
        async reservation(data) {
            await api.post('/reservation',data)
            .then((response) => {
                console.log(response.data);
                this.message = response.data.message
            }).catch((err) => {
                console.log(err);
            });
        },
        async theNextGame() {
            await api.get('/game/next')
            .then((response) => {
                this.nextGame = toRaw(response.data);
                console.log(this.nextGame);
            }).catch((err) => {
                console.log(err);
            });
        },
        async deleteGame(game) {
            await api.delete(`/game/${game}`)
            .then((response) => {
                this.gameAdded = toRaw(response.data.team)
                console.log(response)
                this.message = response.data.message
            }).catch((err) => {
                console.log(err);
            });
        },
    }
})