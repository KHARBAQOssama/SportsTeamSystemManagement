<template>
  <div class="w-100">
    <div v-if="blog && blog != 'not-found'" class="w-100 row gap-3 justify-content-between">
        <div v-if="blog" class="col-md-8 col-lg-8 col-12 d-flex flex-column">
            <h2 class="text-gold fw-semibold">{{ blog.title }}</h2>
            <p class="text-secondary fw-light fs-small">Published by <span class="fw-semibold">{{ blog.publisher.first_name }} {{ blog.publisher.last_name }}</span> at {{ blog.created_at.substring(0,16) }}</p>
            <div class="w-100 overflow-hidden d-flex justify-content-center my-2" style="height:30vh;">
                <img v-if="blog.image_url" :src="blog.image_url" class="h-100" alt="">
            </div>
            <p class="text-justify">
                {{ blog.content }}
            </p>
        </div>
        <div class="col-md-3 col-lg-3 col-12 d-flex flex-column h-md-90">
            <h4>Comments</h4>
            <div class="comments overflow-">
                <div v-for="comment in comments" :key="comment.id" class="comment mb-2 bg-cold p-2 d-flex flex-column">
                    <div class="w-100 d-flex align-items-center">
                        <div class="overflow-hidden rounded-circle me-2 d-flex justify-content-center" style="width:25px;height:25px;"><img v-if="comment.publisher.image_url" :src="comment.publisher.image_url" class="h-100" alt=""></div>
                        <div class="mt-2"> 
                            <p class="fs-small fw-semibold">{{comment.publisher.first_name}} {{comment.publisher.last_name}}<br>
                            <span class="fs-smaller fw-light">{{comment.created_at.substring(0,16)}}</span></p>
                        </div>
                        <div class="d-flex justify-content-end ms-auto pe-1" v-if="user.id == comment.publisher.id">
                            <button v-if="true" class="bg-transparent border-0" @click="deleteComment(comment.id)"><i class="uil uil-trash"></i></button>
                        </div>
                    </div>
                    <p class="w-100 ps-4 pe-1 text-justify fs-small">
                        {{comment.content}} 
                    </p>
                </div>
            </div>
            <div class="mt-auto w-100 d-flex flex-column">
                <textarea class="w-100 border" name="" id="" rows="3" v-model="comment.content" placeholder="what do you think??"></textarea>
                <button class="bg-gold w-25 ms-auto px-2 fs-small p-1 border-0 rounded text-white" @click="addComment">Done</button>
            </div>
            
        </div>
    </div>
    <div class="m-auto" v-else-if="blog == 'not-found'">
        Not Found
    </div>
    <div class="m-auto" v-else>
        <Loading></Loading>
    </div>
  </div>
</template>

<script>
import { useBlogStore } from '../stores/blogStore';

import { useAuthStore } from '../stores/authStore';
import Loading from './Loading.vue';

export default {
    components:{
        Loading,
    },
    data() {
        return {
            blog: null,
            comment:{
                content:'',
                blog_id: '',
            }
        };
    },
    computed:{
        comments(){
            return this.blog.comments.reverse()        
        },
        user(){
            return useAuthStore().user
        }
    },
    created() {
        console.log('welcome')
        useBlogStore().getBlog(this.$route.params.id).then((blog) => {
            this.blog = blog;
        });
    },
    methods:{
        async addComment(){
            this.comment.blog_id = this.blog.id;
            await useBlogStore().storeComment(this.comment);
            useBlogStore().getBlog(this.$route.params.id).then((blog) => {
                this.blog = blog;
            });
            this.comment.content=''
        },
        async deleteComment(id){
             await useBlogStore().deleteComment(id);
             useBlogStore().getBlog(this.$route.params.id).then((blog) => {
                this.blog = blog;
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.comments{
    max-height: 60vh;
    overflow: auto;
}
</style>