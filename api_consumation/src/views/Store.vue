<template>
    <div id="landing-page" class="position-relative">
      <Navbar></Navbar>
    
    <div class="w-100 row bg-gold">
        <div class="mb-5 col-12 d-flex justify-content-between align-items-center px-3">
            <h3 class="text-white my-3"><ion-icon name="pricetags-outline" class="text-gold fs-4 me-2 text-white nav-icon"></ion-icon> Store</h3>
            <div class="position-relative" data-bs-toggle="modal" data-bs-target="#carts">
                <i class="uil uil-shopping-cart text-white fs-1"></i>
                <div class="bg-black text-gold position-absolute top-0 end-0 rounded-circle px-1">
                    {{ carts.length }}
                </div>
            </div>
	    </div>
      <div class="w-100 row  gap-3 justify-content-around mx-auto">
          <div v-for="(product,index) in products" :key="product.id" class="rounded-3 col-md-3 col-10 d-flex flex-column align-items-center py-4 my-3 bg-white shadow">
              <div class="w-75 rounded-2 d-flex justify-content-center overflow-hidden align-items-center" style="height:150px;">
                  <img :src="product.pImage.image_url" class="w-100" alt="">
              </div>
              <div class="w-100 p-2 d-flex justify-content-around">
                  <div  v-for="image in product.images" @mousemove="product.pImage = image" :key="image.id" class="rounded-circle d-flex justify-content-center overflow-hidden align-items-center shadow-sm" style="width:25px; height:25px;">
                      <img :src="image.image_url" class="w-100" alt="">
                  </div>
              </div>
              <div class="w-100 px-2 mt-2 d-flex flex-column">
                  <h5 class="fw-medium text-start">{{ product.title }}</h5>
                  <p class="fs-small">{{ product.short_description }}</p>
                  <p class="fs-small  text-secondary">{{ product.description.substring(0,200) }}...</p>
                  <div class="d-flex justify-content-between align-items-center mt-auto">
                      <p class="fs-5 fw-bold">{{  product.price }} <span class="fw-light">£</span></p>
                      <button class="text-white p-1 px-2 fw-light bg-gold rounded-2 shadow border-0" data-bs-toggle="modal" data-bs-target="#event" @click="data.product_id= product.id">ADD TO <i class="uil uil-shopping-cart text-white"></i></button>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
                 <div class="modal-content text-light p-3 py-5 text-center text-black">
                  You Are Going To Add This Product To your Cart
                  <button class="w-50 m-auto rounded-2 py-1 mt-4 text-white bg-gold border-0" @click="addToCart">Add To Cart</button>
              </div>
          </div>
      </div>
      <div class="modal fade" id="carts" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
                <div class="modal-content text-light p-3 py-5 text-center text-black">
                    <div class="fs-4">Your Cart <i class="uil uil-shopping-cart fs-4"></i></div>
                    <div v-for="cart in carts" :key="cart.id" class="w-100 d-flex my-2 mx-1 shadow-sm">
                        <div class="w-25 rounded-2 d-flex justify-content-center overflow-hidden align-items-center" style="height:50px;">
                            <img :src="cart.product.images[0].image_url" class="w-100" alt="">
                        </div>
                        <div class="w-50 px-2">
                            <div class="d-flex justify-content-between align-items-center fw-light text-gold" :title="cart.product.title">{{ cart.product.title.substring(0,20) }}... <span class="fs-5 fw-bold">{{ cart.product.price }}</span> £</div>
                            <div class="text-start w-100 fs-small fw-light text-secondary">{{ cart.created_at.substring(0,16) }}</div>
                        </div>
                        <div class="w-25 d-flex justify-content-center align-items-center">
                            <button class="bg-danger rounded-2 border-0 text-white fs-smaller px-1" @click="removeCart(cart.id)">
                                <i class="uil uil-trash me-2"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
          </div>
      </div>
    </div>
</div>
</template>
  
<script>
import { useProductStore } from '../stores/productStore';
import { useCartStore } from '../stores/cartStore';
import Navbar from '../components/Navbar.vue';

export default {
    components:{
      Navbar,
    },
    data(){
        return {
            data:{
                product_id : null
            }
        }	
    },
    created(){
        useProductStore().fetchProducts()
        useCartStore().fetchCarts()
    },
    computed:{
        products(){
            let products = useProductStore().products;
            products.forEach(product => {
                product.pImage = product.images[0];
            });
            return  products
        },
        carts(){
            return  useCartStore().carts
        },
    },
    methods:{
        addToCart(){
            useCartStore().store(this.data);
            useCartStore().fetchCarts()
            $('#event').modal('hide');
        },
        removeCart(id){
            useCartStore().deleteCart(id);
            useCartStore().fetchCarts()
        }
    }
}
</script>

<style>

</style>