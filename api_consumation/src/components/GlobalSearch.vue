<template>
  <div class="w-100 py-1">
        <div class="position-relative" id="search-bar">
            <input type="search" class="border-0 bg-black px-4 p-2 w-100 rounded-2 text-gold m-0" placeholder="Search">
            <ion-icon name="search-outline" class="position-absolute top-0 mt-2 fs-4 end-0 me-1 text-gold"></ion-icon>
            <div id="results" class="w-100 bg-cold px-2 rounded-2 text-gold">
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
#search-bar{
    width: 40px;
    transition: width .5s;
    #results{
        height: 0;
        max-height: 300px;
        overflow-y: scroll;
        transition: height .5s;
    }
    &:focus-within {
        width: 100%;
        #results{
            transition-delay: .5s;
        }
        
    }
}
</style>