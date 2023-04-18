import { defineStore } from 'pinia'
import api from '@/api'
import { eventBus } from '../eventBus';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    message : null,
  }),
  getters:{

  },
  actions: {
    // async login(data) {
    //     await api.post('/auth/login',data)
    //     .then((response) => {
    //         console.log(response.data)
    //         const { access_token } = response.data
    //         localStorage.setItem('token', access_token)
    //     }).catch((err) => {
    //         console.log(err);
    //     });
    //     this.me()
    // },
    async login(data) {
        const response = await this.handleErrors(api.post('/auth/login', data));
        if (response) {
          console.log(response.data);
          const { access_token } = response.data;
          localStorage.setItem('token', access_token);
          await this.me();
        }
    },
    async me() {
        await api.post('/auth/me')
        .then((response) => {
            this.user = response.data
            console.log(response);
        }).catch((err) => {
            console.log('from me');
            console.log(err);
            this.user = null;
        });
    },
    async refresh() {
        const response = await this.handleErrors(api.post('/auth/refresh'));
        if (response) {
          console.log(response.data);
          const { access_token } = response.data;
          localStorage.setItem('token', access_token);
          await this.me();
        }
    },
    async resetPassword(data) {
        await api.post('/password/reset-password',data)
        .then((response) => {
            this.message = response.data.message 
            console.log(response)
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
    async handleErrors(promise) {
        try {
          const response = await promise;
          return response;
        } catch (err) {
          console.log(err);
          this.message = err.response?.data?.message || 'Something went wrong';
        }
    }
  }
})