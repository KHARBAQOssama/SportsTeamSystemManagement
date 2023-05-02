import { defineStore } from 'pinia'
import api from '@/api'

export const useTournamentStore = defineStore('tournament', {
  state: () => ({
    tournaments: [],
    tournament: {
      name:'',
      win_points:null,
      draw_points:null,
      loss_points:null,
      start_date:null,
      teams: [{}],
    },
    standing:'',
    message : ''
  }),
  actions: {
     fetchTournaments(search) {
       api.get('/tournament',search)
            .then((result) => {
              console.log(result.data)
                this.tournaments = result.data
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
     viewStanding(id) {
       api.get('/tournament/'+id+'/standing')
            .then((result) => {
              console.log(result.data)
                this.standing = result.data
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
        await api.post('/tournament',data)
        .then((response) => {
            console.log(response.data)
            this.message = response.data.message;
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
    async deleteTournament(tournament) {
      await api.delete(`/tournament/${tournament}`).then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(error)})
    },
    
    async updateTournament(tournament) {
      console.log(tournament);
      await api.post(`/tournament/${tournament.id}`, tournament)
      .then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(error)})
    },
  }
})