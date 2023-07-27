<template>
    <div class="header-wrapper row m-0">
           <div class="header-logo-wrapper col-auto p-0">
               <sidebar/>
           </div>
            <div class="left-header col horizontal-wrapper ps-0">
              
           </div>
            <div class="nav-right col-6 pull-right right-header p-0">
            <ul class="nav-menus">
                <!-- <li> 
               <searchView/>
              </li> -->
              <li class="serchinput">
                <searchInput/>
              </li>
               <li>
                <modeView/>
              </li>
              <!-- <li>
                <i class="fa fa-sign-out" @click="userLogOUt()"></i>
              </li> -->
              <li class="maximize">
                    <maximizeView/>
                </li>
                <li class="profile-nav onhover-dropdown">
                  <div class="account-user"><vue-feather type="user"></vue-feather></div>
                  <ul class="profile-dropdown onhover-show-div">
                  <!-- <li><router-link to="/users/profile"> <vue-feather type="user"></vue-feather><span>Account</span></router-link></li> -->
                  <!-- <li><router-link to="/email/email-inbox"><vue-feather type="mail"></vue-feather><span>Inbox</span></router-link></li> -->
                  <!-- <li><router-link to="/users/edit"><vue-feather type="settings"></vue-feather><span>Settings</span></router-link></li> -->
                  <li><a @click="userLogOUt()"> <vue-feather type="log-in"></vue-feather><span>Log Out</span></a></li>
                </ul>
                   </li>
            </ul>
            </div>
    </div>
</template>
<script>
import searchInput from "./searchInput.vue"
import sidebar from "./sidebarView.vue"
import searchView from "./searchView.vue"
import modeView from "./modeView.vue"
import maximizeView from "./maximizeView.vue"

export default {
    components:{
        sidebar,
        searchView,
        modeView,
        maximizeView,
        searchInput
    },
     data () {
      return {
        filtered: false,
      };
    },
      methods: {
     collapseFilter() {
        this.filtered = !this.filtered;
      },
      userLogOUt(){
        if (confirm("Do you really want to Logout?")) {
        localStorage.removeItem('isAuthent')
        localStorage.removeItem('token')
        this.$router.push('/auth/login')
        }
        
      }
      }
}
</script>