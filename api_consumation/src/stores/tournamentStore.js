import { defineStore } from 'pinia'
import api from '@/api'

export const useTournamentStore = defineStore('tournament', {
  state: () => ({
    tournaments: null,
    tournament: {
      name:'',
      win_points:null,
      draw_points:null,
      loss_points:null,
      start_date:null,
      teams: [{}],
    }
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
    initializeTournament(data){
      this.tournament.name = data.name
      this.tournament.win_points = data.win_points
      this.tournament.loss_points = data.loss_points
      this.tournament.draw_points = data.draw_points
      this.tournament.start_date = data.start_date
      this.tournament.randomMatches = data.randomMatches
    },
  }
})