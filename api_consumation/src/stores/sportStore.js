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
                console.log(err);
            });
        },
    }
})