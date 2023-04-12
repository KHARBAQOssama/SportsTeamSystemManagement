<template>
  <div class="w-100 next-game position-relative">
        <div class="header text-slider">
          <p class="position-absolute top-0 left-0 z-0 m-0 h-100 w-100">NEXT GAME</p>
        </div>
        <div class="z-1 position-absolute top-0 left-0 w-100 h-100">
          <div class="row h-100">
            <div class="col-4 m-auto d-flex">
              <img src="../assets/images/logo.png" class="col-9 m-auto" alt="">
            </div>
            <div class="col-4 m-auto info">
              <h4 class="text-gold text-center">NEXT GAME</h4>
              <div class="bg-black text-gold text-center py-3 fw-bold mb-1"><i class="uil uil-map-marker"></i> MOHAMMED V STADIUM</div>
              <div class="bg-black text-gold text-center py-3 fw-bold"><i class="uil uil-calender"></i> 17 - 04 - 2024<br><i class="uil uil-clock"></i> 17 : 00</div>
            </div>
            <div class="col-4 m-auto d-flex">
              <img src="../assets/images/chelsealogo.png" class="col-9 m-auto" alt="">
            </div>
          </div>
        </div>
      </div>
</template>

<script>
export default {

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
            border-bottom: 2px solid goldenrod;
            border-right: 2px solid goldenrod;
        }
    }

}
</style>