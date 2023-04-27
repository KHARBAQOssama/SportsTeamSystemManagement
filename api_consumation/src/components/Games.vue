<template>
     <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <h2 class="text-gold fw-bold my-2">GAMES</h2>
        <!-- <div class="row w-100 g-4 mt-1  mx-auto">
                <select class="col-12 col-md-5" @change="filter()" name="" v-model="search.params.branch">
                    <option value="">filter by branch</option>
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.name }}</option>
                </select>
        </div> -->
        

        <!-- <div v-for="game  in games.notPlayed" :key="game.id" class="d-flex align-items-center w-75 justify-content-between my-2">
            <div class="d-flex justify-content-start bg-gold text-white px-2 p-1 rounded-pill" style="text-overflow:ellipsis; white-space:nowrap;width:30%;">
                {{ game.home_team.slag }}
            </div>
            <div class="d-flex align-items-center justify-content-between p-1 bg-black rounded-pill text-gold" style="width:40%;">
                <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:45px; height:45px;">
                    <img :src="game.home_team.image_url" class="w-100" alt="">
                </div>
                <div class="w-auto">
                    <span class="fw-light px-1"></span>
                    <span class="fw-bold mx-2">-</span>
                    <span class="fw-light px-1"></span>
                </div>
                <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:45px; height:45px;">
                    <img :src="game.away_team.image_url" class="w-100" alt="">
                </div>
            </div>
            <div class="d-flex justify-content-end bg-gold text-white px-2 p-1 rounded-pill" style="text-overflow:ellipsis; white-space:nowrap;width:30%;">
                {{ game.away_team.slag }}
            </div>
        </div> -->
        <div v-for="game  in games.played" :key="game.id" class="d-flex align-items-center w-75 justify-content-between my-2">
            <div class="h-100 d-flex flex-column align-items-center fs-smaller py-2 px-1 w-25" style="white-space:nowrap; text-overflow:ellipsis;">
                <div class="overflow-hidden rounded-circle d-flex justify-content-center align-items-center mb-2" style="width:45px; height:45px;">
                    <img :src="game.tournament.image_url" class="w-100" alt="">
                </div>
                {{ game.tournament.name }}
            </div>
            <div class="d-flex flex-column bg-gold h-100" style="width:65%;">
                <div class="d-flex align-items-center h-50 border-bottom border-white ps-2 py-1">
                    <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:35px; height:35px;">
                        <img :src="game.home_team.image_url" class="w-100" alt="">
                    </div>
                    {{ game.home_team.slag }}
                </div>
                <div class="d-flex align-items-center h-50 border-top border-white ps-2 py-1">
                    <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:35px; height:35px;">
                        <img :src="game.away_team.image_url" class="w-100" alt="">
                    </div>
                    {{ game.away_team.slag }}
                </div>
            </div>
            <div class="d-flex flex-column bg-black text-gold h-100" style="width:10%;">
                <div class="d-flex align-items-center h-50 border-bottom border-white px-2 w-100 text-center py-2">
                    {{ game.home_score }}
                </div>
                <div class="d-flex align-items-center h-50 border-top border-white px-2 w-100 text-center py-2">
                    {{ game.away_score }}
                </div>
            </div>
            <!-- <div class="d-flex justify-content-start bg-gold text-white px-2 p-1 rounded-pill" style="text-overflow:ellipsis; white-space:nowrap;width:30%;">
                {{ game.home_team.slag }}
            </div>
            <div class="d-flex align-items-center justify-content-between p-1 bg-black rounded-pill text-gold" style="width:40%;">
                <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:45px; height:45px;">
                    <img :src="game.home_team.image_url" class="w-100" alt="">
                </div>
                <div class="w-auto">
                    <span class="fw-light px-1">{{ game.home_score }} </span>
                    <span class="fw-bold mx-2">-</span>
                    <span class="fw-light px-1">{{ game.away_score }} </span>
                </div>
                <div class="overflow-hidden rounded-circle border d-flex justify-content-center align-items-center bg-white" style="width:45px; height:45px;">
                    <img :src="game.away_team.image_url" class="w-100" alt="">
                </div>
            </div>
            <div class="d-flex justify-content-end bg-gold text-white px-2 p-1 rounded-pill" style="text-overflow:ellipsis; white-space:nowrap;width:30%;">
                {{ game.away_team.slag }}
            </div> -->
        </div>

        <!-- <div class="w-100 overflow-x-scroll mt-4 d-flex flex-column table rounded-3 text-center">
            <div class="h-100 under-table overflow-y-scroll position-relative">
                <div class="d-flex table-head flex-column top-0 position-sticky">
                    <div class="trow bg-black text-white d-flex justify-content-between">
                        <div class="h-100 d-flex justify-content-center align-items-center team">
                            Home
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center score">
                            Score
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center team">
                            Away
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center date">
                            Date-Time
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center played">
                            played
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center branch">
                            branch  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center tournament">
                            Tournament  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center events">Events</div>
                    </div>
                    
                </div>
                <div class="table-body d-flex flex-column">
                    <div class="text-gold fs-5 justify-content-center h-70 d-flex align-items-center no-data" v-if="!length">
                        No Games Found !!!
                    </div>
                     <div v-for="game  in games.notPlayed"  class="trow d-flex w-100 justify-content-between" :key="game.id">
                        <div class="h-100 d-flex justify-content-center align-items-center team" :title="game.home_team.name">
                            <div class="overflow-hidden me-2" style="height:20px; width:20px;">
                                <img :src="game.home_team.image_url" class="h-100" alt="">
                            </div> 
                            {{ game.home_team.slag }}
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center score">
                            <p class="text-gold mt-1 fs-6"> - </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center team" :title="game.away_team.name">
                            <div class="overflow-hidden me-2" style="height:20px; width:20px;">
                                <img :src="game.away_team.image_url" class="h-100" alt="">
                            </div> 
                            {{  game.away_team.slag }}
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center date">
                            <p class="signification bg-cold text-gold mt-1">{{ game.date }} || {{ game.start_time.slice(0,5) }} </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center played">
                            <p class="signification bg-cold text-gold mt-1"> False </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center branch">
                            <p class="signification bg-cold text-gold mt-1">{{  game.branch.name }}</p>  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center tournament">
                            <p class="signification bg-cold text-gold mt-1">{{  game.tournament.name }}</p>  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center events">
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event" @click="to('watch',game.id)"><i class="uil text-success uil-eye"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',game.id)"><i class="uil text-danger uil-trash"></i></button>
                        </div>
                    </div> 
                     <div v-for="game  in games.played"  class="trow d-flex w-100 justify-content-between" :key="game.id">
                        <div class="h-100 d-flex justify-content-center align-items-center team" :title="game.home_team.name">
                            <div class="overflow-hidden me-2" style="height:20px; width:20px;">
                                <img :src="game.home_team.image_url" class="h-100" alt="">
                            </div> 
                            {{ game.home_team.slag }}
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center score">
                            <p class="text-gold mt-1 fs-6"> {{ game.home_score }} - {{ game.away_score }} </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center team" :title="game.away_team.name">
                            <div class="overflow-hidden me-2" style="height:20px; width:20px;">
                                <img :src="game.away_team.image_url" class="h-100" alt="">
                            </div> 
                            {{  game.away_team.slag }}
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center date">
                            <p class="signification bg-cold text-gold mt-1">{{ game.date }} || {{ game.start_time.slice(0,5) }} </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center played">
                            <p class="signification bg-cold text-gold mt-1"> True </p>
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center branch">
                            <p class="signification bg-cold text-gold mt-1">{{  game.branch.name }}</p>  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center tournament">
                            <p class="signification bg-cold text-gold mt-1">{{  game.tournament.name }}</p>  
                        </div>
                        <div class="h-100 d-flex justify-content-center align-items-center events">
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 watch" data-bs-toggle="modal" data-bs-target="#event" @click="to('watch',game.id)"><i class="uil text-success uil-eye"></i></button>
                            <button class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',game.id)"><i class="uil text-danger uil-trash"></i></button>
                        </div>
                    </div> 
                </div>
            </div>  
        </div> -->
        <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-if="to_watch" class="" >Game Info</h4>
                        <h4 v-if="to_delete" class="" >Delete Game</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel()"></button>
                    </div>
                    <div v-if="to_delete" class="modal-body text-center">
                        <p class="text-danger">Are you sure you want to delete <span class="fs-5 fw-bold">{{ to_delete.first_name +' '+ to_delete.last_name }}</span> Account !!!</p>
                    </div> 
                    <div v-if="to_watch" class="modal-body px-4">
                        <div class="w-100 d-flex flex-column mb-3 align-items-center">
                            <div class="overflow-hidden rounded-circle me-4" style="width: 100px; height: 100px;">
                                <img :src="to_watch.image_url" class="w-100" alt="">
                            </div>
                            <h3>{{ to_watch.branch.name }}</h3>
                            <h3>{{ to_watch.start_date }}</h3>
                        </div>
                    </div>
                    <div v-if="to_delete" class="d-flex justify-content-end">
                        <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                        <button v-if="to_delete" type="button" class="brand-gold-button mx-3" @click="destroy">Delete</button>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</template>

