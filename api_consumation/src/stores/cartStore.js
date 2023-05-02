import { defineStore } from 'pinia'
import api from '@/api'

export const useCartStore = defineStore('cart', {
  state: () => ({
    carts: [],
    message : ''
  }),
  actions: {
     fetchCarts(search = null) {
       api.get('/cart',search)
            .then((result) => {
              console.log(result.data)
                this.carts = result.data
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
    async store(data) {
        await api.post('/cart',data)
        .then((response) => {
            console.log(response.data)
            this.message = response.data.message;
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
    async deleteCart(cart) {
      await api.delete(`/cart/${cart}`).then((response)=>{
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
  }
})