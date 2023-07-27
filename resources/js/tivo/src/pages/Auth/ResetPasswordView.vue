<template>
    <div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-12 p-0">
          <div class="login-card">
            <div>
              <div>
                <a class="logo">
                  <img
                    class="img-fluid"
                   src="../../assets/images/logo/medi_logo.png"
                    alt="login page"
                  />
                </a>
              </div>
              <div class="login-main">
                <form class="theme-form" @submit.prevent="">
                  <h4 class="text-center">Sign in to account</h4>
                  <p class="text-center">Enter your email & password to login</p>
                  <span class="text-danger">{{ errors ? errors : "" }}</span>
                  <div class="form-group">
                      <label class="col-form-label">Password</label>
                      <div class="form-input position-relative">
                        <input
                          v-model="password"
                          :type="type"
                          class="form-control"
                          placeholder=""
                          required
                        />
                        <!-- <span class="text-danger">{{
                          errors.password ? errors.password[0] : ""
                        }}</span> -->
                        <div class="show-hide">
                          <span class="show" @click="showPassword"> </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label">Confirm Password</label>
                      <div class="form-input position-relative">
                        <input
                          v-model="c_password"
                          :type="type"
                          class="form-control"
                          placeholder=""
                          required
                        />
                        <!-- <span class="text-danger">{{
                          errors.password ? errors.password[0] : ""
                        }}</span> -->
                        <div class="show-hide">
                          <span class="show" @click="showPassword"> </span>
                        </div>
                      </div>
                    </div>
                 
                  <div class="form-group mb-0">
                   
                    <div class="text-end mt-3">
                      <button
                        class="btn btn-primary btn-block w-100"
                        type="submit"
                        @click="doLogin"
                      >
                        Reset your password
                      </button>
                    </div>
                  </div>
  
                  <p class="mt-4 mb-0 text-center">
                    Don't have account?<router-link
                      class="ms-2"
                      to="/auth/login"
                      >Login</router-link
                    >
                  </p>
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
  export default {
    data() {
      return {
        password: "",
        c_password: "",
      };
    },
  
    methods: {
      // doLogin() {
      //   let data = {
      //     email: this.email
      //   };
      //   let token = localStorage.getItem("token");
      //   let promise = axios.post("http://localhost:8000/api/login", data, {
      //     headers: {
      //       "Content-Type": "application/json",
      //       Authorization: `Bearer ${token}`,
      //     },
      //   });
  
      //   const consumer = () => {
      //     promise
      //       .then((d) => {
      //         // console.log("hhhh", d);
      //         this.$router.replace("/");
      //       })
      //       .catch((e) => {
      //         console.log("ttttttttt", e.response.data.message);
      //         this.errors = e.response.data.message;
      //       });
      //   };
  
      //   consumer();
      // },
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