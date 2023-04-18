<template>
  <div v-if="user" class="w-100 h-100 d-flex flex-column align-items-center">
    <div class="user-image overflow-hidden rounded-circle shadow-lg position-relative my-4" style="height: 150px; width: 150px;">
        <img :src="user.image_url"  class="w-100" alt="">
        <div class="position-absolute z-3 d-flex justify-content-center align-items-center top-0 w-100 h-100 text-white fw-bold" @click="edit('image')">
            <i class="uil uil-image-edit me-2"></i> Edit
        </div>
    </div>
    <div class="d-flex flex-column w-100 mx-2 rounded-3 bg-gold my-3 px-5 py-3 shadow-lg">
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">First Name <span class="text-end fw-light">{{ user.first_name }}</span></div>
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">Last Name <span class="text-end fw-light">{{ user.last_name }}</span></div>
        <div class="my-1 w-100 d-flex justify-content-between fw-bold">Email <span class="text-end fw-light">{{ user.email }}</span></div>
        <div class="my-2 w-100 d-flex justify-content-end">
            <button class="white-brand-button me-1" data-bs-toggle="modal" data-bs-target="#editing" @click="edit('password')">Change Password</button>
            <button class="ms-1 white-brand-button" data-bs-toggle="modal" data-bs-target="#editing" @click="edit('profile')">Edit Profile</button>  
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editing" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
            <div v-if="editImage" class="modal-body text-center">
                <h4 class="text-gold text-center">Choose Image</h4>
                <div class="overflow-hidden rounded-circle shadow-lg mx-auto my-2 position-relative" style="height: 150px; width: 150px;">
                    <img :src="newImage.image"  class="w-100" alt="">
                </div>
                <div class="w-100 my-2 m-auto row px-3">
                    <input class="" id="userImage" type="file" @change="$event=>onUserImageChange($event)">
                    <label for="userImage"><i class="uil uil-image-plus me-2"></i>Choose An Image</label>
                </div>
            </div>
            <div v-if="editProfile" class="modal-body px-4">
                <h4 class="text-gold text-center">Edit Profile</h4>
                <div class="w-100 d-flex flex-column">
                    <input type="text" v-model="newData.first_name" placeholder="First Name">
                    <input type="text" v-model="newData.last_name" placeholder="Last Name">
                    <input type="text" v-model="newData.email" placeholder="Email">
                    <input type="date" v-model="newData.birth_day">
                </div>
            </div>
            <div v-if="editPassword" class="modal-body d-flex flex-column">
                <h4 class="text-gold text-center mb-2">Change Password</h4>
                <div class="d-flex flex-column my-2">
                    <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.old_password" placeholder="Old Password">
                    <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.password" placeholder="New Password">
                    <input class="w-75 mx-auto py-1 px-3 my-2 border-0 shadow" type="password" v-model="newPassword.password_confirmation" placeholder="Confirm New Password">
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="bg-transparent border-0 text-gold mx-2" data-bs-dismiss="modal" @click="cancel">Close</button>
                <button v-if="editImage" type="button" class="brand-gold-button border py-1 mx-2 " @click="updateSelfImage">Done</button>
                <button v-if="editProfile" type="button" class="brand-gold-button border py-1 mx-2 " @click="updateSelf">Update</button>
                <button v-if="editPassword" type="button" class="brand-gold-button border py-1 mx-2 " @click="changePassword">Update</button>
            </div>
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
                birth_day:null,
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
    async created(){
        await useAuthStore().me();
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
                    $('#editing').modal('show');
                    break;
                case 'password':
                    this.editPassword = true
                    break;
                case 'profile':
                    this.newData.email = this.user.email
                    this.newData.first_name = this.user.first_name
                    this.newData.last_name = this.user.last_name        
                    this.newData.birth_day = this.user.birth_day        
                    this.editProfile = true
                    break
            }
        },
        updateSelfImage(){
            console.log(this.newImage)
            useUserStore().updateSelfImage(this.newImage);
        },
        update(){

        },
        changePassword(){

        },
        async updateSelf(){
            this.newData._method = 'put';
            await useUserStore().updateSelf(this.newData)
            this.editProfile = false;
            $('#editing').modal('hide');
            this.user = useUserStore().user
        },
        cancel(){
            this.editImage = false;
            this.editPassword = false;
            this.editProfile = false;
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