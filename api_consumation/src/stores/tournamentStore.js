import { defineStore } from 'pinia'
import api from '@/api'

export const useTournamentStore = defineStore('tournament', {
  state: () => ({
    tournaments: null
  }),
  actions: {
    async store(data) {
        await api.post('/tournament',data)
        .then((response) => {
            console.log(response.data)
        }).catch((err) => {
            console.log(err);
        });
    },
  }
})