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
                <h4 class="text-center">Sign up to account</h4>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label class="col-form-label">First Name</label>
                      <input
                        v-model="values.firstName"
                        class="form-control"
                        type="text"
                        placeholder=""
                        
                      />
                      <span class="text-danger">{{
                        errors.firstName ? errors.firstName[0] : ""
                      }}</span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label class="col-form-label">Last Name</label>
                      <input
                        v-model="values.lastName"
                        class="form-control"
                        type="text"
                        placeholder=""
                       
                      />
                      <span class="text-danger">{{
                        errors.lastName ? errors.lastName[0] : ""
                      }}</span>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-form-label">Mobile No.</label>
                  <input
                    v-model="values.mobileNo"
                    class="form-control"
                    type="number"
                    placeholder=""
                   
                  />
                  <span class="text-danger">{{
                    errors.mobileNo ? errors.mobileNo[0] : ""
                  }}</span>
                </div>
                <div class="form-group">
                  <label class="col-form-label">Email Address</label>
                  <input
                    v-model="values.email"
                    class="form-control"
                    type="email"
                    placeholder=""
                   
                  />
                  <span class="text-danger">{{
                    errors.email ? errors.email[0] : ""
                  }}</span>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label class="col-form-label">Password</label>
                      <div class="form-input position-relative">
                        <input
                          v-model="values.password"
                          :type="type"
                          class="form-control"
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
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label class="col-form-label">Confirm Password</label>
                      <div class="form-input position-relative">
                        <input
                          v-model="values.c_password"
                          :type="type"
                          class="form-control"
                          placeholder=""
                        />
                        <span class="text-danger">{{
                          errors.c_password ? errors.c_password[0] : ""
                        }}</span>
                        <div class="show-hide">
                          <span class="show" @click="showPassword"> </span>
                        </div>
                      </div>
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
                      Sign up
                    </button>
                  </div>
                </div>

                <p class="mt-4 mb-0 text-center">
                  Already have account?<router-link
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
  import config from "../../config";
import axios from "axios";
export default {
  data() {
    return {
      type: "password",
      values:{
        firstName: "",
      lastName: "",
      mobileNo: "",
      email: "",
      password: "",
      c_password: "",
      },
      errors: {
        firstName: "",
        lastName: "",
        mobileNo: "",
        email: "",
        password: "",
        c_password: "",
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
      if(this.values !== ""){
        let data = {
        firstName: this.values.firstName,
        lastName: this.values.lastName,
        mobileNo: this.values.mobileNo,
        email: this.values.email,
        password: this.values.password,
        c_password: this.values.c_password,
      };
      let promise = axios.post(`${config.apiUrl}/api/register`, data);
      const consumer = () => {
        promise
          .then((d) => {
            // console.log('hhhh',d);
            this.$router.replace("/auth/login");
            // localStorage.setItem("token", d.data.result.token);
          })
          .catch((e) => {
            // console.log("ttttttttt", e.response.data.errors);
            this.errors = e.response.data.errors;
          });
      };
      consumer();
      }
    
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