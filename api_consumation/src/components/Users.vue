<template>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="filter mx-auto">
            <div class="w-100 my-2">
                <input class="w-100 mx-auto m-1 px-3 p-1" type="text" v-model="search.params.by_search" placeholder="Search A User" @keyup="filter()">
            </div>
            <div class="w-100 d-flex">
                <select class="col-5 p-1 m-0 me-auto" @change="filter()" name="" v-model="search.params.role">
                    <option value="null">filter by role</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                </select>
                <select class="col-5 p-1 m-0 ms-auto" @change="filter()" name="" v-model="search.params.sport">
                    <option value="null">filter by sport</option>
                    <option v-for="sport in sports" :key="sport.id" :value="sport.id">{{ sport.name }}</option>
                </select>
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
                    
                </div>
                <div class="table-body d-flex flex-column">
                    <div class="text-gold fs-5 justify-content-center h-70 d-flex align-items-center no-data" v-if="!length">
                        No Users Found !!!
                    </div>
                    <div v-for="user  in users"  :class="auth.id == user.id ?  'trow d-flex justify-content-between bg-cold' : 'trow d-flex w-100 justify-content-between'" :key="user.id">
                        <div class="h-100 d-flex justify-content-center align-items-center image">
                            <div class="rounded-circle overflow-hidden">
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
                            <p class="signification bg-cold text-gold" v-if="user.sport">{{ user.sport.name }}</p>
                            <p class="signification bg-cold text-gold" v-else>all</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center role">
                            <p class="signification bg-cold text-gold" v-if="user.role">{{ user.role.name }}</p>
                        </div>
                        <div :class=" auth.id == user.id ? 'h-100 d-flex justify-content-around align-items-center events opacity-0' : 'h-100 d-flex justify-content-around align-items-center events'">
                            <button :disabled=" auth.id == user.id" class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event" @click="to('watch',user.id)"><i class="uil text-success uil-eye"></i></button>
                            <button :disabled=" auth.id == user.id" class="border-0 bg-transparent rounded-1 p-1 px-2 update" data-bs-toggle="modal" data-bs-target="#event" @click="to('edit',user.id)"><i class="uil text-warning uil-pen"></i></button>
                            <button :disabled=" auth.id == user.id" class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',user.id)"><i class="uil text-danger uil-trash"></i></button>
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
                <h4 v-if="to_watch" class="" >User Info</h4>
                <h4 v-if="to_delete" class="" >Delete User</h4>
                <h4 v-if="to_edit" class="" >Edit User</h4>
                <h4 v-if="to_add" class="" >Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel()"></button>
            </div>
            <div v-if="to_delete" class="modal-body text-center">
                <p class="text-danger">Are you sure you want to delete <span class="fs-5 fw-bold">{{ to_delete.first_name +' '+ to_delete.last_name }}</span> Account !!!</p>
            </div>
            <div v-if="to_add" class="modal-body d-flex flex-column px-4">
                <input class="mx-auto" type="text" v-model="to_add.first_name" placeholder="First Name">
                <input class="mx-auto" type="text" v-model="to_add.last_name" placeholder="Last Name">
                <div class="mx-auto d-flex align-items-center'">
                     <input class="w-75" id="userImage" type="file" @change="$event=>imageChanged($event,'add')">
                    <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
                
                <input class="mx-auto" type="date" v-model="to_add.birth_day">
                <select v-model="to_add.role_id">
                    <option value="null">Choose Role</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                </select>
                <select :value="(to_add.role_id != 2 && to_add.role_id != 3) ? '' : to_add.sport_id" v-model="to_add.sport_id" :disabled="(to_add.role_id != 2 && to_add.role_id != 3)">
                    <option value="null">Choose Sport</option>
                    <option v-for="sport in sports" :key="sport.id" :value="sport.id">{{ sport.name }}</option>
                </select>
                <input class="mx-auto" type="email" v-model="to_add.email" placeholder="Email">
                <input class="mx-auto" type="password" v-model="to_add.password" placeholder="Password">
                <input class="mx-auto" type="password" v-model="to_add.password_confirmation" placeholder="Password Confirmation">
            </div>
            <div v-if="to_watch" class="modal-body px-4">
                <div class="w-100 d-flex mb-3 align-items-center">
                    <div class="overflow-hidden rounded-circle me-4" style="width: 100px; height: 100px;">
                        <img :src="to_watch.image_url" class="w-100" alt="">
                    </div>
                    <div>
                        <h6>{{ to_watch.first_name +' '+ to_watch.last_name }}</h6>
                        <p class="text-secondary">@{{ to_watch.email }}</p>
                    </div>
                </div>
                <h6><span v-if="to_watch.sport_id">{{ to_watch.sport.name }} </span> {{ to_watch.role.name}}</h6>
            </div>
            <div v-if="to_edit" class="modal-body d-flex flex-column">
                <div class="overflow-hidden rounded-circle m-auto my-2" style="width: 100px; height: 100px;">
                    <img :src="to_edit.image_url" class="w-100" alt="">
                </div>
                <div class="m-auto d-flex align-items-center'">
                     <input class="w-75" id="teamImage" type="file" @change="$event=>imageChanged($event,'edit')">
                    <label for="teamImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
                <input type="email" v-model="to_edit.email" placeholder="Email">
                <input type="date" v-model="to_edit.birth_day">
                <select v-model="to_edit.role_id">
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                </select>
                <select :value="(to_edit.role_id != 2 && to_edit.role_id != 3) ? '' : to_edit.sport_id" v-model="to_edit.sport_id" :disabled="(to_edit.role_id != 2 && to_edit.role_id != 3)">
                    <option v-for="sport in sports" :key="sport.id" :value="sport.id">{{ sport.name }}</option>
                </select>
                <input type="text" v-model="to_edit.first_name">
                <input type="text" v-model="to_edit.last_name">
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
import { useUserStore } from '../stores/userStore';
import { useRoleStore } from '../stores/roleStore';
import { useSportStore } from '../stores/sportStore';
import { useAuthStore } from '../stores/authStore';
import Loading from '../components/Loading.vue'

