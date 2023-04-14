<template>
    <div class="w-75 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="m-auto overflow-scroll h-70 d-flex flex-column table text-center position-relative">
            <div class="d-flex table-head trow bg-gold text-white top-0 position-sticky">
                <div class="h-100 d-flex justify-content-center align-items-center image">
                    <i class="uil uil-image"></i>
                </div>
                <div class="h-100 d-flex justify-content-center align-items-center full-name">
                    Full Name
                </div>
                <div class="h-100 d-flex justify-content-center align-items-center email">
                    Email
                </div>
                <div class="h-100 d-flex justify-content-center align-items-center sport">
                    Sport
                </div>
                <div class="h-100 d-flex justify-content-center align-items-center role">
                    Role
                </div>
                <div class="h-100 d-flex justify-content-center align-items-center events">Events</div>
            </div>
            <div class="table-body d-flex flex-column">
                <div v-for="user in users" class="trow d-flex w-100" :key="user.id">
                    <div class="h-100 d-flex justify-content-center align-items-center image">
                        <div class="h-75 rounded-circle overflow-hidden">
                            <img :src="user.image_url" class="h-100"  alt="">
                        </div>
                    </div>
                    <div class="h-100 d-flex justify-content-center align-items-center full-name">
                        <p>{{ user.first_name }} {{ user.last_name }}</p>
                    </div>
                    <div class="h-100 d-flex justify-content-center align-items-center email">
                        <p>{{ user.email }}</p>
                    </div>
                    <div class="h-100 d-flex justify-content-center align-items-center sport">
                        <div class="h-75">
                            <img v-if="user.sport" :src="user.sport.icon" class="h-100"  alt="">
                        </div>
                    </div>
                    <div class="h-100 d-flex justify-content-center align-items-center role">
                        <div class="h-75">
                            <img :src="user.role.icon" :alt="user.role.name" class="h-100">
                        </div>
                    </div>
                    <div class="h-100 d-flex justify-content-around align-items-center events">
                        <button class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#event" @click="toWatch(user.id)"><i class="uil uil-eye"></i></button>
                        <button class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#event" @click="toEdit(user.id)"><i class="uil uil-pen"></i></button>
                        <button class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#event" @click="toDelete(user.id)"><i class="uil uil-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
            <div class="modal-header">
                <h4 v-if="to_watch" class="" >User Info</h4>
                <h4 v-if="to_delete" class="" >Delete User</h4>
                <h4 v-if="to_edit" class="" >Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div v-if="to_delete" class="modal-body text-center">
                <p class="text-danger">Are you sure you want to delete <span class="fs-5 fw-bold">{{ users[to_delete].first_name +' '+ users[to_delete].last_name }}</span> Account !!!</p>
            </div>
            <div v-if="to_watch" class="modal-body px-4">
                <div class="w-100 d-flex mb-3 align-items-center">
                    <div class="overflow-hidden rounded-circle me-4" style="width: 100px; height: 100px;">
                        <img :src="users[to_watch].image_url" class="w-100" alt="">
                    </div>
                    <div>
                        <h6>{{ users[to_watch].first_name +' '+ users[to_watch].last_name }}</h6>
                        <p class="text-secondary">@{{ users[to_watch].email }}</p>
                    </div>
                </div>
                <h6><span v-if="users[to_watch].sport_id">{{ users[to_watch].sport.name }} </span> {{ users[to_watch].role.name}}</h6>
            </div>
            <div class="d-flex justify-content-end">
                <button v-if="to_edit || to_delete" type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <button v-if="to_delete" type="button" class="brand-gold-button mx-3">Delete</button>
                <button v-if="to_edit" type="button" class="brand-gold-button mx-3">Update</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { useUserStore } from '../stores/userStore';

export default {
    data(){
        return {
            usersToDisplay : null,
            search :{
                params:{
                }
            },
            to_delete: null,
            to_watch: null,
            to_edit: null,
        }
    },
    created(){
        useUserStore().fetchUsers(this.search)
    },
    computed:{
        users(){
            return useUserStore().users;
        }
    },
    methods:{
        toDelete(id){
            this.to_delete = id
            this.to_edit = null
            this.to_watch = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        toWatch(id){
            this.to_watch = id
            this.to_delete = null
            this.to_edit = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        toEdit(id){
            this.to_edit = this.users.find(item => item.id === id)
            this.to_delete = null
            this.to_watch = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        cancel(){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
    }
}
</script>

<style lang="scss" scoped>
.h-70{
    height: 70vh;
}
.table{
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.185);
    width: 90%;
    .trow{
        height: 50px;
    }
    .table-head,.table-body{
        width: 863px;
        font-size: 14px;
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
        .sport,.role,.image{
            width: 65px;
        }

    }
}
</style>