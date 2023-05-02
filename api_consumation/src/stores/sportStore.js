import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useSportStore = defineStore('sport', {
    state: () => ({
        sports: [],
    }),
    actions: {
        fetchSports() {
            api.get('/sport')
            .then((response) => {
                console.log(response.data)
                this.sports = response.data
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