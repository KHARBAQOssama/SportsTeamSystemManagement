import { defineStore } from 'pinia'
import api from '@/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    message : null,
  }),
  getters:{

  },
  actions: {
    async login(data) {
        const response = await this.handleErrors(api.post('/auth/login', data));
        if (response) {
          console.log(response.data);
          const { access_token } = response.data;
          localStorage.setItem('token', access_token);
          console.log('added');
        }
        await this.me();
    },
    async me() {
        return await api.post('/auth/me')
        .then((response) => {
            this.user = response.data
            localStorage.setItem('currentUser', JSON.stringify(response.data));
            console.log('added Us');
            return response.data
        }).catch((err) => {
          
            this.user = null;
            if(err.response.status == 404){
              router.push('/404');
            }
            if(err.response.status == 403){
              router.push('/403');
            }
            return false
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
    async logOut() {
        const response = await this.handleErrors(api.post('/auth/logout'));
        if (response) {
          console.log(response.data);
          localStorage.removeItem('token');
          localStorage.removeItem('currentUser');
        }
    },
    async resetPassword(data) {
        await api.post('/password/reset-password',data)
        .then((response) => {
            this.message = response.data.message 
            console.log(response)
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
    async reset(data) {
        return await api.post('/password/reset',data)
        .then((response) => {
            console.log(response);
            return response.status
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
    async handleErrors(promise) {
        try {
          const response = await promise;
          return response;
        } catch (err) {
          if(err.response.status == 404){
            router.push('/404');
          }
          if(err.response.status == 403){
            router.push('/403');
          }
          // console.log(err);
          // this.message = err.response?.data?.message || 'Something went wrong';
        }
    }
  }
})