<template>
  <div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-12 p-0">
        <div class="login-card">
          <div>
            <div>
              <a class="logo" >
                <img  class="img-fluid" src="../../assets/images/logo/medi_logo.png" alt="login page"
                />
              </a>
            </div>
            <div class="login-main">
              <form class="theme-form" @submit.prevent="">
                <h4 class="text-center">Sign in to account</h4>
                <p class="text-center">Enter your email & password to login</p>
               
                <div class="form-group">
                  <label class="col-form-label">Email Address</label>
                  <input
                    v-model="email"
                    class="form-control"
                    type="email"
                    placeholder=""
                  />
                  <span class="text-danger">{{
                        errors.email ? errors.email[0] : ""
                      }}</span>
                </div>
                <div class="form-group">
                  <label class="col-form-label">Password</label>
                  <div class="form-input position-relative">
                    <input
                      v-model="password"
                      :type="type"
                      class="form-control"
                      name="login[password]"
                      placeholder=""
                    />
                    <span class="text-danger">{{
                        errors.password ? errors.password[0] : ""
                      }}</span>
                    <div class="show-hide">
                      <span class="show" @click="showPassword"> </span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-0">
                  <a class="link"
                    ><router-link to="/auth/forgot"
                      >Forgot password?</router-link
                    ></a
                  >
                  <div class="text-end mt-3">
                    <button
                      class="btn btn-primary btn-block w-100"
                      type="submit"
                      @click="doLogin"
                    >
                      Sign in
                    </button>
                    
                    
                  </div>
                </div>

                <!-- <p class="mt-4 mb-0 text-center">
                  Don't have account?<router-link
                    class="ms-2"
                    to="/auth/register"
                    >Create Account</router-link
                  >
                </p> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../config";
export default {
  data() {
    return {
      type: "password",
      email: "",
      password: "",
      errors:{
        email:'',
        password:''
      },
    };
  },

  methods: {
    showPassword: function () {
      if (this.type === "password") {
        this.type = "text";
      } else {
        this.type = "password";
      }
    },
    doLogin() {
      let data = {
        email: this.email,
        password: this.password,
      };
       let token = localStorage.getItem("token");
      // console.log(token);
      let promise = axios.post(`${config.apiUrl}/api/login`, data, {
        headers: {
          "Content-Type": "application/json",
           Authorization: `Bearer ${token}`,
        },
      });

      const consumer = () => {
        promise
          .then((d) => {
             console.log("hhhh", d);
             localStorage.setItem("token", d.data.result.token);
            localStorage.setItem('isAuthent','true')
            this.$router.replace("/");
          })
          .catch((e) => {
            //  console.log("ttttttttt", e.response.data.errors);
             this.errors = e.response.data.errors;
          });
      };

      consumer();
    },
  },
};
</script>

<style scoped>
.login-main {
  width: 45%;
  margin: 0 auto;
}
.img-fluid{
  width: 84px;
}
</style>