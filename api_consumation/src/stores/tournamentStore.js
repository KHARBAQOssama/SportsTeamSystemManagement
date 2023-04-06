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
            this.user = response.data
            const { access_token } = response.data
            localStorage.setItem('token', access_token)
        }).catch((err) => {
            console.log(err);
        });
    },
  }
})