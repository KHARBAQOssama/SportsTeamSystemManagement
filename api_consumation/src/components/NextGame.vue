<template>
  <div v-if="nextGame.id" class="w-100 next-game position-relative">
        <div class="header text-slider">
          <p class="position-absolute top-0 left-0 z-0 m-0 h-100 w-100">NEXT GAME</p>
        </div>
        <div class="z-1 position-absolute top-0 left-0 w-100 h-100">
          <div class="row h-100">
            <div class="col-4 m-auto d-flex h-75 overflow-hidden">
              <img v-if="nextGame.home_team" :src="nextGame.home_team.image_url" class="col-9 m-auto h-100" alt="">
            </div>
            <div class="col-4 m-auto info">
              <h4 class="text-gold text-center">NEXT GAME</h4>
              <div class="bg-cold border my-2 rounded-4 text-white text-center py-2 fw-light mb-1"><i class="uil uil-map-marker"></i> {{ nextGame.home_team.stadium}}</div>
              <div class="bg-cold border my-2 rounded-4 text-white text-center py-2 fw-light"><i class="uil uil-calender"></i> {{ nextGame.date }}<br><i class="uil uil-clock"></i> {{nextGame.start_time}}</div>
              <div v-if="nextGame.fans" class="button fs-5 text-center my-2 rounded bg-gold text-white border p-2 fw-bold" data-bs-toggle="modal" data-bs-target="#reserve"><i class="uil uil-ticket mt-1 me-3 fs-4"></i>RESERVE</div>
            </div>
            <div class="col-4 m-auto d-flex h-75 overflow-hidden">
              <img v-if="nextGame.away_team" :src="nextGame.away_team.image_url" class="col-9 m-auto h-100" alt="">
            </div>
          </div>
        </div>

        <div class="modal fade" id="reserve" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content px-5 py-4 text-center fw-light fs-4">
              Please Confirm that you want to reserve a ticket for the next match
              <button class="w-50 bg-gold rounded p-2 text-white border-0 fs-6 mx-auto my-3" @click="reservation">Reserve The Seat</button>
            </div>
          </div>
        </div> 
      </div>
</template>

<script>
import { useGameStore } from '../stores/gameStore';
export default {
  computed:{
    nextGame(){
      return useGameStore().nextGame
    }
  },
  async created(){
    await useGameStore().theNextGame()
  },
  methods:{
    reservation(){
      let data = {
        game_id:this.nextGame.id
      }

      useGameStore().reservation(data)
      
      $('#reserve').modal('hide');
    }
  }
}
</script>

<style lang="scss" scoped>
.next-game{
    height: 38vw;
    background-image: url(../assets/images/backgroundFill.jpg.png);
    background-size: 100%;
    background-position: center center;
    overflow: hidden;
    .header p{
        font-size: 38vw;
        line-height: 38vw;
        white-space: nowrap;
        color: rgba(218, 165, 32, 0.301);
    }
    .info{
        font-size: 1.3vw;
        .bg-black{
            
        }
    }

}
</style>