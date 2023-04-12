import { defineStore } from 'pinia'
import api from '@/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    currentUser: null,
    user: null,
    message : null
  }),
  actions: {
    fetchUsers() {
      api.get('/user')
            .then((result) => {
              console.log(result.data)
                this.users = result.data
            }).catch((err) => {
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
        console.log(error.data);
      })
      
      
    },

    async createUser(user) {
      const response = await api.post('/users', user)
      this.user.push(response.data.user)
    },

    async updateUser(user) {
      const response = await api.put(`/users/${user.id}`, user)
      const index = this.users.findIndex(u => u.id === user.id)
      this.users.splice(index, 1, response.data)
    },
    async updateSelfImage(image) {
      await api.post(`/user/updateImage`, image)
      .then((response)=>{
        console.log(response)
      })
      .catch((error)=>{
        console.log(error)
      })
    },

    async deleteUser(user) {
      await api.delete(`/users/${user.id}`)
      const index = this.users.findIndex(u => u.id === user.id)
      this.users.splice(index, 1)
    },

    setCurrentUser(user) {
      this.currentUser = user
    }
  }
})