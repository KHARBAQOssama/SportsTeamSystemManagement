<template>
    <form v-if="!forget" @submit.prevent="signIn" action="" class="col-md-5 col-lg-5 col-9 my-auto row bg-white py-5 shadow">
        <h3 class="text-center fw-bold form-title mb-3">SIGN IN</h3>
        <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="email" placeholder="email" v-model="signInData.email">
        <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password" v-model="signInData.password">
        <div class="col-lg-9 col-11 d-flex mx-auto mt-3 p-0">
            <button class="w-50 forget-password" @click.prevent="forget = true">Forget Password</button>
            <button class="w-50 ms-auto py-2 .brand-gold-button border">done</button>
        </div>
    </form> 
    <ForgetPassword v-if="forget" @cancel="forget = false"></ForgetPassword>
</template>

<script>
import { useAuthStore } from '../stores/authStore';
import ForgetPassword from './ForgetPassword.vue';

export default {
    components:{
        ForgetPassword,
    },
    data(){
        return {
            signInData:{
                email:'',
                password:''
            },
            forget:false
        }
    },
    methods:{
        signIn(){
            useAuthStore().login(this.signInData)
            this.message = useAuthStore() 
        }
    }
}
</script>

<style>

</style>