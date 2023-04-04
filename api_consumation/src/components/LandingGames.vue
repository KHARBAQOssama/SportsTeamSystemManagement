<template>  
    <div id="landing-games" class="bg-dark d-flex justify-content-center align-items-center">
        <div id="game" class="mt-auto mb-2 h-75">
            <div class="h-75 text-white d-flex align-items-center justify-content-center">
                <img class="h-75 mx-3" :src="currentGame.home" alt="">
                <img class="h-75 mx-3" :src="currentGame.away" alt="">
            </div>
            <div class="h-25 d-flex flex-column">
                <div class="h-50 d-flex justify-content-around">
                    <div class="text-white mx-2"><i class="fs-5 me-1 uil uil-calender"></i>{{currentGame.date}}</div>
                    <div class="text-white mx-2"><i class="fs-5 me-1 uil uil-clock"></i>{{currentGame.time}}</div>
                </div>
                <div class="h-50 text-white text-center mx-2"><i class="fs-5 me-1 uil uil-map-marker-shield"></i>{{currentGame.stadium}}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
    return {
      games: [
        {
          home: "../assets/images/chelsealogo.png",
          away: "../assets/images/bayernlogo.png",
          time: "13:00",
          date: "2023-04-04",
          stadium: "Stadium 1"
        },
        {
          home: "./assets/images/bayernlogo.png",
          away: "./assets/images/chelsealogo.png",
          time: "15:30",
          date: "2023-04-04",
          stadium: "Stadium 2"
        },
        {
          home: "./assets/images/chelsealogo.png",
          away: "./assets/images/bayernlogo.png",
          time: "18:00",
          date: "2023-04-04",
          stadium: "Stadium 3"
        },
        {
          home: "./assets/images/bayernlogo.png",
          away: "./assets/images/chelsealogo.png",
          time: "18:00",
          date: "2023-04-04",
          stadium: "Stadium 3"
        }
      ],
      currentGame: null,
      currentIndex: -1
    };
  },
  created() {
    this.setCurrentGame();
    setInterval(this.setCurrentGame, 5000);
  },
  methods: {
    setCurrentGame() {
      this.currentIndex++;
      if (this.currentIndex >= this.games.length) {
        this.currentIndex = 0;
      }
      this.currentGame = this.games[this.currentIndex];
    }
  }

}
</script>

<style lang="scss" scoped>
#landing-games {
    background-image: url(../assets/images/3185113.jpg);
    height: 60vh;
    width: 100vw;
    transition: all .3s ;
    #game{

    }
//     div{
//         height: 80%;
//         img{
//             height: 90%;
//         }
//         #info{
//             max-width: 360px;
//         }
//     }
}
</style>