<template>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <div class="row w-100 g-4 mt-1  mx-auto">
                <input class="col-md-5 col-12 mx-auto" type="text" v-model="search.params.by_search" placeholder="Search A User" @keyup="filter()">
                <select class="col-12 col-md-5" @change="filter()" name="" v-model="search.params.sport">
                    <option value="null">filter by sport</option>
                    <option v-for="sport in sports" :key="sport.id" :value="sport.id">{{ sport.name }}</option>
                </select>
        </div>
        <div class="add my-2 d_flex">
            <button class="text-gold bg-black rounded-3 border-0 py-2 d-flex justify-content-center align-items-center ms-auto px-3"><ion-icon name="trophy" class="text-gold me-2"></ion-icon><router-link to="/dashboard/tournaments/add">Add Tournament</router-link></button>
        </div>
         <div class="w-100 overflow-x-scroll d-flex flex-column table rounded-3 text-center">
            <div class="h-100 under-table overflow-y-scroll position-relative">
                <div class="d-flex table-head flex-column top-0 position-sticky">
                    <div class="trow bg-black text-white d-flex justify-content-between">
                        <div class="h-100 d-flex justify-content-center align-items-center image">
                        <i class="uil uil-image"></i>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center full-name">
                            Name
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center sport">
                            Sport
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center start-date">
                            Start date
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center events">Events</div>
                    </div>
                    
                </div>
                <div class="table-body d-flex flex-column">
                    <div class="text-gold fs-5 justify-content-center h-70 d-flex align-items-center no-data" v-if="!length">
                        No Tournaments Found !!!
                    </div>
                     <div v-for="tournament  in tournaments"  class="trow d-flex w-100 justify-content-between" :key="tournament.id">
                       <div class="h-100 d-flex justify-content-center align-items-center image">
                            <div class="rounded-circle overflow-hidden">
                                <img :src="tournament.image_url" class="h-100"  alt="">
                            </div>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center full-name">
                            <p>{{ tournament.name }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center sport">
                            <p class="signification bg-cold text-gold">{{ tournament.sport.name }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center start-date">
                            <p class="signification bg-cold text-gold">{{ tournament.start_date }}</p>
                        </div>
                        <div class="h-100 d-flex justify-content-around align-items-center events">
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event" @click="to('watch',tournament.id)"><i class="uil text-success uil-eye"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 update" data-bs-toggle="modal" data-bs-target="#event" @click="to('edit',tournament.id)"><i class="uil text-warning uil-pen"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',tournament.id)"><i class="uil text-danger uil-trash"></i></button>
                        </div>
                    </div> 
                </div>
            </div>
            
        </div>
        
        
        <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
           <!-- Modal  -->
           <div :class="!to_add ? 'modal-content' : 'modal-content w-100'">
            <div class="modal-header">
                <h4 v-if="to_watch" class="" >Tournament Info</h4>
                <h4 v-if="to_delete" class="" >Delete Tournament</h4>
                <h4 v-if="to_edit" class="" >Edit Tournament</h4>
                <h4 v-if="to_add" class="" >Add Tournament</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel()"></button>
            </div>
           <!-- <div v-if="to_delete" class="modal-body text-center">
                <p class="text-danger">Are you sure you want to delete <span class="fs-5 fw-bold">{{ to_delete.first_name +' '+ to_delete.last_name }}</span> Account !!!</p>
            </div> -->
            <div v-if="to_add" class="modal-body d-flex flex-column px-4">
                <AddTournament></AddTournament>
            </div>
            <div v-if="to_watch" class="modal-body px-4">
                <div class="w-100 d-flex flex-column mb-3 align-items-center">
                    <div class="overflow-hidden rounded-circle me-4" style="width: 100px; height: 100px;">
                        <img :src="to_watch.image_url" class="w-100" alt="">
                    </div>
                    <h3>{{ to_watch.name}}</h3> 
                    <h3>{{ to_watch.sport.name }}</h3>
                    <h3>{{ to_watch.start_date }}</h3>
                </div>
            </div>
            
            <div v-if="to_edit" class="modal-body d-flex flex-column">
                <div class="overflow-hidden rounded-circle m-auto my-2" style="width: 100px; height: 100px;">
                    <img :src="to_edit.image_url" class="w-100" alt="">
                </div>
                <div class="m-auto d-flex align-items-center'">
                     <input class="w-75" id="teamImage" type="file" @change="$event=>imageChanged($event)">
                    <label for="teamImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
                <input type="text" v-model="to_edit.name" placeholder="Name">
                <input type="date" v-model="to_edit.start_date">
            </div>
            <div v-if="to_edit || to_delete || to_add" class="d-flex justify-content-end">
                <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <button v-if="to_delete" type="button" class="brand-gold-button mx-3" @click="destroy">Delete</button>
                <button v-if="to_edit" type="button" class="brand-gold-button mx-3" @click="update">Update</button>
            </div>
            </div>
        </div>
        </div> 
    </div>
</template>

<script>
import { useSportStore } from '../stores/sportStore';
import { useAuthStore } from '../stores/authStore';
import { useTournamentStore } from '../stores/tournamentStore';
import AddTournament from '../components/tournament/AddTournamentForm.vue';

export default {
    components:{
        // Loading
        AddTournament
    },
    data(){
        return {
            search :{
                params:{
                    sport:null,
                    by_search:''
                }
            },
            to_delete: null,
            to_watch: null,
            to_edit: null,
            to_add: false,
        }
    },
    created(){
        useTournamentStore().fetchTournaments(this.search)
    },
    computed:{
        tournaments(){
            return useTournamentStore().tournaments
        },
        sports(){
            return useSportStore().sports;
        },
        auth(){
            return useAuthStore().user
        },
        length(){
            return useTournamentStore().tournaments.length
        },
    },
    methods:{
        to(option,id = null){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            this.to_add = null
            switch(option){
                case 'add':
                    this.to_add = true
                    break
                case 'edit':
                    this.to_edit = this.tournaments.find(item => item.id === id)
                    break;
                case 'delete':
                    console.log(id)
                    this.to_delete = this.tournaments.find(item => item.id === id)
                    break;
                case 'watch':
                    this.to_watch = this.tournaments.find(item => item.id === id)
                    break
            }
        },
        cancel(){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        imageChanged(event){
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                this.to_edit.image_url = reader.result;
            };
            reader.readAsDataURL(file);
        },
        async update(){
            this.to_edit._method = 'put'
            this.to_edit.image = this.to_edit.image_url
            await useTournamentStore().updateTournament(this.to_edit);
            useTournamentStore().fetchTournaments(this.search);
            $('#event').modal('hide');
        },
        async destroy(){
            await useTournamentStore().deleteTournament(this.to_delete.id);
            useTournamentStore().fetchTournaments(this.search);
            $('#event').modal('hide');
        },
        filter(){
            console.log(this.search)
            useTournamentStore().fetchTournaments(this.search)
            this.tournaments = useTournamentStore().tournaments
            this.length = useTournamentStore().tournaments.length
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
        .full-name,start-date{
            width: 270px;
        }
        .sport,.image{
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