<template>
    <div class="row d-flex justify-content-center flex-wrap w-100 align-items-center sign-container">
        <SignIn v-if="sign == 'in'" @message="$emit('message',$event)"></SignIn>
        <div class="col-md-5 col-lg-5 col-9 my-auto d-flex flex-column align-items-center my-5">
            <h1 class="mb-3 mt-5">WELCOME TO US</h1>
            <button class="w-50 py-2 mb-5 brand-black-button" v-show="sign == 'in'" @click="signUpView" href="">sign up</button>
            <button class="w-50 py-2 mb-5 brand-black-button" v-show="sign == 'up'" @click="signInView">sign in</button>
        </div>
        <SignUp v-if="sign == 'up'" @message="$emit('message')"></SignUp>
    </div>
</template>

<script>
import SignIn from '../components/SignIn.vue';
import SignUp from '../components/SignUp.vue';

import router from '../routes';

import { useAuthStore } from '../stores/authStore';

export default {
    emits: ['message'],
    components:{
        SignIn,
        SignUp
    },
    data(){
        return{
            sign : 'in',
            message: null
        }
    },
    computed:{
    },
    created(){
        // console.log('hello')
        // await useAuthStore().me();
        if(useAuthStore().user) router.push('/');
    },
    methods:{
        signUpView(){
            this.sign = 'up'
        },
        signInView(){
            this.sign = 'in'
        },
    }
}
</script>

<style lang="scss">
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
        }
        label{
            color: rgb(101, 101, 101);
        }
        .forget-password{
            border: none;
            background: none;
            color: rgba(218, 165, 32, 0.432);
            &:hover{
                color: goldenrod;
                background: none;
                box-shadow: none;
            }
            text-align: start;
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