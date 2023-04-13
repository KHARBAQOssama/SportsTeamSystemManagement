import { defineStore } from 'pinia'
import api from '@/api'
import { eventBus } from '../eventBus';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    message : null,
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
        await api.post('/password/reset-password',data)
        .then((response) => {
            eventBus.emit('response', { type: 'success', text: response.data.message })
        }).catch((err) => {
            console.log(err);
        });
    },
    async reset(data) {
        return await api.post('/password/reset',data)
        .then((response) => {
            console.log(response);
            return response.status
        }).catch((err) => {
            console.log(err);
        });
    },
  }
})