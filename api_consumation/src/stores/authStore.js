import { defineStore } from 'pinia'
import api from '@/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null
  }),
  actions: {
    async login(data) {
        await api.post('/auth/login',data)
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