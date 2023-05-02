<template>
    <button class="text-center px-2 position-fixed end-0 me-5 mb-5 bottom-0 z-3 border-2 border-white">
        <router-link to="/sign" class="fs-5">Join Us</router-link>
    </button>
</template>
<script>
export default {

}
</script>

<style lang="scss" scoped>
button{
    width: 240px;
    height: 50px;
    background-color: goldenrod;
    border: 2px solid goldenrod;
    transition: all .3s ease;
    a{
        color: rgb(0, 0, 0);
    }
    &:hover{
        a{
            color: rgb(0, 0, 0);
        }
        width: 260px;
        background-color: goldenrod;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.247);
    }
}
</style>