<template>
  <div class="w-100 row bg-gold">
	<h3 class="text-white my-3 mb-5 col-12 text-center"><ion-icon name="pricetags-outline" class="text-gold fs-4 me-2 text-white nav-icon"></ion-icon> Products</h3>
	<div class="w-100 row justify-content-around mx-auto">
		<div v-for="(product,index) in products" :key="product.id" :class="index < 3 ? 'rounded-3 col-md-3 col-10 d-flex flex-column align-items-center py-4 my-3 bg-white shadow' : 'd-none'">
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
	<router-link to="/store" class="text-white fs-3 my-3 mt-5 col-12 text-center"><ion-icon name="pricetags-outline" class="text-gold fs-4 me-2 mt-1 text-white nav-icon"></ion-icon> More</router-link>
  </div>
</template>

<script>
import { useProductStore } from '../stores/productStore';
import { useCartStore } from '../stores/cartStore';

export default {
	data(){
		return {
			data:{
				product_id : null
			}
		}	
	},
	created(){
        useProductStore().fetchProducts()
    },
    computed:{
        products(){
			let products = useProductStore().products;
			products.forEach(product => {
				product.pImage = product.images[0];
			});
            return  products
        },
	},
	methods:{
		addToCart(){
			useCartStore().store(this.data);
            $('#event').modal('hide');
		}
	}
}
</script>

<style>

</style>