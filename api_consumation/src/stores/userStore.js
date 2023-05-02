import { defineStore } from 'pinia'
import api from '@/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    users : [],
    permissions : [],
    message: 'null',
    user:null,
    currentUser:null
  }),
  getters:{

  },
  actions: {
    fetchUsers(search) {
      api.get('/user',search)
            .then((result) => {
              console.log(result.data)
                this.users = result.data
            }).catch((err) => {
              if(err.response.status == 404){
                router.push('/404');
              }
              if(err.response.status == 403){
                router.push('/403');
              }
                console.log(err.response.status);
            });
    },
    fetchPermissions() {
      api.get('/permission')
            .then((result) => {
              console.log(result.data)
                this.permissions = result.data
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

    async signUp(user) {
      await api.post('/user', user)
      .then((response)=>{
        console.log(response.data.message);
        this.message = response.data.message;
      })
      .catch((error)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(error.data);
      })
    },

    async getUser(user) {
      const response = await api.get('/user/'+user, ).then((response)=>{
        console.log(response.data.message);
        this.message = response.data.message;
      })
      .catch((error)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
      })
      this.user = response.data
      console.log(this.user)
    },

    async createUser(user) {
      const response = await this.handleErrors(api.post('/users/add', user))
    },

    async updateUser(user) {
      await api.post(`/user/${user.id}`, user)
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

    async updateSelfImage(image) {
      await api.post(`/user/updateImage`, image)
      .then((response)=>{
        console.log(response)
      })
      .catch((error)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(error)
      })
    },

    async deleteUser(user) {
      await api.delete(`/user/${user}`).then((response)=>{
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

    async updateSelf(data) {
      await api.post(`/user/update`,data).then((response)=>{
        this.message = response.data.message
        this.user = response.data.user
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

    
    async assignPermissions(id,data){
      await api.post(`assign/permission/${id}`,data).then((response)=>{
        this.message = response.data.message
        this.user = response.data.user
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
          console.log(err);
          this.message = err.response?.data?.message || 'Something went wrong';
        }
    }
  }
})