<template>
    <div class="d-flex justify-content-center flex-wrap w-100 align-items-center sign-container bg-gold">
        <form v-if="sign == 'in'" @submit.prevent="signIn" action="" class="w-md-75 w-sm-75 w-40 my-auto d-flex flex-column bg-white py-4 shadow rounded-3">
            <input class="my-2 w-75 mx-auto" type="email" placeholder="email" v-model="signInData.email">
            <input class="my-2 w-75 mx-auto" type="password" placeholder="password" v-model="signInData.password">
            <div class="w-75 d-flex mx-auto"><button class="w-50 ms-auto">done</button></div>
        </form> 
        <div class="w-md-75 w-sm-75 w-40 my-auto d-flex flex-column align-items-center">
            <h1>WELCOME TO US</h1>
            <button class="w-25 rounded-pill py-2 bg-transparent" v-show="sign == 'in'" @click="signUpView" href="">sign up</button>
            <button class="w-25 rounded-pill py-2 bg-transparent" v-show="sign == 'up'" @click="signInView">sign in</button>
        </div>
        <form v-if="sign == 'up'" @submit.prevent="signUp" action="" class="w-md-75 w-sm-75 w-40 my-auto d-flex flex-column bg-white py-4 shadow rounded-3">
            <input class="my-2 w-75 mx-auto" type="text" placeholder="first_name" v-model="signUpData.first_name">
            <input class="my-2 w-75 mx-auto" type="text" placeholder="last_name" v-model="signUpData.last_name">
            <input class="my-2 w-75 mx-auto" type="email" placeholder="email" v-model="signUpData.email">
            <input class="my-2 w-75 mx-auto" type="date" placeholder="birth_day" v-model="signUpData.birth_day">
            <input class="my-2 w-75 mx-auto" type="password" placeholder="password" v-model="signUpData.password">
            <input class="my-2 w-75 mx-auto" type="password" placeholder="password_confirmation" v-model="signUpData.password_confirmation">
            <div class="w-75 d-flex mx-auto"><button class="w-50 ms-auto">done</button></div>
        </form>
        <h4 v-show="message"> {{ message }} </h4>
    </div>
</template>

<script>
import { toRaw } from 'vue';
import { useUserStore } from '../stores/userStore';
import { useAuthStore } from '../stores/authStore';

export default {
    data(){
        return{
            sign : 'up',
            signUpData : {
                first_name : '',
                last_name : '',
                birth_day : '',
                email : '',
                password : '',
                password_confirmation : '',
            },
            signInData:{
                email:'',
                password:''
            },
            message: null
        }
    },
    methods:{
        signUpView(){
            this.sign = 'up'
        },
        signInView(){
            this.sign = 'in'
        },
        signUp(){
            // this.message = 
            useUserStore().signUp(this.signUpData)
            this.message = useUserStore().message 
            console.log(this.message)
        },
        signIn(){
            useAuthStore().login(this.signInData)
            this.message = useAuthStore() 
        }
    }
}
</script>

<style lang="scss" scoped>
.sign-container{
    height: 100vh !important;
    
    .w-40{
        width: 40% !important;
    }
    transition: all 1s;
    button{
        border: 1px solid black;
    }
}
.bg-gold{
        background-color: goldenrod;
    }
</style>