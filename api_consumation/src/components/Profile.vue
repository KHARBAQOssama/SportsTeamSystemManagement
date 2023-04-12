<template>
  <div class="w-100 h-100 d-flex flex-column align-items-center">
    <div class="user-image overflow-hidden rounded-circle shadow-lg position-relative my-4" style="height: 150px; width: 150px;">
        <img :src="user.image_url"  class="w-100" alt="">
        <div class="position-absolute z-3 d-flex justify-content-center align-items-center top-0 w-100 h-100 text-white fw-bold" @click="edit('image')">
            <i class="uil uil-image-edit me-2"></i> Edit
        </div>
    </div>
    <div class="d-flex flex-column w-100 bg-gold my-3 px-5 py-3 shadow-lg">
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">First Name <span class="text-end fw-light">{{ user.first_name }}</span></div>
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">Last Name <span class="text-end fw-light">{{ user.last_name }}</span></div>
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">Email <span class="text-end fw-light">{{ user.email }}</span></div>
        <div class="my-2 w-100 d-flex justify-content-end">
            <button class="white-brand-button me-1" @click="edit('password')">Change Password</button>
            <button class="ms-1 white-brand-button" @click="edit('profile')">Edit Profile</button>  
        </div>
    </div>
    <div v-if="editImage || editProfile || editPassword" class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center bg-gold-300">
        <div v-if="editImage" class="my-auto image-form bg-white p-2 py-3 d-flex flex-column">
            <h4 class="text-gold text-center">Choose Image</h4>
            <div class="overflow-hidden rounded-circle shadow-lg mx-auto my-2 position-relative" style="height: 150px; width: 150px;">
                <img :src="newImage.image" class="w-100 position-absolute top-0" alt="">
            </div>
            <div class="w-100 my-2 m-auto row px-3">
                <input class="" id="userImage" type="file" @change="$event=>onUserImageChange($event)">
                <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
            </div>
            <div class="d-flex w-100 px-3 justify-content-between align-items-center">
                <button class="bg-transparent border-0 text-gold" @click="editImage = false">cancel</button>
                <button class="brand-gold-button border py-1" @click="updateSelfImage">done</button>
            </div>   
        </div>
        <div v-if="editProfile" class="my-auto image-form bg-white p-2 py-3 d-flex flex-column">
            <h4 class="text-gold text-center">Edit Profile</h4>
            <div class="w-100 d-flex flex-column">
                <input type="text" v-model="newData.first_name" placeholder="First Name">
                <input type="text" v-model="newData.last_name" placeholder="Last Name">
                <input type="text" v-model="newData.email" placeholder="Email">
            </div>
            <div class="d-flex w-100 px-3 justify-content-between align-items-center">
                <button class="bg-transparent border-0 text-gold" @click="editProfile = false">cancel</button>
                <button class="brand-gold-button border py-1">done</button>
            </div>   
        </div>
        <div v-if="editPassword" class="my-auto image-form bg-white p-2 py-4 d-flex flex-column">
            <h4 class="text-gold text-center mb-2">Change Password</h4>
            <div class="d-flex flex-column my-2">
                <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.old_password" placeholder="Old Password">
                <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.password" placeholder="New Password">
                <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.password_confirmation" placeholder="Confirm New Password">
            </div>
            <div class="d-flex w-75 m-auto justify-content-between align-items-center mt-2">
                <button class="bg-transparent border-0 text-gold" @click="editPassword = false">cancel</button>
                <button class="brand-gold-button m-0 border py-1">done</button>
            </div>   
        </div>
    </div>
    
  </div>
</template>

<script>
import { useAuthStore } from '../stores/authStore';
import { useUserStore } from '../stores/userStore';
export default {
    data(){
        return {
            newData:{
                first_name:null,
                last_name:null,
                email:null,
            },
            editImage:false,
            editProfile:false,
            editPassword:false,
            newImage:{
                image:null,
                _method:'put'
            },
            newPassword:{
                old_password:null,
                password:null,
                password_confirmation:null,
            }
        }
    },
    computed:{
        user(){
            return useAuthStore().user
        }
    },
    created(){
        useAuthStore().me();
    },
    methods:{
        userShow(){
            console.log(this.user)
        },
        onUserImageChange(event){
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = () => {
            this.newImage.image = reader.result;
            };
            reader.readAsDataURL(file);
        },
        edit(value){
            switch(value){
                case 'image':
                    this.newImage.image = this.user.image_url
                    this.editImage = true
                    break;
                case 'password':
                    this.editPassword = true
                    break;
                case 'profile':
                    this.newData.email = this.user.email
                    this.newData.first_name = this.user.first_name
                    this.newData.last_name = this.user.last_name
                    this.editProfile = true
                    break
            }
        },
        updateSelfImage(){
            console.log(this.newImage)
            useUserStore().updateSelfImage(this.newImage);
        }
    }
}
</script>

<style lang="scss" scoped>
.user-image{
    &:hover > div {
        opacity: 1;
    }
    div{
        background-color: rgba(218, 165, 32, 0.151);
        opacity: 0;
        text-shadow: 1px 1px 0px rgb(0, 0, 0);
    }
}
.image-form{
    width: 360px;
}
</style>