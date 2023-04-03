import { defineStore } from 'pinia'
import axios from '@/api'

export const useUserStore = defineStore('user', {
  state: () => ({
    users: [],
    currentUser: null
  }),
  actions: {
    async fetchUsers() {
      const response = await axios.get('/users')
      this.users = response.data
    },
    async createUser(user) {
      const response = await axios.post('/users', user)
      this.users.push(response.data)
    },
    async updateUser(user) {
      const response = await axios.put(`/users/${user.id}`, user)
      const index = this.users.findIndex(u => u.id === user.id)
      this.users.splice(index, 1, response.data)
    },
    async deleteUser(user) {
      await axios.delete(`/users/${user.id}`)
      const index = this.users.findIndex(u => u.id === user.id)
      this.users.splice(index, 1)
    },
    setCurrentUser(user) {
      this.currentUser = user
    }
  }
})