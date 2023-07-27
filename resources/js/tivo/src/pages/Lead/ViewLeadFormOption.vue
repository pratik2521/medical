<template>
    <div class="row">
                       <div v-for="data in datas" :class="data.field_type == 'text' || data.field_type == 'dropdownSelect'   || data.field_type == 'time' ||data.field_type == 'date' || data.field_type == 'number'  ? 'col-md-4 labelMargindown'   :  data.field_type == 'textarea' ? 'col-md-12 labelMargindown ' : ''" >
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
                                   disabled
                                       :type="data.field_type"
                                       class="form-control"
                                       :id="data.input_name+'11'"
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
                           <div v-if="data.field_type == 'dropdownSelect'">
                               <div>
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
                                   disabled
                                       class="form-select dropDownSize"
                                       aria-label="Default select example"
                                       :id="data.input_name+'11'"
                                   >
                                       <option value="">
                                           {{ data.label_description }}
                                       </option>
                                       <option
                                           v-for="item in data.field_values"
                                           :value="item.value"
                                       >
                                           {{ item.value }}
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
                                   disabled
                                       :placeholder="data.label_description"
                                       class="form-control textAeraSize"
                                       :id="data.input_name+'11'"
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
                                        disabled
                                         

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
                                   disabled
                                       :type="data.field_type"
                                       class="form-control"
                                       :id="data.input_name+'11'"
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
                                   disabled
                                       :type="data.field_type"
                                       class="form-control"
                                       :id="data.input_name+'11'"
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
                                   disabled
                                       class="form-select"
                                       aria-label="Default select example"
                                       :id="data.input_name+'11'"
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
                           <div v-if="data.field_type == 'checkbox'">
                               <div class="form-check">
                                   <input
                                   disabled
                                       class="form-check-input"
                                       :type="data.field_type"
                                       :id="data.input_name+'11'"
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
                           <div v-if="data.field_type == 'radio'">
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
                                           disabled
                                               class="form-check-input myRadio"
                                               type="radio"
                                               name="myRadio"
                                               :id="data.input_name+'11'"
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
                   {{ leadId }}
</template>

<script>
import config from "../../config";
import store from "../../store/index";
export default{

    props: {
       leadId: {
           type:Number,
           default: () => { },
       },
    },
    data(){
        console.log('ggggggllll', this.leadId);
        return{
            leadId:null,
            datas: [],
            error: [],
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

        }
    },
    watch: {
        leadId: function (newVal, oldVal) {
            this.leadId = newVal;
            console.log('props id',this.leadId);
            this.getForm(leadId)
        },
    },
    methods: {
        removePrefix(data){
            if (data) {
                return data.split('_')[1];
            }
            return true;
        },
        getFormData(){
            console.log('store',store.state.favorites);

            let token = localStorage.getItem("token");
            axios
                .get(config.apiUrl + "/api/form-data?obect_type_id=1", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {


                    // console.log('ttttttt',res.data.result);
                    this.objectId = res.data.result[0].object_id
                    this.datas = res.data.result;
                    let dataArray = res.data.result;

                    this.getFormDataW(this.$props.leadId)

                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getFormDataW(id) {

            let token = localStorage.getItem("token");
            let promise = axios.get(`${config.apiUrl}/api/lead-form/${id}`, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            }).then((d) => {


                        let retrnData = d.data.result[0];
                        for (let key in retrnData) {
                            console.log("key11",key)
                            console.log("retrnData",retrnData)
                            if (retrnData.hasOwnProperty(key)) {
                                var val = this.removePrefix(key);
                                console.log("val",val)
                                const idInput = document.getElementById(val+'11');
                                console.log("idInput",idInput)
                                const value = retrnData[key];
                                console.log("value",value)
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
                                            document.getElementById(val+'11').value =
                                                value;
                                        }
                                    } else {
                                        if (value !== null) {
                                            document.getElementById(val+'11').value =
                                                value;
                                        }
                                    }
                                }
                            }
                        }
                    })
                    .catch((e) => {
                        console.log("Error", e);
                    })
        }

    },

    mounted() {
             this.getFormData()

    }
}
</script>
<style>
.uuiuiuiu {
    display: flex;
    flex-wrap: wrap;
    /* color: #2b2b2b; */
    font-size: 14px;
}

body.dark-only .form-check-input {
    background-color: #10101c!important;
    border-color: #fff!important;

}
.form-check-input:checked {
    background-color: #0d6efd!important;
    border-color: #fff!important;
}

.create-lead {
    border-bottom: 2px solid #547bb5;
    margin-bottom: 20px;
}

.lead {
    font-size: 25px !important;
    font-weight: 600;
}

.save-lead {
    margin-top: 30px;
}

.card {
    border-radius: 10px !important;
}
.labelMargindown{
    margin-bottom: 10px;
}


</style>
