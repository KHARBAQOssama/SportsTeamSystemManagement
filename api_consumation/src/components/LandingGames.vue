<template>  
    <div id="landing-games" class="d-flex justify-content-center align-items-center">
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
    background-color: goldenrod;
    height: 60vh;
    width: 100vw;
    transition: all .3s ;
    img{
      // filter: drop-shadow(5px 5px 15px #12121275);
      filter: drop-shadow(2px 2px 0 black) 
          drop-shadow(-2px -2px 0 black);
    }
    #game{

    }
}
</style>