export default {
    components:{
        Loading
    },
    data(){
        return {
            usersToDisplay : null,
            search :{
                params:{
                    sport:null,
                    role:null,
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
        useUserStore().fetchUsers(this.search)
    },
    computed:{
        users(){
            return useUserStore().users;
        },
        roles(){
            return useRoleStore().roles;
        },
        sports(){
            return useSportStore().sports;
        },
        length(){
            return useUserStore().users.length
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
                        birth_day:'', 
                        email: '',
                        first_name: '',
                        image: '',
                        last_name: '',
                        role_id: null,
                        sport_id: null,
                        password: '',
                        password_confirmation: '',
                    }
                    break
                case 'edit':
                    this.to_edit = this.users.find(item => item.id === id)
                    break;
                case 'delete':
                    console.log(id)
                    this.to_delete = this.users.find(item => item.id === id)
                    break;
                case 'watch':
                    this.to_watch = this.users.find(item => item.id === id)
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
            this.to_edit._method = 'put'
            this.to_edit.image = this.to_edit.image_url
            await useUserStore().updateUser(this.to_edit);
            useUserStore().fetchUsers(this.search);
            $('#event').modal('hide');
        },
        async add(){
            await useUserStore().createUser(this.to_add);
            useUserStore().fetchUsers(this.search);
            $('#event').modal('hide');
        },
        async destroy(){
            await useUserStore().deleteUser(this.to_delete.id);
            useUserStore().fetchUsers(this.search);
            $('#event').modal('hide');
        },
        filter(){
            console.log(this.search)
            useUserStore().fetchUsers(this.search)
            this.users = useUserStore().users
            this.length = useUserStore().users.length
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
        // @media (max-width: 1100px) {
        //     width: 1000px !important;
        // }
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
        .sport,.role,.image{
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