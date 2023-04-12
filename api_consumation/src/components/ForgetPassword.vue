<template>
    <div class="w-100 h-100 d-flex bg-gold-300 justify-content-center align-items-center position-fixed top-0 left-0 background-div">
        <form class="row col-lg-4 col-md-8 col-9 bg-white shadow-lg py-3 position-relative" action="" @submit.prevent="resetPassword">
            <h5 class="text-center my-2 col-10 m-auto text-gold">Forget Password</h5>
            <input class="col-10 m-auto my-3 p-2 border-0 shadow" type="text" placeholder="Your Email" v-model="forgetData.email">
            <div class="col-10 d-flex m-auto my-2 p-0">
                <button class="w-50 forget-password me-auto" @click.prevent="$emit('cancel')">Cancel</button>
                <button class="w-50 py-2 ms-auto" >Reset Password</button>
            </div>
        </form> 
    </div>
</template>

<script>
import {useAuthStore} from '../stores/authStore'

export default {
    data(){
        return {
            forgetData:{
                email:'',
            }
        }
    },
    computed:{
        
    },
    methods:{
        resetPassword(){
            useAuthStore().resetPassword(this.forgetData);
        }
    }
}
</script>

<style>

</style>