import { defineStore } from 'pinia'
import api from '@/api'

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
                console.log(err);
            });
    },
    async getBlog(id) {
        return await api.get('/blog/'+id)
            .then((result) => {
                console.log(result.data)
                return result.data
            }).catch((err) => {
                console.log(err);
            });
    },
    async store(data) {
        await api.post('/blog',data)
        .then((response) => {
            console.log(response.data)
            this.message = response.data.message;
        }).catch((err) => {
            console.log(err);
        });
    },
    async storeComment(data) {
        await api.post('/comment',data)
        .then((response) => {
            console.log(response.data)
            this.message = response.data.message;
        }).catch((err) => {
            console.log(err);
        });
    },
    async delete(blog) {
      await api.delete(`/blog/${blog}`).then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{console.log(error)})
    },
    
    async update(blog) {
      console.log(blog);
      await api.post(`/blog/${blog.id}`, blog)
      .then((response)=>{
        this.message = response.data.message
        console.log(response)
      })
      .catch((error)=>{console.log(error)})
    },
  }
})