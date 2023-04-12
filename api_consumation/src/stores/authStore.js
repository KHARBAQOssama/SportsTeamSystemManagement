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
            const { access_token } = response.data
            localStorage.setItem('token', access_token)
        }).catch((err) => {
            console.log(err);
        });
    },
    async me(data) {
        await api.post('/auth/me',data)
        .then((response) => {
            this.user = response.data
        }).catch((err) => {
            console.log(err);
        });
    },
    async resetPassword(data) {
        return await api.post('/password/reset-password',data)
        .then((response) => {
            this.user = response.data
            console.log(response.status);
            return response.status
        }).catch((err) => {
            console.log(err);
        });
    },
    async reset(data) {
        return await api.post('/password/reset',data)
        .then((response) => {
            this.user = response.data
            console.log(response);
            return response.status
        }).catch((err) => {
            console.log(err);
        });
    },
  }
})