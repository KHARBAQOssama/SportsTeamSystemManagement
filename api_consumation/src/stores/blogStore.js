import { defineStore } from 'pinia'
import api from '@/api'

import router from '../routes';

export const useBlogStore = defineStore('blog', {
  state: () => ({
    blogs: [],
    message : '',
    blog:null,
  }),
  actions: {
     fetchBlogs(search) {
       api.get('/blog',search)
            .then((result) => {
              console.log(result.data)
                this.blogs = result.data
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
    async getBlog(id) {
        return await api.get('/blog/'+id)
            .then((result) => {
                console.log(result.data)
                if(!result.data.title){
                  router.push('/404');
                }
                return result.data
            }).catch((err) => {
                if(err.response.status == 404){
                  router.push('/404');
                }
                if(err.response.status == 403){
                  router.push('/403');
                }
            });
    },
    async store(data) {
        await api.post('/blog',data)
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
        });
    },
    async storeComment(data) {
        await api.post('/comment',data)
        .then((response) => {
            console.log(response.data)
        }).catch((err) => {
          if(err.response.status == 404){
            router.push('/404');
          }
          if(err.response.status == 403){
            router.push('/403');
          }
        });
    },
    async deleteComment(id) {
        await api.delete('/comment/'+id)
        .then((response) => {
            console.log(response.data)
        }).catch((err) => {
          if(err.response.status == 404){
            router.push('/404');
          }
          if(err.response.status == 403){
            router.push('/403');
          }
        });
    },
    async delete(blog) {
      await api.delete(`/blog/${blog}`).then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((err)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(err)})
    },
    
    async update(blog) {
      console.log(blog);
      await api.post(`/blog/${blog.id}`, blog)
      .then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((err)=>{
        if(err.response.status == 404){
          router.push('/404');
        }
        if(err.response.status == 403){
          router.push('/403');
        }
        console.log(err)
      })
    },
  }
})