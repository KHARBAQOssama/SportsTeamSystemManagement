<template>
    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
        <img src="../assets/images/logo.png"  class="h-25" alt="">
        <h3 class="text-gold">Reset Password</h3>
        <form @submit.prevent="resetPassword" class="d-flex flex-column align-items-center w-75 w-sm-50">
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="password" v-model="password" placeholder="New Password">
            <input class="my-2 p-2 col-lg-9 col-11 mx-auto border-0 rounded-0 shadow" type="password" v-model="password_confirmation" placeholder="Confirm Password">
            <button class="brand-gold-button border" type="submit">Reset Password</button>
        </form>
    </div>
</template>

<script>
import { useAuthStore } from '../stores/authStore';
export default {
    props: {
        token: {
        type: String,
        required: true
        },
        email: {
        type: String,
        required: true
        }
    },
    data() {
    return {
        password: '',
        password_confirmation: '',
    }
},
methods: {
    resetPassword() {
        let data = {
            password : this.password,
            password_confirmation : this.password_confirmation,
            token : this.token,
            email : this.email,
        }
        let status = useAuthStore().reset(data)
    }
}
}
</script>

<style lang="scss" scoped>
input{
    border-bottom: 2px solid rgb(255, 255, 255) !important;
    &:hover{
        border-bottom: 2px solid goldenrod !important;
    }
}
</style>