<script>
import { useBranchStore } from '../stores/branchStore';
import { useAuthStore } from '../stores/authStore';
import { useGameStore } from '../stores/gameStore';

export default {
    components:{
    },
    data(){
        return {
            search :{
                params:{
                    branch:'',
                }
            },
            to_delete: null,
            to_watch: null,
        }
    },
    created(){
        useGameStore().fetchGames(this.search)
    },
    computed:{
        games(){
            return useGameStore().games
        },
        branches(){
            return useBranchStore().branches;
        },
        auth(){
            return useAuthStore().user
        },
        length(){
            if(useGameStore().games.played.length || useGameStore().games.notPlayed.length) return true
            else return false
        },
    },
    methods:{
        to(option,id = null){
            this.to_delete = null
            this.to_watch = null
            switch(option){
                case 'delete':
                    console.log(id)
                    this.to_delete = this.findGame(id);
                    break;
                case 'watch':
                    this.to_watch = this.findGame(id);
                    break
            }
        },
        cancel(){
            this.to_delete = null
            this.to_watch = null
        },
        async destroy(){
            await useGameStore().deleteGame(this.to_delete.id);
            useGameStore().fetchGames(this.search);
            $('#event').modal('hide');
        },
        filter(){
            useGameStore().fetchGames(this.search)
            this.tournaments = useTournamentStore().tournaments
            this.length = useTournamentStore().tournaments.length
        },
        findGame(id) {
            let item;
            Object.keys(this.games).forEach((key) => {
                const foundItem = this.games[key].find((item) => item.id === id);
                if (foundItem) {
                    item = foundItem;
                    return;
                }
            });
            return item;
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
            width: 85px !important;
        }
        .full-name,start-date{
            width: 195px !important;
        }
        .played,.score,.branch{
            width: 70px !important;
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