<template>
<div class="wrapper" :class="{ 'nav-open': true }">
    <SideBarComponent></SideBarComponent>
    <div class="main-panel">
        <NavBarComponent></NavBarComponent>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</div>
</template>

<script>

import NavBarComponent from './NavBarComponent.vue';
import SideBarComponent from './SideBarComponent.vue';

export default {
    components: {
        NavBarComponent,
        SideBarComponent
    },
    data: () => ({
        isuccess:false,
        snackbarcolor:"green",
        snackbaricon:"done",
        events:[],
        snackbar: false,
        timeout: 6000,
        text: 'Hello, I\'m a snackbar'
    }),
    watch:{
        isuccess( val ){
            this.snackbarcolor = (val)?"green":"red";
            this.snackbaricon = (val)?"done":"error";
        }
    },
    
    methods:{
        fetchEvents(){
            axios.get('/get-event' )
            .then((response) => {
                this.events = response.data.data;
                this.isuccess = true;
            });
        },
        saveEvent( payload ){
            
            let _self = this;
            // /save-event
            axios.post('/save-event',payload )
            .then((response) => {
                
                this.text = response.data.status;
                this.snackbar = true;
                _self.fetchEvents()
            });
        }
    },
    created(){
        // this.fetchEvents();
    }
}
</script>

<style lang="scss" scoped>
  .md-app {
    height: 100vh;
    max-height: 100vh   ;
    border: 1px solid rgba(#000, .12);
  }

   // Demo purposes only
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }
</style>  

