<template>
  <div>
    <form action="" @submit.prevent="updateUser">
        <input type="text" v-model="user.first_name">
        <input type="text" v-model="user.last_name">
        <input type="email" v-model="user.email">
        <input type="date" v-model="user.birth_day">
        <img :src="user.image ? user.image : user.image_url" height="80" alt="">
        <input type="file" id="hello" @change="onImageChange($event)">
        <label class="w-25" for="hello">choose image</label>
        <button>done</button>
    </form>
    <div v-if="message">{{ message }}</div>
  </div>
</template>

<script>
import { useUserStore } from '../stores/userStore';
export default {
    data(){
        return {
        }
    },
    computed: {
        user() {
            return {
                id: useUserStore().user.id,
                last_name: useUserStore().user.last_name,
                first_name: useUserStore().user.first_name,
                email: useUserStore().user.email,
                password: useUserStore().user.password,
                image_url: useUserStore().user.image_url,
                birth_day: useUserStore().user.birth_day,
                permissions: useUserStore().user.permissions,
                role: useUserStore().user.role,
                branch: useUserStore().user.branch,
                image: '',
            };
        },
        message(){
            return useUserStore().message;
        }
    },
    created(){
        useUserStore().getUser(this.$route.params.id);
    },
    methods:{
        onImageChange(event){
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = () => {
            this.user.image = reader.result;
            };
            reader.readAsDataURL(file);
        },
        updateUser(){
            this.user._method = 'put',
            useUserStore().updateUser(this.user);
        }
    }
    
}
</script>

<style>

</style>