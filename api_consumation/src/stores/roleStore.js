import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useRoleStore = defineStore('role', {
    state: () => ({
        roles: [],
    }),
    actions: {
        async fetchRoles() {
            await api.get('/role')
            .then((response) => {
                this.roles = response.data
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