<template>
    <!-- <breadCrumbs v-if="EditIds == null && oneValue != 0" :title="'Create Quote'"/>
    <breadCrumbs v-else-if="EditIds != null && oneValue == 0"  :title="'Create Quote'"/>
    <breadCrumbs v-if="EditIds != null && oneValue != 0" :main="'Quote'" :title="'Update Quote'"/> -->
    <div class="container">
        <!-- <div class="create-lead" v-if="EditIds == null">
            <span class="lead">Create Quote</span>
        </div>
        <div class="create-lead" v-if="EditIds !== null">
            <span class="lead">Update Quote</span>
        </div> -->
        <form @submit.prevent="">
            <div class="card">
                <div class="card-body formPaddingTab" >
                    <div class="row">
                        <!-- <ViewLeadFormOption :leadId="oneValue == 0 ? lead_Id : quote_lead_Id" v-if="oneValue == 0 ||  quote_lead_Id !=='NA' && quote_lead_Id !='' && lead_Id != ''"/> -->
                        <div v-for="data in datas" :class="data.field_type == 'text' || data.field_type == 'dropdownSelect'   || data.field_type == 'time' ||data.field_type == 'date' || data.field_type == 'number'  ? 'col-md-12 labelMargindown '   :  data.field_type == 'textarea' ? 'col-md-12 labelMargindown ' : ''" >
                            <input type="hidden" :value="leadId" />
                            <div v-if="data.field_type == 'text'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h5">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <input
                                        :type="data.field_type"
                                        class="form-control"
                                        :id="data.input_name"
                                        aria-describedby="emailHelp"
                                        :placeholder="data.label_name"


                                    />
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div v-if="data.field_type == 'dropdownSelect'" >
                            <div v-if="data.label_name == 'Category'" >
                                <div class="d-flex">
                                       <div>
                                           <label :for="data.input_name">{{
                                               data.label_name
                                           }}</label>
                                       </div>
                                       <div>
                                           <span class="text-danger h5">
                                               {{
                                                   data.validation_rules
                                                       .is_required
                                                       ? "*"
                                                       : ""
                                               }}
                                           </span>
                                       </div>
                                   </div>
                                <select
                                       class="form-select dropDownSize"
                                       aria-label="Default select example"
                                       :id="data.input_name"  >
                                       <option value="">
                                           {{ data.label_description }}
                                       </option>
                                       <!-- <option
                                           v-for="item in data.field_values"
                                           :value="item.value"
                                       >
                                           {{ item.value }}
                                       </option> -->
                                       <option
                                           v-for="item in parentIdValue"
                                           :value="item.id "
                                       >
                                       {{ console.log(parentIdValue,"aaaaaaaaaa") }}
                                           {{ item.name}}
                                       </option>
                                   </select>
                            </div>
                               <div v-if="data.label_name != 'Category'">
                                   <div class="d-flex">
                                       <div>
                                           <label :for="data.input_name">{{
                                               data.label_name
                                           }}</label>
                                       </div>
                                       <div>
                                           <span class="text-danger h5">
                                               {{
                                                   data.validation_rules
                                                       .is_required
                                                       ? "*"
                                                       : ""
                                               }}
                                           </span>
                                       </div>
                                   </div>
                                   <div >
                                   <select
                                       class="form-select dropDownSize"
                                       aria-label="Default select example"
                                       :id="data.input_name"  >
                                       <option value="">
                                           {{ data.label_description }}
                                       </option>
                                       <option
                                           v-for="item in data.field_values"
                                           :value="item.value"
                                       >
                                           {{ item.value }}
                                       </option>
                                       <!-- <option
                                           v-for="item in parentIdValue"
                                           :value="item.id "
                                       >
                                       {{ console.log(parentIdValue,"aaaaaaaaaa") }}
                                           {{ item.name}}
                                       </option> -->
                                   </select>
                                </div>
                                   <span
                                       class="text-danger"
                                       v-for="(err, index) in error"
                                   >
                                       <span
                                           class="text-danger"
                                           v-if="index == data.input_name"
                                           v-for="r in err"
                                           >{{ r }}</span
                                       >
                                   </span>
                               </div>
                           </div>
                            <div v-if="data.field_type == 'textarea'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h4">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <textarea
                                        :placeholder="data.label_description"
                                        class="form-control textAeraSize"
                                        :id="data.input_name"
                                        rows="3"


                                    ></textarea>
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div v-if="data.field_type == 'MultiLineText'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h4">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <textarea
                                        :placeholder="data.label_description"
                                        class="form-control"
                                        :id="data.input_name"
                                        rows="3"


                                    ></textarea>
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div v-if="data.field_type == 'number'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h5">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <input
                                        :type="data.field_type"
                                        class="form-control"
                                        :id="data.input_name"
                                        aria-describedby="emailHelp"
                                        :placeholder="data.label_name"


                                    />
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div v-if="data.field_type == 'date'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h5">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <input
                                        :type="data.field_type"
                                        class="form-control"
                                        :id="data.input_name"
                                        aria-describedby="emailHelp"
                                        :placeholder="data.label_name"


                                    />
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div v-if="data.field_type == 'time'">
                                <div >
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <span class="text-danger h4">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <select
                                        class="form-select"
                                        aria-label="Default select example"
                                        :id="data.input_name"


                                    >
                                        <option value="">
                                            {{ data.label_description }}
                                        </option>
                                        <option
                                            v-for="time in timeList"
                                            :value="time"
                                        >
                                            {{ time }}
                                        </option>
                                    </select>
                                    <span
                                        class="text-danger"
                                        v-for="(err, index) in error"
                                    >
                                        <span
                                            class="text-danger"
                                            v-if="index == data.input_name"
                                            v-for="r in err"
                                            >{{ r }}</span
                                        >
                                    </span>
                                </div>
                            </div>
                            <div 
                           
                               
                                v-if="data.field_type == 'checkbox'"
                            >
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        :type="data.field_type"
                                        :id="data.input_name"
                                        name="myCheck"


                                    />
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                            <div></div>
                                        </div>
                                        <div>
                                            <span class="text-danger h4">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div

                                v-if="data.field_type == 'radio'"
                            >
                                <div class="d-flex">
                                    <div class="d-flex">
                                        <div>
                                            <label :for="data.input_name">{{
                                                data.label_name
                                            }}</label>
                                        </div>
                                        <div>
                                            <p class="text-danger">
                                                {{
                                                    data.validation_rules
                                                        .is_required
                                                        ? "*"
                                                        : ""
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        v-for="(
                                            item, index
                                        ) in data.field_values"
                                        :key="index"
                                        class="d-flex mx-2"
                                    >
                                        <div>
                                            <!-- {{item.value}} -->
                                            <input
                                                class="form-check-input myRadio"
                                                type="radio"
                                                :name="data.input_name"


                                                :id="data.input_name"
                                                :value="item.value"
                                            />
                                        </div>
                                        <div class="mx-2">
                                            <label for="exampleInputEmail1">{{
                                                item.value
                                            }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="col-12 save-lead d-flex justify-content-center">
                            <button
                                v-if="EditIds == null && oneValue != 0"
                                type="submit"
                                class="btn btn-primary"
                                @click="formSubmit()"
                            >
                                Save Product Details
                            </button>

                            <!-- <button
                                v-else-if="EditIds != null && oneValue == 0"
                                type="submit"
                                class="btn btn-primary"
                                @click="formSubmit()"
                            >
                                Save Product Deatails
                            </button> -->
                            <button
                                v-if="EditIds != null && oneValue != 0"
                                type="submit"
                                class="btn btn-primary radius"
                                @click="formUpdate()"
                            >
                                Update Product Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import logoViewVue from "../../layout/sidebar/logoView.vue";
import config from "../../config";
import axios from 'axios'
import ViewLeadFormOption from "../Lead/ViewLeadFormOption.vue"
import breadCrumbs from "../../layout/breadCrumbs.vue"
export default {
    components:{
        ViewLeadFormOption,
        breadCrumbs
    },
    data() {
        return {
            lead_Id:'',
            quote_lead_Id:'',

            // vele: {
            //   checke: null,
            //   radio: "",
            // },
            textData: [],
            parentIdValue:[],
            dropdownData: [],
            radioData: [],
            checkBoxData: [],
            textAreaData: [],
            timeData: [],
            numberData: [],
            timeList: [
                "00:00",
                "00:15",
                "00:30",
                "00:45",
                "01:00",
                "01:15",
                "01:30",
                "01:45",
                "02:00",
                "02:15",
                "02:30",
                "02:45",
                "03:00",
                "03:15",
                "03:30",
                "03:45",
                "04:00",
                "04:15",
                "04:30",
                "04:45",
                "05:00",
                "05:15",
                "05:30",
                "05:45",
                "06:00",
                "06:15",
                "06:30",
                "06:45",
                "07:00",
                "07:15",
                "07:30",
                "07:45",
                "08:00",
                "08:15",
                "08:30",
                "08:45",
                "09:00",
                "09:15",
                "09:30",
                "09:45",
                "10:00",
                "10:15",
                "10:30",
                "10:45",
                "11:00",
                "11:15",
                "11:30",
                "11:45",
                "12:00",
                "12:15",
                "12:30",
                "12:45",
                "13:00",
                "13:15",
                "13:30",
                "13:45",
                "14:00",
                "14:15",
                "14:30",
                "14:45",
                "15:00",
                "15:15",
                "15:30",
                "15:45",
                "16:00",
                "16:15",
                "16:30",
                "16:45",
                "17:00",
                "17:15",
                "17:30",
                "17:45",
                "18:00",
                "18:15",
                "18:30",
                "18:45",
                "19:00",
                "19:15",
                "19:30",
                "19:45",
                "20:00",
                "20:15",
                "20:30",
                "20:45",
                "21:00",
                "21:15",
                "21:30",
                "21:45",
                "22:00",
                "22:15",
                "22:30",
                "22:45",
                "23:00",
                "23:15",
                "23:30",
            ],
            EditIds: null,
            oneValue:null,
            leadId: null,
            rajehs: "",
            datas: [],
            error: [],
            objectId:null,
            errors: {
                dateOfBirth: "",
                email: "",
                mobileNo: "",
                name: "",
            },
            retr: [],
            options: ["Option 1", "Option 2", "Option 3"],
            selectedOption: null,
        };
    },
    watch: {
    error: function(newVal, oldVal) { // watch it
        //console.log('Prop changed: ', newVal, ' | was: ', oldVal)
        const errors = Object.keys(newVal)
        if(errors.length > 0 && document.getElementById(errors[0])) {
            document.getElementById(errors[0]).focus();

        }
    }
    },

    methods: {
        removePrefix(data){
            if (data) {
                return data.split('_')[1];
            }
            return true;
        },
        getFormData() {
            let token = localStorage.getItem("token");
            axios
            .get(`${config.apiUrl}/api/form-data?obect_type_id=4&group_id=15`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    this.objectId = res.data.result[0].object_id
                    // console.log(objectId,'obejctid')s
                    this.datas = res.data.result;
                    // console.log(this.datas,'datasjhhjhjhj')


                    let dataArray = res.data.result;
                    dataArray.filter((d) => {
                         if (d.field_type == "text") {
                            this.textData.push(d);
                         }
                        if (d.field_type == "dropdownSelect") {
                            this.dropdownData.push(d);
                        }
                        if (d.field_type == "radio") {
                            this.radioData.push(d);
                        }
                        if (d.field_type == "checkbox") {
                            this.checkBoxData.push(d);
                        }
                        if (d.field_type == "textarea") {
                            this.textAreaData.push(d);
                        }
                        if (d.field_type == "time") {
                            this.timeData.push(d);
                        }
                        if (d.field_type == "number") {
                            this.numberData.push(d);
                        }
                    });
                    const url = new URL(window.location.href);
                        const id = url.pathname.split("/").pop();
                        const lead_id_split = id.split("-");
                        let ur = lead_id_split[0] ? lead_id_split[0] : id;
                        const isNum = /^\d+$/.test(ur);
                        console.log("hello", ur);
                        if (isNum) {
                            this.leadId = ur;
                            this.lead_Id = ur;
                            this.oneValue = lead_id_split[1]
                            this.EditIds = ur;
                            lead_id_split[1] ? '' :  this.getFormDataW(ur);
                        }

                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getFormDataW(id) {
            let token = localStorage.getItem("token");
            let promise = axios.get(`${config.apiUrl}/api/product-form/${id}`, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            }).then((d) => {
                     this.quote_lead_Id = d.data.result[0].lead_id ? d.data.result[0].lead_id : 'NA' ;
                    //  console.log("lead_Id",lead_Id)
                console.log("ddd",d)
                        let retrnData = d.data.result[0];;
                        for (let key in retrnData) {

                            if (retrnData.hasOwnProperty(key)) {
                                var val = this.removePrefix(key);
                                const idInput = document.getElementById(val);
                                const value = retrnData[key];
                                if (idInput !== null) {
                                    var check =
                                        document.getElementsByName("myCheck");
                                    if (value == "1") {
                                        idInput.checked = true;
                                    }
                                    if (value) {
                                        var radioButtons =
                                            document.getElementsByName(
                                                "myRadio"
                                            );

                                        for (
                                            var i = 0;
                                            i < radioButtons.length;
                                            i++
                                        ) {
                                            if (
                                                radioButtons[i].value === value
                                            ) {
                                                radioButtons[i].checked = true;
                                                break;
                                            }
                                        }
                                        if (value !== null) {
                                            document.getElementById(val).value =
                                                value;
                                        }
                                    } else {
                                        if (value !== null) {
                                            document.getElementById(val).value =
                                                value;
                                        }
                                    }
                                }
                            }
                        }
                    })
                    .catch((e) => {
                        console.log("Error", e);
                    });

        },
        formSubmit() {
            let blacmck = [];
            function onlyUnique(value, index, array) {
                return array.indexOf(value) === index;
            }
            this.datas.forEach((ele) => {
                blacmck.push(ele['group_id'])
            })
            var unique = blacmck.filter(onlyUnique);
            let entry = [];
            unique.forEach((group, index) => {
                let naveen = {};
                let rrr =
                    {
                        "groupId": group,
                        "data": naveen
                    }

                entry.push(rrr)
                this.datas.forEach((ele) => {
                    var id = ele["input_name"];
                    var checkw = document.getElementById(id);

                    if (ele['group_id'] === group) {

                        if(group == 4)
                        {
                            naveen['lead_id'] = this.leadId
                        }

                        var id = ele["input_name"];
                        var checkw = document.getElementById(id);
                        if (checkw != null) {
                        naveen[id] = checkw.value
                        var radioButtons = document.getElementsByName(id);
                        var selectedValue = null;
                        for (var i = 0; i < radioButtons.length; i++) {
                            if (radioButtons[i].checked) {
                                selectedValue = radioButtons[i].value;
                                break;
                            }
                        }
                        if (checkw.getAttribute("type") === "text") {
                            naveen[id] = checkw.value;
                        }
                        if (checkw.getAttribute("type") === "checkbox") {
                            if (checkw.checked) {
                                naveen[id] = true;
                            } else {
                                naveen[id] = false;
                            }
                        }
                        if (checkw.getAttribute("type") === "radio") {
                            if (selectedValue) {
                                naveen[id] = selectedValue;
                            }
                            else{
                                naveen[id] = null
            }
                        }
                    }
                    }
                });
            })



            let token = localStorage.getItem("token");
            let promise = axios.post(config.apiUrl + "/api/product-form", entry, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });
            const consumer = () => {
                promise
                    .then((d) => {

            console.log('nvaeenn n hbuu',d);
                        this.$router.replace("/product-data");
                        this.getFormData();
                    })
                    .catch((e) => {
                        this.error = e.response.data.errors;
                    });
            };
            consumer();
        },
        formUpdate() {
            let blacmck = [];
            function onlyUnique(value, index, array) {
                return array.indexOf(value) === index;
            }
            this.datas.forEach((ele) => {
                blacmck.push(ele['group_id'])
            })
            var unique = blacmck.filter(onlyUnique);
            let entry = [];
            unique.forEach((group, index) => {
                let naveen = {};
                let rrr =
                    {
                        "groupId": group,
                        "data": naveen
                    }

                entry.push(rrr)
                this.datas.forEach((ele) => {
                    var id = ele["input_name"];
                    var checkw = document.getElementById(id);

                    if (ele['group_id'] === group) {

                        var id = ele["input_name"];
                        var checkw = document.getElementById(id);
                        if (checkw != null) {
                        naveen[id] = checkw.value
                        var radioButtons = document.getElementsByName(id);
                        var selectedValue = null;
                        for (var i = 0; i < radioButtons.length; i++) {
                            if (radioButtons[i].checked) {
                                selectedValue = radioButtons[i].value;
                                break;
                            }
                        }
                        if (checkw.getAttribute("type") === "text") {
                            naveen[id] = checkw.value;
                        }
                        if (checkw.getAttribute("type") === "checkbox") {
                            if (checkw.checked) {
                                naveen[id] = true;
                            } else {
                                naveen[id] = false;
                            }
                        }
                        if (checkw.getAttribute("type") === "radio") {
                            if (selectedValue) {
                                naveen[id] = selectedValue;
                            }
                            else{
                                naveen[id] = null
            }


                        }
                    }
                    }
                });
            })

            let token = localStorage.getItem("token");
            let promise = axios.put(
                `${config.apiUrl}/api/product-form/${this.EditIds}`,
                entry,
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                }
            );
            const consumer = () => {
                promise
                    .then((d) => {
                        this.getFormData();
                        this.$router.replace("/product-data");
                    })
                    .catch((e) => {
                        console.log("Error", e);
                        this.error = e.response.data.errors;
                    });
            };
            consumer();
        },
        fetchData() {
    let token = localStorage.getItem("token");

    axios.get(`${config.apiUrl}/api/product-category-list-all`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }).then((res)=>{
                    this.parentIdValue= res.data.result
                    console.log(this.parentIdValue,'redlist');
                })
      .catch(error => {
        // Handle any errors
        console.error(error);
      });
  }
    },
    mounted() {
        this.getFormData();
        this.fetchData()
    },
};
</script>
<style>
.uuiuiuiu {
    display: flex;
    flex-wrap: wrap;
    gap: 17px;
    /* color: #2b2b2b; */
    font-size: 14px;
}

.create-lead {
    border-bottom: 2px solid #547bb5;
    margin-bottom: 20px;
}

.lead {
    font-size: 25px !important;
    font-weight: 600;
}
.save-lead{
  margin-top:29px
}
.card{
    border-radius: 10px !important;
}
body.dark-only .form-check-input {
    background-color: #10101c!important;
    border-color: #fff!important;

}
.form-check-input:checked {
    background-color: #0d6efd!important;
    border-color: #fff!important;
}
.labelMargindown{
    margin-bottom: 10px;
}

</style>
