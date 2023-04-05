<template>
    <div>
        <form v-show="sign == 'in'" @submit.prevent="signUp" action="">
            <!-- <button @click="signUpView">sign up</button> -->
            <input type="text" >
        </form>
        <div>
            <h1>WELCOME TO US</h1>

        </div>
        <form v-show="sign == 'up'" @submit.prevent="signIn" action="">
            <!-- <button @click="signInView">sign in</button> -->
            <input type="text" placeholder="first_name" v-model="signUpData.first_name">
            <input type="text" placeholder="last_name" v-model="signUpData.last_name">
            <input type="email" placeholder="email" v-model="signUpData.email">
            <input type="date" placeholder="birth_day" v-model="signUpData.birth_day">
            <input type="password" placeholder="password" v-model="signUpData.password">
            <input type="password" placeholder="password_confirmation" v-model="signUpData.password_confirmation">
            <button>done</button>
        </form>
    </div>
</template>

<script>
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
            }
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
            this.sign = 'up'
        },
        signIn(){
            this.sign = 'in'
        }
    }
}
</script>

<style>

</style>