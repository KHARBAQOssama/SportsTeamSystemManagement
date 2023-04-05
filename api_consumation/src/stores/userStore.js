import { defineStore } from 'pinia'
import api from '@/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    currentUser: null
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

    async createUser(user) {
      const response = await api.post('/users', user)
      this.users.push(response.data)
    },

    async updateUser(user) {
      const response = await api.put(`/users/${user.id}`, user)
      const index = this.users.findIndex(u => u.id === user.id)
      this.users.splice(index, 1, response.data)
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