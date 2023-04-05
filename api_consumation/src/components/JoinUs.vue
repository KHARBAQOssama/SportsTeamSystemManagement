<template>
    <button class="border-0 text-center px-2 position-sticky bottom-0">
        <a href="" class="fs-5">Join Us</a>
    </button>
</template>
<script>
export default {

}
</script>

<style lang="scss" scoped>
button{
    right: 0 !important;
    width: 260px;
    height: 50px;
    background-color: rgb(255, 208, 0);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.247);
    transition: all .3s ease;
    &:hover{
        width: 280px;
        background-color: rgb(255, 220, 62);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.247);
        a{
            font-weight: bold;
        }
    }
}
</style>