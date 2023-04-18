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
                console.log(err);
            });
        },
    }
})