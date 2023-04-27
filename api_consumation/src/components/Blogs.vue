<template>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="filter mx-auto">
            <div class="w-100 my-2">
                <input class="w-100 mx-auto m-1 px-3 p-1" type="text" v-model="search.params.by_search" placeholder="Search A Blog" @keyup="filter()">
            </div>
        </div>
        <div class="add my-2 d_flex">
            <button class="text-gold bg-black rounded-3 border-0 py-2 d-flex justify-content-center align-items-center ms-auto px-3" data-bs-toggle="modal" data-bs-target="#event" @click="to('add')"><ion-icon name="person-add" class="text-gold me-2"></ion-icon> Add User</button>
        </div>
        <div class="w-100 overflow-x-scroll d-flex flex-column table rounded-3 text-center">
            <div class="h-100 under-table overflow-y-scroll position-relative">
                <div class="d-flex table-head flex-column top-0 position-sticky">
                    <div class="trow bg-black text-white d-flex justify-content-between">
                        <div class="h-100 d-flex justify-content-center align-items-center image">
                        <i class="uil uil-image"></i>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center full-name">
                            title
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center email">
                            Created By
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center branch">
                            branch
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center role">
                            Comments
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center events">Events</div>
                    </div>
                    
                </div>
                <div class="table-body d-flex flex-column">
                    <div class="text-gold fs-5 justify-content-center h-70 d-flex align-items-center no-data" v-if="!length">
                        No Users Found !!!
                    </div>
                    <div v-for="blog  in blogs"  :class="auth.id == blog.id ?  'trow d-flex justify-content-between bg-cold' : 'trow d-flex w-100 justify-content-between'" :key="blog.id">
                        <div class="h-100 d-flex justify-content-center align-items-center image">
                            <div class="rounded-circle overflow-hidden">
                                <img :src="blog.image_url" class="h-100"  alt="">
                            </div>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center full-name">
                            <p>{{ blog.title }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center email">
                            <p>{{ blog.publisher.first_name }} {{ blog.publisher.last_name }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center branch">
                            <p class="signification bg-cold text-gold">{{ blog.title }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center role">
                            <p class="signification bg-cold text-gold">{{ blog.comments.length }} comments</p>
                        </div>
                        <div class="h-100 d-flex justify-content-around align-items-center events">
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event" @click="to('watch',blog.id)"><i class="uil text-success uil-eye"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 update" data-bs-toggle="modal" data-bs-target="#event" @click="to('edit',blog.id)"><i class="uil text-warning uil-pen"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',blog.id)"><i class="uil text-danger uil-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
            <div class="modal-header">
                <h4 v-if="to_watch" class="" >Blog Info</h4>
                <h4 v-if="to_delete" class="" >Delete Blog</h4>
                <h4 v-if="to_edit" class="" >Edit Blog</h4>
                <h4 v-if="to_add" class="" >Add Blog</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel()"></button>
            </div>
            <div v-if="to_delete" class="modal-body text-center">
                <p class="text-danger">Are you sure you want to delete <span class="fs-5 fw-bold">{{ to_delete.first_name +' '+ to_delete.last_name }}</span> Account !!!</p>
            </div>
            <div v-if="to_add" class="modal-body d-flex flex-column px-4">
                <input class="mx-auto" type="text" v-model="to_add.title" placeholder="First Name">
                <textarea class="mx-auto" rows="8" type="text" v-model="to_add.content" placeholder="Last Name"></textarea>
                <div class="w-100 d-flex justify-content-center">
                    <img v-if="to_add.image" :src="to_add.image" class="w-50" alt="">
                </div>
                <div class="mx-auto d-flex align-items-center'">
                     <input class="w-75" id="userImage" type="file" @change="$event=>imageChanged($event,'add')">
                    <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
            </div>
            <div v-if="to_watch" class="modal-body px-4 w-100 flex-column d-flex align-items-center">
                    <h3 class="w-100 text-center my-2">{{ to_watch.title }}</h3>
                    <div class="overflow-hidden me-4 w- d-flex justify-content-center" style="height: 30vh;">
                        <img :src="to_watch.image_url" class="h-100" alt="">
                    </div>
                    <p class="text-justify w-100 my-4">{{ to_watch.content }}</p>
            </div>
            <div v-if="to_edit" class="modal-body d-flex flex-column">
                <input class="mx-auto" type="text" v-model="to_edit.title" placeholder="First Name">
                <textarea class="mx-auto" rows="8" type="text" v-model="to_edit.content" placeholder="Last Name"></textarea>
                <div class="w-100 d-flex justify-content-center">
                    <img v-if="to_edit.image_url" :src="to_edit.image_url" class="w-50" alt="">
                </div>
                <div class="mx-auto d-flex align-items-center'">
                     <input class="w-75" id="userImage" type="file" @change="$event=>imageChanged($event,'edit')">
                    <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
            </div>
            <div v-if="to_watch" class="d-flex justify-content-end my-3 px-3">
                <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <router-link :to="'blogs/' + to_watch.id" class="bg-transparent text-gold border ms-2 py-1 px-2 rounded">More details</router-link>
            </div>
            <div v-if="to_edit || to_delete || to_add" class="d-flex justify-content-end">
                <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <button v-if="to_delete" type="button" class="brand-gold-button mx-3" @click="destroy">Delete</button>
                <button v-if="to_edit" type="button" class="brand-gold-button mx-3" @click="update">Update</button>
                <button v-if="to_add" type="button" class="brand-gold-button mx-3" @click="add">Add</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { useBlogStore } from '../stores/BlogStore';
import { useRoleStore } from '../stores/roleStore';
import { useBranchStore } from '../stores/branchStore';
import { useAuthStore } from '../stores/authStore';
import Loading from '../components/Loading.vue'

export default {
    components:{
        Loading
    },
    data(){
        return {
            search :{
                params:{
                    by_search:''
                }
            },
            to_delete: null,
            to_watch: null,
            to_edit: null,
            to_add: null,
        }
    },
    created(){
        useBlogStore().fetchBlogs(this.search)
    },
    computed:{
        blogs(){
            return useBlogStore().blogs;
        },
        roles(){
            return useRoleStore().roles;
        },
        branches(){
            return useBranchStore().branches;
        },
        length(){
            return useBlogStore().blogs.length
        },
        auth(){
            return useAuthStore().user
        }
    },
    methods:{
        to(option,id = null){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            this.to_add = null
            switch(option){
                case 'add':
                    this.to_add = {
                        title:'',
                        content:'',
                        image:'',
                    }
                    break
                case 'edit':
                    this.to_edit = this.blogs.find(item => item.id === id)
                    break;
                case 'delete':
                    console.log(id)
                    this.to_delete = this.blogs.find(item => item.id === id)
                    break;
                case 'watch':
                    this.to_watch = this.blogs.find(item => item.id === id)
                    break
            }
        },
        cancel(){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        imageChanged(event,option){
            const file = event.target.files[0];
            const reader = new FileReader();
            switch(option){
                case 'edit':
                    reader.onload = () => {
                        this.to_edit.image_url = reader.result;
                    };
                    break;
                case 'add':
                    reader.onload = () => {
                        this.to_add.image = reader.result;
                    };
                    console.log(this.to_add)
                    break;
            }
            reader.readAsDataURL(file);
        },
        async update(){
            this.to_edit._method = 'patch'
            this.to_edit.image = this.to_edit.image_url
            await useBlogStore().update(this.to_edit);
            useBlogStore().fetchBlogs(this.search);
            $('#event').modal('hide');
        },
        async add(){
            await useBlogStore().store(this.to_add);
            useBlogStore().fetchBlogs(this.search);
            $('#event').modal('hide');
        },
        async destroy(){
            await useBlogStore().delete(this.to_delete.id);
            useBlogStore().fetchBlogs(this.search);
            $('#event').modal('hide');
        },
        filter(){
            console.log(this.search)
            useBlogStore().fetchBlogs(this.search)
            this.blogs = useBlogStore().blogs
            this.length = useBlogStore().blogs.length
        }
        
    }
}
</script>

<style lang="scss" scoped>
.no-data{
    width: 70vw;
}
.filter,.add{
    width: 100%;
}
.table{
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.185);
    height: 62vh;
    .trow{
        height: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100% !important;
    }
    .under-table{
        width: 100% !important;
        @media (max-width: 1100px) {
            width: 1000px !important;
        }
    }
    .table-head,.table-body{
        width: 100%;
        font-size: 14px;
        overflow-x: scroll;
        p{
            width: 25ch;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .events{
            width: 140px;
            right: 0;
        }
        .full-name,.email{
            width: 270px;
        }
        .branch,.role,.image{
            width: 65px;
        }
        .image>div{
            width: 30px;
            height: 30px;
        }

    }
    .watch:hover{
        background-color: rgba(22, 165, 22, 0.221) !important;
    }
    .delete:hover{
        background-color: rgba(255, 0, 0, 0.308) !important;
    }
    .update:hover{
        background-color: rgba(255, 243, 6, 0.221) !important;
    }
}
</style>