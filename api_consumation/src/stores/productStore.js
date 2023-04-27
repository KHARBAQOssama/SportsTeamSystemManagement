import { defineStore } from 'pinia'
import api from '@/api'

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
    message : ''
  }),
  actions: {
     async fetchProducts(search = null) {
       await api.get('/product',search)
            .then((result) => {
              console.log(result.data)
                this.products = result.data
            }).catch((err) => {
                console.log(err);
            });
    },
    async store(data) {
        await api.post('/product',data)
        .then((response) => {
            console.log(response.data)
            this.message = response.data.message;
        }).catch((err) => {
            console.log(err);
        });
    },
    async deleteProduct(product) {
      await api.delete(`/product/${product}`).then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{console.log(error)})
    },
    
    async updateProduct(product) {
      await api.put(`/product/${product.id}/`, product)
      .then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{console.log(error)})
    },
  }
})