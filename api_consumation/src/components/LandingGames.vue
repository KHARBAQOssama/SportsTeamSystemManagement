<template>  
    <div id="landing-page" class="position-relative">
      <Navbar></Navbar>
      <NextGame></NextGame>
      <LandingStore></LandingStore>
      <JoinUs></JoinUs>
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import JoinUs from './JoinUs.vue';
import NextGame from './NextGame.vue'
import LandingStore from './LandingStore.vue'
export default {
    components:{
      Navbar,
      JoinUs,
      NextGame,
      LandingStore
    },
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
#landing-page{
  height: 100%;
  width: 100%;
  overflow-x: hidden;
  overflow-y: scroll;
  background-color: black;
}
</style>