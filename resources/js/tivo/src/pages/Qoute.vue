<template>
  <div class="card">
    <div class="card-header pb-20">
      <form @submit.prevent="">
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label">First name</label>
            <input type="text" id="name" placeholder="First name" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Last name</label>
            <input type="text" id="name" placeholder="Last name" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Email</label>
            <input class="form-control" id="exampleFormControlInput1" type="email" placeholder="name@example.com">
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label">Call Number</label>
            <input type="text" class="form-control" placeholder="Call Number">
          </div>
          <div class="col-md-4">
            <label class="form-label">Backup Phone number</label>
            <input type="text" class="form-control" placeholder="Backup Phone number">
          </div>
          <div class="col-md-4">
            <label>Starting date</label>
            <input class="datepicker-here form-control" type="date" data-language="en">
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label" for="validationTextarea">Notes</label>
              <textarea class="form-control" placeholder="Notes" required=""></textarea>
              <div class="invalid-feedback">Please enter a message in the textarea.</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label" for="validationTextarea">Charge Notes</label>
              <textarea class="form-control" placeholder="Charge Notes" required=""></textarea>
              <div class="invalid-feedback">Please enter a message in the textarea.</div>
            </div>
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">Product*</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">1</option>
              <option selected="2" value="2">2</option>
              <option selected="3" value="3">3</option>
              <option selected="4" value="4">4</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">Shiping*</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">1</option>
              <option selected="2" value="2">2</option>
              <option selected="3" value="3">3</option>
              <option selected="4" value="4">4</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">Shiping*</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">1</option>
              <option selected="2" value="2">2</option>
              <option selected="3" value="3">3</option>
              <option selected="4" value="4">4</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">Payment Method</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">200</option>
              <option selected="2" value="2">300</option>
              <option selected="3" value="3">400</option>
              <option selected="4" value="4">500</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-4">
            <label class="form-label">Authorization Transaction Id*</label>
            <input type="text" id="name" placeholder="Transaction ID" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sales Order Channel*</label>
            <input type="text" id="name" placeholder=" Sales Order Channel#" class="form-control">
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label">Price*</label>
            <input type="text" id="name" placeholder="Price" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Still Owes</label>
            <input type="text" id="name" placeholder="Still Owes" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Tax*</label>
            <input type="text" id="name" placeholder="0.00" class="form-control">
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-6">
            <label class="form-label">Address*</label>
            <input type="text" id="name" placeholder="Address" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label" for="validationCustom04">Country</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">India</option>
              <option selected="2" value="2">UK</option>
              <option selected="3" value="3">UAE</option>
              <option selected="4" value="4">USE</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-3">
            <label class="form-label" for="validationCustom04">Dealer*</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="Ram">Ram</option>
              <option selected="2" value="Shyam">Shyam</option>
              <option selected="3" value="wish">wish</option>
              <option selected="4" value="zafer">zafer</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label">City*</label>
            <input type="text" id="city" placeholder="City" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">State</label>
            <select class="form-select" id="validationCustom04">
              <option selected="1" value="1">Madhya Pradesh</option>
              <option selected="2" value="2">Kerla</option>
              <option selected="3" value="3">Goa</option>
              <option selected="4" value="4">Delhi</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-4">
            <label class="form-label">ZipCode*</label>
            <input type="text" id="name" placeholder="ZipCode" class="form-control">
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-4">
            <label class="form-label">Business Name*</label>
            <input type="text" id="business" placeholder="Business Name" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label" for="validationCustom04">Referral Code</label>
            <select class="form-select" id="validationCustom04">
              <option selected="" value="1">22553</option>
              <option selected="" value="2">87546</option>
              <option selected="" value="3">98765</option>
              <option selected="" value="4">34567</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
            <!-- <div class="invalid-feedback" v-if="inputs.state.errorMessage.length">{{ inputs.state.errorMessage }}</div>
          <div class="valid-feedback" v-else>Looks Good!</div> -->
          </div>
          <div class="col-md-4">
            <label class="form-label">How did your hear about us</label>
            <select class="form-select" id="validationCustom04">
              <option selected="" value="1">simply</option>
              <option selected="" value="2">printing</option>
              <option selected="" value="3">typesetting</option>
              <option selected="" value="4">standard</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-3">
            <label class="form-label">What are they buying?</label>
            <input type="text" id="buying" placeholder="" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Marital status</label>
            <select class="form-select" id="validationCustom04">
              <option selected="" value="1">Yes</option>
              <option selected="" value="2">No</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">What other hobbies do they have?</label>
            <input type="text" id="buying" placeholder="" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Gender</label>
            <select class="form-select" id="validationCustom04">
              <option selected="" value="1">Male</option>
              <option selected="" value="2">Female</option>
              <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
            </select>
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label" for="validationTextarea">Customer Note</label>
              <textarea class="form-control" placeholder="Customer Note" required=""></textarea>
              <div class="invalid-feedback">Please enter a message in the textarea.</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label" for="validationTextarea">Shoping Notes</label>
              <textarea class="form-control" placeholder="Shoping Notes" required=""></textarea>
              <div class="invalid-feedback">Please enter a message in the textarea.</div>
            </div>
          </div>
        </div>
        <div class="row col-md-12 label-bottom">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Select oreder type</label>
              <select class="form-select" id="validationCustom04">
                <option selected="" value="1">fsdfsd</option>
                <option selected="" value="2">fsdfdufwu</option>
                <!-- <option v-for="(value, index) in optionValues" :value="value" :key="value + index">{{ value }}</option> -->
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-check">
              <div class="checkbox p-0">
                <input class="form-check-input" id="invalidCheck2" type="checkbox" required="">
                <label class="form-check-label" for="invalidCheck2">Synchrony - Need to change</label>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="col-12 d-flex justify-content-center">
        <button class="btn btn-primary" type="submit">NOT A SALE, JUST A QOUTE </button>
        <button class="btn btn-primary sale" type="submit">SALE</button>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      vele: {
        checked: '',
        radio: ''
      },

      rajehs: "",
      datas: [],
      error: [],
      errors: {
        dateOfBirth: "",
        email: "",
        mobileNo: "",
        name: "",
      },
      retr: []
    };
  },
  methods: {

    getFormData() {
      let token = localStorage.getItem("token");
      axios
        .get(`http://localhost:8000/api/form-data?obect_type_id=1`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          this.datas = res.data.result;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getFormDataW(id) {
      let token = localStorage.getItem("token");
      // console.log(token);
      let promise = axios.get(`http://localhost:8000/api/lead-form/${id}`, {
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
      });
      const consumer = () => {
        promise
          .then((d) => {

            console.log("hhhh1111", d.data.result.gender);
            this.vele.radio = d.data.result.gender
            // let data = {};
            // this.retr = d.data.result;
            // console.log(retr);
            let retrnData = d.data.result;
            for (let key in retrnData) {
              if (retrnData.hasOwnProperty(key)) {
                const idInput = document.getElementById(key);
                const value = retrnData[key];
                console.log(value)
                if (idInput !== null) {
                  document.getElementById(key).value = value;
                  // console.log('ID field exists');
                  // Perform further actions or validations
                }
                // const value = retrnData[key];
                // console.log(`${key}: ${value}`);
              }

            }
            // naveen.forEach((element,key) => {  
            //   var id = element;
            //   console.log('eeee',key);
            // const idInput = document.getElementById('idInput');

            // var checkw = document.getElementById(id).value = id;
            // if (checkw.getAttribute("type") === "checkbox") {
            //   if (checkw.checked) {
            //     data[id] = true;
            //   } else {
            //     data[id] = false;
            //   }
            // } else {
            //   data[id] = document.getElementById(id).value;
            // }
            // });
          })
          .catch((e) => {
            console.log('dddddddddddddddrrrrrrrrrrr');
            console.log("ttttttttt", e);
          });
      };

      consumer();
    },
    formSubmit() {
      let data = {};
      this.datas.forEach((element) => {
        var id = element["input_name"];
        var checkw = document.getElementById(id);
        if (checkw.getAttribute("type") === "checkbox") {
          if (checkw.checked) {
            data[id] = true;
          } else {
            data[id] = false;
          }
        } else {
          data[id] = document.getElementById(id).value;
        }
      });
      console.log(data);
      return
      let token = localStorage.getItem("token");
      // console.log(token);
      let promise = axios.post("http://localhost:8000/api/lead-form", data, {
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
      });
      const consumer = () => {
        promise
          .then((d) => {
            // console.log("hhhh", d);
            this.$router.replace("/lead-data");
          })
          .catch((e) => {
            console.log("ttttttttt", e.response.data.errors);
            this.error = e.response.data.errors;
          });
      };
      consumer();
    },
  },
  mounted() {
    this.getFormData();
    const url = new URL(window.location.href);
    const id = url.pathname.split('/').pop();
    const isNum = /^\d+$/.test(id);
    if (isNum) {
      this.getFormDataW(id);
    }
  },
};
</script>
<style>
.container {
  background: #ffff;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(8, 21, 66, 0.05);
}

.uuiuiuiu {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.form-label {
  /* font-size: 20px; */
  font-weight: 500;
}

.form-check {
  margin-top: 30px;
  font-size: 20px;
}

.sale {
  margin-left: 15px;
}

.label-bottom {
  margin-bottom: 12px;
}

.btn {
  padding: 0.6rem 1.75rem;
  font-weight: 600;
  border-radius: 7px !important;
}
</style>