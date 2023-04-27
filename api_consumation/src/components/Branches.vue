<template>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="add my-2 d_flex">
            <button class="text-gold bg-black rounded-3 border-0 py-2 d-flex justify-content-center align-items-center ms-auto px-3" data-bs-toggle="modal" data-bs-target="#event" @click="to('add')"><ion-icon name="football" class="text-gold me-2"></ion-icon>Add New branch</button>
        </div>
        <div class="w-100 overflow-auto mt-3 row gap-3 justify-content-between p-4" style="max-height: 75vh;">
            <div v-for="branch in branches" :key="branch.id" class="col-12 mx-auto bg-white shadow text-gold rounded-3 row align-items-center">
                <div class="col-lg-3 gap-3 col-md-3 col-12 d-flex px-3 py-2 fs-4 align-items-center mb-3 fs-semibold">
                    <ion-icon name="football" class="text-gold me-3 fs-3"></ion-icon> 
                    {{ branch.name }} 
                </div>
                <div class="col-lg-3 gap-3 col-md-3 col-12 d-flex justify-content-between">
                    <p class="signification">Tournaments</p>
                    <div class="d-flex ">
                        <div v-for="tournament in first5T(branch)" class="overflow-hidden rounded-circle bg-white shadow ml-0" style="width:20px; height:20px;" :key="tournament.id">
                            <img :src="tournament.image_url" class="w-100" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 gap-3 col-md-3 col-12 d-flex justify-content-between my-2">
                    <p class="signification">Members</p>
                    <div class="d-flex ">
                        <div v-for="user in first5U(branch)" class="overflow-hidden rounded-circle bg-white shadow ml-0" style="width:20px; height:20px;" :key="user.id">
                            <img :src="user.image_url" class="w-100" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 gap-3 col-md-3 col-12 d-flex justify-content-end my-2">
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event"><i class="uil text-success uil-eye"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 update" data-bs-toggle="modal" data-bs-target="#event"><i class="uil text-warning uil-pen"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event"><i class="uil text-danger uil-trash"></i></button>
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
                <input class="mx-auto" type="text" v-model="to_add.name" placeholder="Name">
                <div class="overflow-hidden rounded-circle justify-content-center align-items-center d-flex mx-auto my-2" style="width:150px; height:150px;">
                    <img v-if="to_add.icon" :src="to_add.icon" class="w-100" alt="">
                </div>
                <div class="mx-auto d-flex align-items-center'">
                     <input class="w-75" id="userImage" type="file" @change="$event=>imageChanged($event,'add')">
                    <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
                <select v-model="to_add.sport_id">
                    <option value="null">Choose sport</option>
                    <option v-for="sport in sports" :key="sport.id" :value="sport.id">{{ sport.symbol }}  {{ sport.name }}</option>
                </select>
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
                <h6><span v-if="to_watch.branch_id">{{ to_watch.branch.name }} </span> {{ to_watch.role.name}}</h6>
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
                <select :value="(to_edit.role_id != 2 && to_edit.role_id != 3) ? '' : to_edit.branch_id" v-model="to_edit.branch_id" :disabled="(to_edit.role_id != 2 && to_edit.role_id != 3)">
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.name }}</option>
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
import { useBranchStore } from '../stores/branchStore';
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
            to_delete: null,
            to_watch: null,
            to_edit: null,
            to_add: null,
        }
    },
    created(){
        useBranchStore().fetchBranches()
        useSportStore().fetchSports()
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
        branches(){
            return useBranchStore().branches;
        },
        length(){
            return useUserStore().users.length
        },
        auth(){
            return useAuthStore().user
        },
    },
    methods:{
        to(option,id = null){
            this.to_delete = null
            this.to_edit = null
            this.to_add = null
            switch(option){
                case 'add':
                    this.to_add = {
                        name:'',
                        sport_id:null,
                        icon:null
                    }
                    break
                case 'edit':
                    this.to_edit = this.branches.find(item => item.id === id)
                    break;
                case 'delete':
                    console.log(id)
                    this.to_delete = this.branches.find(item => item.id === id)
                    break;
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
                        this.to_add.icon = reader.result;
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
            await useBranchStore().createBranch(this.to_add);
            useBranchStore().fetchBranches();
            $('#event').modal('hide');
        },
        async destroy(){
            await useUserStore().deleteUser(this.to_delete.id);
            useUserStore().fetchUsers(this.search);
            $('#event').modal('hide');
        },
        first5T(branch) {
            return branch.tournaments.slice(0, 5);
        },
        first5U(branch) {
            return branch.users.slice(0, 5);
        },
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
    .ml-0{
        margin-left: -3px !important;
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