<template>
  <nav class="d-flex px-5 align-items-center position-absolute top-0 bg-transparent">
    <img src="../assets/images/logo.png" class="me-auto" height="30" alt="">
    <div class="d-flex justify-content-around ms-auto">
        <a href="#" class="ms-4"><div class="fs-5">News</div></a>
        <a href="#" class="ms-4"><div class="fs-5">Store</div></a>
        <a href="#" class="ms-4"><div class="fs-5">Contact Us</div></a>
        <a href="#" class="ms-4"><div class="fs-5">About</div></a>
    </div>
  </nav>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
nav{
    height: 65px;
    width: 100vw;
    a:hover div{
        color: rgb(255, 208, 0);
        text-shadow: 0 0 3px rgba(255, 255, 255, 0.603);
    }
}
</style>