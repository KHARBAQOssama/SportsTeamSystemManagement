<template>
    <form @submit.prevent="signUp" action="" class="col-md-5 col-lg-5 col-9 my-auto row bg-white py-5 shadow">
            <h3 class="text-center fw-bold form-title mb-3">CREATE AN ACCOUNT</h3>
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="text" placeholder="first_name" v-model="signUpData.first_name">
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="text" placeholder="last_name" v-model="signUpData.last_name">
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="email" placeholder="email" v-model="signUpData.email">
            <div class="my-2 col-lg-9 col-11 mx-auto d-flex align-items-center p-0">
                <label class="w-50" for="birth_day">Birthday</label>
                <input class="p-2 w-50 ms-auto border-0 rounded-0 shadow" id="birth_day" type="date" placeholder="birth_day" v-model="signUpData.birth_day">
            </div>
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password" v-model="signUpData.password">
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password_confirmation" v-model="signUpData.password_confirmation">
            <div class="col-lg-9 col-11 d-flex mx-auto mt-3 p-0"><button class="w-50 ms-auto py-2 .brand-gold-button border">done</button></div>
    </form>
</template>

<script>
import { useUserStore } from '../../stores/userStore';

export default {
    data(){
        return {
            signUpData : {
                first_name : '',
                last_name : '',
                birth_day : '',
                email : '',
                password : '',
                password_confirmation : '',
            },
        }
    },
    methods:{
        signUp(){
            // this.message = 
            useUserStore().signUp(this.signUpData)
            this.message = useUserStore().message 
            console.log(this.message)
        },
    }
}
</script>

<style>

</style>