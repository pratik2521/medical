<template>
    <div class="row">
                       <div v-for="data in datas" :class="data.field_type == 'text' || data.field_type == 'dropdownSelect'  ||data.field_type == 'time'  || data.field_type == 'date' || data.field_type == 'number'  ? 'col-md-4 labelMargindown ' :  data.field_type == 'textarea' ? 'col-md-12 labelMargindown' : data.field_type == 'checkbox' ? data.input_name== 'mon' || data.input_name== 'tue' || data.input_name== 'wed' || data.input_name== 'thu' || data.input_name== 'fri' || data.input_name== 'sat' || data.input_name== 'sun' ? 'col-md-1-3 labelMargindown':'col-md-4 labelMargindown aaaaaa ' : ''" >

                           <div v-if="data.field_type == 'text'" >
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
                                   <input
                                       :type="data.field_type"
                                       class="form-control "
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
                                   <select
                                       class="form-select dropDownSize"
                                       aria-label="Default select example"
                                       :id="data.input_name"

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
                           <div v-if="data.field_type == 'textarea'"  >
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
                           <div v-if="data.field_type == 'number'"  >
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
                           <div v-if="data.field_type == 'date'" >
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

                           v-if="data.field_type == 'checkbox'">
                               <div class="form-check ">
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
</template>

<script>
export default {
   props: {
       datas: {
           type: Object,
           default: () => {},
       },
       error:{
        type :Object,
        default: () => {},
    }
       /* sections: {
     type: Array,
     default: () => {},
   }, */
   },
   data(){
    return {
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
    error: function(newVal, oldVal) { // watch it
        //console.log('Prop changed: ', newVal, ' | was: ', oldVal)
        const errors = Object.keys(newVal)
        if(errors.length > 0 && document.getElementById(errors[0])) {
            document.getElementById(errors[0]).focus();

        }
    }
    }

}

</script>
<style>
.labelMargindown{
    margin-bottom: 10px;
}

/* .dataCheck{
    display: flex !important;;
    align-items: end!important;
} */
/* @media   only screen and (min-width: 768px) { .textAeraSize {
        width: 650px !important;
    }
}
@media  only screen and  (min-width: 1024px) { .textAeraSize {
        width: 880px !important;
    }
} */

/* @media only screen and (max-width: 320px)  {
    .textAeraSize {
        width: 280px !important;
    }
    .dropDownSize{
        width: 280px !important;
    }

} */
.checkboxcontainer{
   margin-left: 40px;
}
.aaaaaa{
    display: flex;
    align-items: flex-end;
}
.col-md-1-3{
    width: 9.5% !important;

    float: left;

}
.uuiuiuiu {
    display: flex;
    flex-wrap: wrap;
    /* color: #2b2b2b; */
    font-size: 14px;
}


@media only screen and (max-width: 765px) and (min-width: 320px)  {
    .col-md-1-3 {
    width: 20.5% !important;
    float: left;
    }


}



</style>
