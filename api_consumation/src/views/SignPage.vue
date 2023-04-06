<template>
    <div class="row d-flex justify-content-center flex-wrap w-100 align-items-center sign-container">
        <form v-if="sign == 'in'" @submit.prevent="signIn" action="" class="col-md-5 col-lg-5 col-9 my-auto d-flex flex-column bg-white py-5 shadow rounded-3">
            <h3 class="text-center fw-bold form-title mb-3">SIGN IN</h3>
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="email" placeholder="email" v-model="signInData.email">
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password" v-model="signInData.password">
            <div class="w-75 d-flex mx-auto mt-3"><button class="w-50 ms-auto py-2 rounded-pill">done</button></div>
        </form> 
        <div class="col-md-5 col-lg-5 col-9 my-auto d-flex flex-column align-items-center my-5">
            <h1 class="mb-3 mt-5">WELCOME TO US</h1>
            <button class="w-25 rounded-pill py-2 bg-transparent mb-5" v-show="sign == 'in'" @click="signUpView" href="">sign up</button>
            <button class="w-25 rounded-pill py-2 bg-transparent mb-5" v-show="sign == 'up'" @click="signInView">sign in</button>
        </div>
        <form v-if="sign == 'up'" @submit.prevent="signUp" action="" class="col-md-5 col-lg-5 col-9 my-auto d-flex flex-column bg-white py-5 shadow rounded-3">
            <h3 class="text-center fw-bold form-title mb-3">CREATE AN ACCOUNT</h3>
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="text" placeholder="first_name" v-model="signUpData.first_name">
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="text" placeholder="last_name" v-model="signUpData.last_name">
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="email" placeholder="email" v-model="signUpData.email">
            <div class="my-2 w-75 mx-auto d-flex align-items-center">
                <label for="birth_day">Birthday</label>
                <input class="p-2 w-75 ms-auto border-0 rounded-0 shadow" name="birth_day" type="date" placeholder="birth_day" v-model="signUpData.birth_day">
            </div>
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password" v-model="signUpData.password">
            <input class="my-2 p-2 w-75 mx-auto border-0 rounded-0 shadow" type="password" placeholder="password_confirmation" v-model="signUpData.password_confirmation">
            <div class="w-75 d-flex mx-auto mt-3"><button class="w-50 ms-auto py-2 rounded-pill">done</button></div>
        </form>
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
    transition: all .3s;
    background-color: goldenrod;
    height: 100vh !important;
    overflow-y: scroll;
    form{
        input{
            border-bottom: 2px solid rgb(255, 255, 255) !important;
            &:hover{
                border-bottom: 2px solid goldenrod !important;
            }
        }
        button{
            background-color: white;
            border: 1px solid goldenrod;
            color: goldenrod;
            &:hover{
                background-color: goldenrod;
                color: white;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.333);
            }
        }
        .form-title{
            color: goldenrod;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.473);
        }
        label{
            color: rgb(101, 101, 101);
        }
    }
    .w-40{
        width: 40%;
    }
    button{
        border: 1px solid black;
    }
}
</style>