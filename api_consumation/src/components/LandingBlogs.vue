<template>
    <div class="w-100 row bg-black">
      <h3 class="text-gold my-3 mb-5 col-12 text-center"><ion-icon name="albums-outline" class="text-gold fs-4 me-2 nav-icon"></ion-icon> Blogs</h3>
      <div class="col-12 row justify-content-around px-3 mx-auto">
            <div v-for="(blog,index) in blogs" :key="blog.id"  :class="index%2 == 0 ?'me-auto col-md-8 col-12 p-2 bg-gold text-whited-flex-flex-column my-2' : 'ms-auto col-md-8 col-12 p-2 bg-gold text-whited-flex-flex-column my-2'">
                <div class="m-auto col-11 overflow-hidden justify-content-center d-flex flex-column align-items-center" style="height:200px;">
                    <img :src="blog.image_url" class="w-100 m-auto" alt="">
                </div>
                <div class="m-auto text-white col-11">
                    <div class="fs-3 fw-bold my-3">{{ blog.title }}</div>
                    <p class="fw-light">{{ blog.content.substring(0,200) }}...</p>
                </div>
                <div class="m-auto text-white col-11 d-flex">
                    <div class="fw-light text-secondary">{{ blog.comments.length }} <i class="uil uil-comment-alt-lines"></i></div>
                    <!-- <p class="">Read More</p> -->
                    <router-link :to="'blogs/' + blog.id" class="fw-light ms-auto">More details</router-link>
                </div>
            </div>
              
      </div>
      <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
                 <div class="modal-content text-light p-3 py-5 text-center text-black">
                  You Are Going To Add This blog To your Cart
                  <button class="w-50 m-auto rounded-2 py-1 mt-4 text-white bg-gold border-0" @click="addToCart">Add To Cart</button>
              </div>
          </div>
      </div> 
      <router-link to="/" class="text-white fs-3 my-3 mt-5 col-12 text-center"><ion-icon name="pricetags-outline" class="text-gold fs-4 me-2 mt-1 text-white nav-icon"></ion-icon> More</router-link>
    </div>
  </template>
  
  <script>
  import { useBlogStore } from '../stores/blogStore';
  import { useCartStore } from '../stores/cartStore';
  
  export default {
      data(){
          return {
              data:{
                  blog_id : null
              }
          }	
      },
      created(){
          useBlogStore().fetchBlogs()
      },
      computed:{
          blogs(){
              return useBlogStore().blogs
          },
      },
      methods:{
          addComment(){
              useCartStore().store(this.data);
              $('#event').modal('hide');
          }
      }
  }
  </script>
  
  <style>
  
  </style>