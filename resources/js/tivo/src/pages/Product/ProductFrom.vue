<template>
    <div class="container">
        <!-- <div class="create-lead" v-if="EditIds == null">
            <span class="lead">Create Lead</span>
        </div>
        <div class="create-lead" v-if="EditIds !== null">
            <span class="lead">Update Lead</span>
        </div> -->

        <breadCrumbs v-if="EditIds == null" :title="title" :main="main"/>
        <breadCrumbs v-if="EditIds !== null" :title="titles" :main="mains"/>


        <form @submit.prevent="">
            <div class="card">
                <div class="card-body  formPaddingTab " >
                    <ProductFromView :datas="datas" :error="error" :parentIdValue="parentIdValue"/>
                    
                    <div>
                        <div class="col-12 save-lead d-flex justify-content-center">
                            <button v-if="EditIds == null" type="submit" class="btn btn-primary radius" @click="formSubmit()">
                                Save Product
                            </button>
                            <button v-if="EditIds !== null" type="submit" class="btn btn-primary radius" @click="formUpdate()">
                                Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import config from "../../config";
import ProductFromView from "../Product/ProductFromView.vue"
import FormView from "../Lead/FormView.vue"
import breadCrumbs from "../../layout/breadCrumbs.vue"
export default {
    components:{
        ProductFromView,
        breadCrumbs
    },
    data() {
        return {
            title:"Product Form",
            main:"Product",
            titles:"Update Product Form",
            mains:"Product",
            // checkBoxChecked:false,
            // radioChecked:false,
            EditIds: null,
            textData: [],
            dropdownData: [],
            radioData: [],
            checkBoxData: [],
            textAreaData: [],
            timeData: [],
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

            numberData: [],
            rajehs: "",
            datas: [],
            error: [],
            objectId: null,
            errors: {
                dateOfBirth: "",
                email: "",
                mobileNo: "",
                name: "",
            },
            retr: [],
            options: ["Option 1", "Option 2", "Option 3"],
            selectedOption: null,
            parentIdValue:[]
        };
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
                    this.datas = res.data.result;
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
                    const isNum = /^\d+$/.test(id);
                    if (isNum) {
                        this.EditIds = id;
                        this.getFormDataW(id);
                    }

                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getFormDataW(id) {
            let token = localStorage.getItem("token");
            let promise = axios.get(`${config.apiUrl}/api/employee-form/${id}`, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            }).then((d) => {
                        let retrnData = d.data.result[0];
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
                                            document.getElementsByName(val);
                                                // "myRadio"

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
                        this.$router.replace("/product-data");
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
                `${config.apiUrl}/api/employee-form/${this.EditIds}`,
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
                        this.$router.replace("/employee-data");
                    })
                    .catch((e) => {
                        console.log("Error", e.response.data.errors);
                        this.error = e.response.data.errors;
                    })
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
        this.fetchData();
    },
};
</script>
<style >
.uuiuiuiu {
    display: flex;
    flex-wrap: wrap;
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

.save-lead {
    margin-top: 30px;
}

.card {
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
@media only screen and (max-width: 320px)  {
    .formPaddingTab {
        padding:  8px !important;
    }

}


</style>
