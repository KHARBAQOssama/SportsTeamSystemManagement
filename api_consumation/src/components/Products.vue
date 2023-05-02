<template>
    <div class="w-100 d-flex flex-column justify-content-center align-items-center h-100">
        <h3>Products</h3>
        <div class="row w-100 g-4 mt-1  mx-auto">
                <input class="col-md-5 col-12 mx-auto" type="text" v-model="search.params.by_search" placeholder="Search A User" @keyup="filter()">
                <input type="number" class="col-md-3 col-5 mx-auto" v-model="search.params.max_price" placeholder="Min Price" @input="filter" @change="filter" name="" id="">
                <input type="number" class="col-md-3 col-5 mx-auto" v-model="search.params.min_price" placeholder="Max Price" @input="filter" @change="filter" name="" id="">
        </div>
        <div class="add my-2 d_flex" v-if="heCan('Add Product')">
            <button class="text-gold bg-black rounded-3 border-0 py-2 d-flex justify-content-center align-items-center ms-auto px-3" data-bs-toggle="modal" data-bs-target="#event" @click="to('add')"><ion-icon name="trophy" class="text-gold me-2"></ion-icon>Add Product</button>
        </div>
        <div v-for="product in products" class="row col-md-9 col-10 rounded-1 bg-cold rounded-3 shadow align-items-center my-2" :key="product.id">
            <div class="col-md-6 col-12 p-2 d-flex flex-wrap">
                <div v-for="image in product.images" :key="image.id" class="overflow-hidden m-auto d-flex justify-content-center my-1" style="width:100px; height:100px;">
                    <img :src="image.image_url" class="h-100" alt="">
                </div>
            </div>
            <div class="col-md-6 col-12 p-2 px-4 d-flex flex-column justify-content-around">
                <h5>
                    {{ product.title }}
                </h5>
                <div><span class="text-secondary fs-small">{{product.short_description}}</span></div>
                <div><span class="fw-bolder">{{ product.price }}</span> £</div>
                <div><span class="fw-bold">{{ product.quantity }}</span> Piece</div>
                <div class="w-100">
                    <div class="d-flex justify-content-around align-items-center py-2 w-50">
                        <button v-if="heCan('Update Product')" class="border-0 bg-transparent rounded-1 p-1 px-2 update" data-bs-toggle="modal" data-bs-target="#event" @click="to('edit',product.id)"><i class="uil text-warning uil-pen"></i></button>
                        <button v-if="heCan('Delete Product')" class="border-0 bg-transparent rounded-1 p-1 px-2 delete" data-bs-toggle="modal" data-bs-target="#event" @click="to('delete',product.id)"><i class="uil text-danger uil-trash"></i></button>
                    </div>
                </div>
            </div>
            

        </div>
        
        
        <div class="modal fade" id="event" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
           <!-- Modal  -->
           <div class="modal-content">
            <div class="modal-header">
                <h4 v-if="to_delete" class="" >Delete Product</h4>
                <h4 v-if="to_edit" class="" >Edit Product</h4>
                <h4 v-if="to_add" class="" >Add Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="cancel()"></button>
            </div>
            
            <div v-if="to_edit" class="modal-body d-flex flex-column">
                <input type="text" v-model="to_edit.title" placeholder="The Product Name"> 
                <input type="text" v-model="to_edit.short_description" placeholder="The Product Short Description"> 
                <textarea class="w-75" rows="5" type="text" v-model="to_edit.description" placeholder="The Product Description"></textarea>
                <input type="number" v-model="to_edit.price" placeholder="The Product Price"> 
                <input type="number" v-model="to_edit.quantity" placeholder="The Product Quantity"> 
                <div class="w-75 m-auto d-flex flex-wrap justify-content-start">
                    <div v-for="(image,index) in to_edit.images" :key="index" class="w-25 mx-2 rounded overflow-hidden position-relative" style="height:100px;">
                        <img :src="image.image_url" class="w-100" alt="">
                        <button class="position-absolute  bg-white border-danger px-1 rounded-circle border-1  top-0 end-0 m-1" @click="deleteImage('edit',index)"><i class="uil text-danger uil-trash text-danger"></i></button>
                    </div>
                    <div v-for="(image,index) in to_edit.newImages" :key="index" class="w-25 mx-2 rounded overflow-hidden position-relative" style="height:100px;">
                        <img :src="image" class="w-100" alt="">
                        <button class="position-absolute  bg-white border-danger px-1 rounded-circle border-1  top-0 end-0 m-1" @click="deleteImage('editNew',index)"><i class="uil text-danger uil-trash text-danger"></i></button>
                    </div>
                </div>
                
                <input class="w-75" id="teamImage" type="file" @change="$event=>addImage($event,'edit')">
                <label for="teamImage" class="w-75 mx-auto"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
            </div>


            <div v-if="to_add" class="modal-body d-flex flex-column">
                <input type="text" v-model="to_add.title" placeholder="The Product Name"> 
                <input type="text" v-model="to_add.short_description" placeholder="The Product Short Description"> 
                <textarea class="w-75" rows="5" type="text" v-model="to_add.description" placeholder="The Product Description"></textarea>
                <input type="number" v-model="to_add.price" placeholder="The Product Price"> 
                <input type="number" v-model="to_add.quantity" placeholder="The Product Quantity"> 
                <div class="w-75 m-auto d-flex flex-wrap justify-content-start">
                    <div v-for="(image,index) in to_add.images" :key="index" class="w-25 mx-2 rounded overflow-hidden position-relative" style="height:100px;">
                        <img :src="image" class="w-100" alt="">
                        <button class="position-absolute  bg-white border-danger px-1 rounded-circle border-1  top-0 end-0 m-1" @click="deleteImage('add',index)"><i class="uil text-danger uil-trash text-danger"></i></button>
                    </div>
                </div>
                
                <input class="w-75" id="teamImage" type="file" @change="$event=>addImage($event,'add')">
                <label for="teamImage" class="w-75 mx-auto"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
            </div>
            <div v-if="to_delete" class="modal-body d-flex flex-column">
                Are You Sure You W ant To Delete This Product ??
            </div>

            <div v-if="to_edit || to_delete || to_add" class="d-flex justify-content-end">
                <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <button v-if="to_delete" type="button" class="brand-gold-button mx-3" @click="destroy">Delete</button>
                <button v-if="to_edit" type="button" class="brand-gold-button mx-3" @click="update">Update</button>
                <button v-if="to_add" type="button" class="brand-gold-button mx-3" @click="store">Store</button>
            </div>
            </div>
        </div>
        </div> 
    </div>
