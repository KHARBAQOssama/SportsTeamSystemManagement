<script setup>
import { useUserStore } from '@/stores/userStore'
import { computed,ref } from 'vue'

    const store = useUserStore()
    const first_name = ref('');
    const last_name = ref('');
    const birth_day = ref('');
    const email = ref('');
    const password = ref('');
    const password_confirmation = ref('');

    function signUp(){
      // let parts = birth_day.value.split("/");
      let data = {
            first_name: first_name.value ,
            last_name: last_name.value ,
            birth_day: birth_day.value ,
            // birth_day: parts[2] + "-" + parts[0].padStart(2, "0") + "-" + parts[1].padStart(2, "0") ,
            email: email.value ,
            password: password.value ,
            password_confirmation: password_confirmation.value ,
        }
      store.signUp(data);
    }
    function signIn(){
      // let parts = birth_day.value.split("/");
      let data = {
            // first_name: first_name.value ,
            // last_name: last_name.value ,
            // birth_day: birth_day.value ,
            // birth_day: parts[2] + "-" + parts[0].padStart(2, "0") + "-" + parts[1].padStart(2, "0") ,
            email: email.value ,
            password: password.value ,
            // password_confirmation: password_confirmation.value ,
        }
      store.signIn(data);
    }

    const name = computed(()=>store.user)
</script>

<template>
  <form action="" class="d-flex flex-column p-4">
        <div class="mb-4 d-flex">
            <input class="px-2 py-1 border-0 shadow-sm w-50" type="text" v-model="first_name" placeholder="First name">
            <input class="px-2 py-1 border-0 shadow-sm w-50 ms-1" type="text" v-model="last_name" placeholder="Last name">
        </div>
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <label for="birthday" class="mx-2">Birthday</label>
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="date" v-model="birth_day" id="birthday">
        </div>
        <div class="mb-4">
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="email" v-model="email" placeholder="Email">
        </div>
        <div class="mb-4">
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="password" v-model="password" placeholder="Password">
        </div>
        <div class="mb-4">
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="password" v-model="password_confirmation" placeholder="Password Confirmation">
        </div>
        <button class="my-3" @click.prevent="signUp()">Register</button>
        <!-- <p>Already Have An Account? <router-link to="/sign-in">sign-in</router-link></p> -->
    </form>
  <form action="" class="d-flex flex-column p-4">
        <div class="mb-4">
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="email" v-model="email" placeholder="Email">
        </div>
        <div class="mb-4">
            <input class="px-2 py-1 border-0 shadow-sm w-100" type="password" v-model="password" placeholder="Password">
        </div>
        <button class="my-3" @click.prevent="signIn()">Register</button>
        <!-- <p>Already Have An Account? <router-link to="/sign-in">sign-in</router-link></p> -->
    </form>
</template>

<style scoped>
form{
    width: 340px;
    box-shadow: 0 0 20px #ffd5004b;
    border-radius: 5px;
}
label{
    color: rgb(119, 118, 118);
}
input:focus{
    border: none;
    background: #ffd5004b;
}
</style>
