<template>
  <nav class="navbar navbar-expand-lg w-100 bg-black mb-auto">
    <div class="container-fluid p-0">
      <a class="navbar-brand ms-3 logo-link" href="#"><img src="../assets/images/logo.png" height="45px" class="me-2" alt="">STM</a>
      <button class="navbar-toggler ms-auto me-5 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <i class="uil uil-location-arrow-alt"></i>
      </button>
      <div class="collapse navbar-collapse px-4 pe-5 bg-black mt-3" id="navbarTogglerDemo01">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Store</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.logo-link{
  color: goldenrod;
  font-size: 35px;
  font-weight: lighter;
}
.nav-link{
  color: white;
  text-shadow: 0 0 5px rgb(37, 30, 11);
  font-size: 18px;
}
.nav-link:hover{
  color: goldenrod;
  text-shadow: 0;
}
.navbar-toggler{ 
  transition: all 0.3s;
  &:focus{
    box-shadow: 0 !important;
  }
  i{
    color: goldenrod;
  }
}
.collapsed{
  transform: rotate(180deg) !important;
}

</style>