</template>

<script>
import { useBranchStore } from '../stores/branchStore';
import { useAuthStore } from '../stores/authStore';
import { useProductStore } from '../stores/productStore';

import { can } from '../middlewares/can'

export default {
    data(){
        return {
            search :{
                params:{
                    max_price:null,
                    min_price:null,
                    by_search:''
                }
            },
            to_delete: null,
            to_watch: null,
            to_edit: null,
            to_add: null,
        }
    },
    created(){
        useProductStore().fetchProducts(this.search)
    },
    computed:{
        products(){
            return useProductStore().products
        },
        branches(){
            return useBranchStore().branches;
        },
        auth(){
            return useAuthStore().user
        },
        length(){
            return useProductStore().products.length
        },
        standing(){
            return useProductStore().standing
        },
    },
    methods:{
        to(option,id = null){
            console.log(option)
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            this.to_add = null
            switch(option){
                case 'add':
                    this.to_add = {
                        title:'',
                        price:'',
                        images:[],
                        short_description:'',
                        description:'',
                        quantity:''
                    }
                    break
                case 'edit':
                    this.to_edit = this.products.find(item => item.id === id);
                    this.to_edit.newImages = [];
                    break;
                case 'delete':
                    console.log(id)
                    this.to_delete = this.products.find(item => item.id === id)
                    break;
                case 'watch':
                    this.to_watch = this.products.find(item => item.id === id)
                    break
            }
        },
        cancel(){
            this.to_delete = null
            this.to_edit = null
            this.to_watch = null
            this.view_st = false
            console.log(this.to_delete,this.to_edit,this.to_watch)
        },
        addImage(event,option){
            const file = event.target.files[0];
            const reader = new FileReader();
            switch(option){
                case 'add':
                    reader.onload = () => {
                        this.to_add.images.push(reader.result);
                    };
                    break;
                case 'edit':
                    reader.onload = () => {
                        this.to_edit.newImages.push(reader.result);
                    };
                    break;
            }
            
            reader.readAsDataURL(file);
        },
        async update(){
            this.to_edit.image_ids = this.to_edit.images.map(image => image.id)
            await useProductStore().updateProduct(this.to_edit);
            useProductStore().fetchProducts(this.search);
            $('#event').modal('hide');
        },
        async destroy(){
            await useProductStore().deleteProduct(this.to_delete.id);
            useProductStore().fetchProducts(this.search);
            $('#event').modal('hide');
        },
        async store(){
            console.log(this.to_add);
            await useProductStore().store(this.to_add);
            useProductStore().fetchProducts(this.search);
            $('#event').modal('hide');
        },
        filter(){
            console.log(this.search)
            useProductStore().fetchProducts(this.search)
            this.products = useProductStore().products
            this.length = useProductStore().products.length
        },

        deleteImage(option,index){
            switch(option){
                case 'add':
                    console.log('hi')
                    this.to_add.images.splice(index,1);
                    console.log(this.to_add.images)
                    break;
                case 'edit':
                    console.log(this.to_edit.images)
                    this.to_edit.images.splice(index,1);
                    break;
                case 'editNew':
                    console.log(this.to_edit.images)
                    this.to_edit.newImages.splice(index,1);
                    break;
            }
        },
        heCan(permission){
            return can(permission)
        }
        
    }
}
</script>

<style lang="scss" scoped>
.no-data{
    width: 70vw;
}
.filter,.add{
    width: 100%;
}
.table{
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.185);
    height: 62vh;
    .trow{
        height: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100% !important;
        // @media (max-width: 1100px) {
        //     width: 1000px !important;
        // }
    }
    .under-table{
        width: 100% !important;
        @media (max-width: 1100px) {
            width: 1000px !important;
        }
    }
    .table-head,.table-body{
        width: 100%;
        font-size: 14px;
        overflow-x: scroll;
        p{
            width: 25ch;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .events{
            width: 140px;
            right: 0;
        }
        .full-name,start-date{
            width: 270px;
        }
        .branch,.image{
            width: 65px;
        }
        .image>div{
            width: 30px;
            height: 30px;
        }

    }
    .watch:hover{
        background-color: rgba(22, 165, 22, 0.221) !important;
    }
    .delete:hover{
        background-color: rgba(255, 0, 0, 0.308) !important;
    }
    .update:hover{
        background-color: rgba(255, 243, 6, 0.221) !important;
    }
}
</style>
