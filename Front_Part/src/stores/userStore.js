import { defineStore } from "pinia";
import { toRaw } from "vue";
import axios from "axios";

export const useUserStore = defineStore('user',{
    state: () => ({ 
        user: null, 
        message: null,
        response: null,
        error:null,
        token:null,
    }),
    getters: {
        
    },
    actions: {
        async signUp(data) {
            try {
              const response = await axios.post('http://127.0.0.1:8000/api/user', data)
              this.response = toRaw(response);
              this.user = toRaw(this.response.data.user);
              console.log(this.user);
            } catch (error) {
              console.error(error.response.data.message.split(".")[0])
            }
          },
        async signIn(data) {
            try {
              const response = await axios.post('http://127.0.0.1:8000/api/auth/login', data)
              this.response = toRaw(response);
              this.token = toRaw(this.response.data.access_token);
              console.log(this.token);
            } catch (error) {
              console.error(error.response.data)
            }
          }
    },

})