<template>
    <div :class="theClass">
        <span class="uil uil-exclamation text-gold"></span>
        <span class="msg">
            {{message}}
        </span>
        <div class="close-btn" @click="$emit('cancel')">
            <span class="uil uil-times text-gold"></span>        
        </div>
    </div>
</template>

<script>
export default {
    props:{
        message:{
            type: String,
            required:true
        }
    },
    data(){
        return {
            theClass: 'alert hide'
        }
    },
    created(){
        this.theClass = 'alert show showAlert'
        setTimeout(function(){
            this.theClass = 'alert hide'
            console.log(this.theClass)
        },4000);
    },
    methods:{
        
    }

}
</script>

<style scoped> 
.alert{
    background: rgba(218, 165, 32, 0.258)   ;
    min-width: 420px;
    position: absolute;
    padding: 5px 0;
    padding-left: 20px;
    right: 0;
    top: 65px;
    border-radius: 4px;
    border-left: 8px solid goldenrod;
    overflow: hidden;
    opacity: 0;
    pointer-events: none;
  }
  .alert.showAlert{
    opacity: 1;
    pointer-events: auto;
  }
  .alert.show{
    animation: show_slide 1s ease forwards;
    -webkit-animation: show_slide 1s ease forwards;
}
  @keyframes show_slide {
    0%{
      transform: translateX(100%);
    }
    40%{
      transform: translateX(-10%);
    }
    80%{
      transform: translateX(0%);
    }
    100%{
      transform: translateX(-10px);
    }
  }
  .alert.hide{
    animation: hide_slide 1.5s ease forwards;
    -webkit-animation: hide_slide 1.5s ease forwards;
}
  @keyframes hide_slide {
    0%{
      transform: translateX(-10px);
    }
    40%{
      transform: translateX(0%);
    }
    80%{
      transform: translateX(-10%);
    }
    100%{
      transform: translateX(100%);
    }
  }
  .alert .uil-exclamation{
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: goldenrod;
    font-size: 16px;
  }
  .alert .msg{
    padding: 0 20px;
    font-size: 14px;
    color: goldenrod;
  }
  .alert .close-btn{
    position: absolute;
    right: 0px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(218, 165, 32, 0.258) 
    ;
    padding: 0 18px;
    cursor: pointer;
  }
  .alert .close-btn:hover{
    background: rgba(218, 165, 32, 0.258)  ;
  }
  .alert .close-btn .uil{
    color: goldenrod;
    font-size: 22px;
    line-height: 40px;
  }
</style>