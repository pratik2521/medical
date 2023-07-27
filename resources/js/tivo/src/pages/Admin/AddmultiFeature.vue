<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div v-for="(label, index) in labels" :key="index">
                            <!-- {{ label }} -->
                            <label>
                                <input
                                    type="checkbox"
                                    id="myCheck"
                                    v-model="checkboxValues[index]"
                                />
                                {{ label.name }}
                            </label>
                            <span class="error text-danger" v-if="!hasSelectedCheckbox">
              Please select at least one option.
            </span>
                        </div>

                        <button class="mt-4 btn btn-primary radius" type="submit">
                            Submit
                        </button>
                        <!-- <button
                            class="mt-4 ml-4 btn btn-primary"
                            v-if="EditIds !== null"
                            type="submit"
                            @click="Update()"
                        >
                            Update
                        </button> -->
                    </form>
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
            EditIds: null,
            labels: [], // Array to store labels fetched from the API
            checkboxValues: [], // Array to store checkbox values
            parentId: "",
            hasSelectedCheckbox: true,
        };
    },

    created() {
        this.fetchLabels();
    },

    methods: {
        fetchLabels() {
            let token = localStorage.getItem("token");

            axios
                .get(`${config.apiUrl}/api/my-product-getmulti-features`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    this.labels = response.data.result;
                    // console.log(this.labels,'label')
                    // console.log(this.labels[0].id); // Assuming the API response contains an array of label objects with a 'name' property
                    this.checkboxValues = Array(this.labels.length).fill(false); // Initialize checkboxValues array with false values
                    // console.log(this.checkboxValues)
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },
        //   Update(){
        //   console.log('upadte')
        //   return
        //   const url = new URL(window.location.href);
        //               const id = url.pathname.split("/").pop();
        //               const isNum = /^\d+$/.test(id);
        //               if (isNum) {
        //                   this.parentId = id;

        //               }

        //       if (this.validateForm()) {
        //           this.formData = new FormData(); // Clear the formData before appending new data
        //           this.features.forEach((feature, index) => {
        //               this.formData.append(`name[${index}]`, feature.name);
        //               this.formData.append(
        //                   `description[${index}]`,
        //                   feature.description
        //               );
        //               this.formData.append(`icon[${index}]`, feature.image);
        //               this.formData.append(`parent_id[${index}]`, this.parentId);
        //           });

        //           let token = localStorage.getItem("token");

        //           axios
        //               .put(
        //                   `${config.apiUrl}/api/my-product-assing-features/${this.EditIds}`,
        //                   this.formData,
        //                   {
        //                       headers: {
        //                           Authorization: `Bearer ${token}`,
        //                           "Content-Type": "multipart/form-data",
        //                       },
        //                   }
        //               )
        //               .then((res) => {
        //                   console.log("Error", res);
        //               })
        //               .catch((error) => {
        //                   console.error(error);
        //               });

        //           this.features = [
        //               {
        //                   name: "",
        //                   description: "",
        //                   image: "",
        //               },
        //           ];
        //           this.validationErrors = {
        //               name: [],
        //               description: [],
        //               image: [],
        //           };
        //           this.imagePreview = [];
        //       }
        // },

        submitForm() {
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }
    //         if (selectedData.length === 0) {
    //     // Show error message or handle the validation error
    //     console.log("Please select at least one option.");
    //     return;
    // }
    //           const hasSelectedCheckbox = this.checkboxValues.some(value => value);
    // if (!hasSelectedCheckbox) {
    //     // Show error message or handle the validation error
    //     console.log("Please select at least one option.");
    //     return;
    // }
            const selectedData = this.labels.reduce((acc, label, index) => {
                // console.log(acc,'acc',label,index)
                if (this.checkboxValues[index]) {
                    acc.push({
                        my_feature_id: label.id,
                        parent_id: this.parentId,
                    });
                }
                return acc;
            }, []);
            if (selectedData.length === 0) {
        this.hasSelectedCheckbox = false; // Set validation error flag to show error message
        return;
      }

            let token = localStorage.getItem("token");

            axios
                .post(
                    `${config.apiUrl}/api/my-product-assing-features`,
                    selectedData,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "application/json",
                        },
                    }
                )
                .then((response) => {
                    // console.log("Response", response);
                    // this.$router.replace("/admin"); 
                    window.location.reload();
                    // Handle response
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });

            this.checkboxValues = Array(this.labels.length).fill(false); // Reset checkbox values to false
        },
        getFormDataW(id) {
            // return;
            let token = localStorage.getItem("token");
            axios
                .get(
                    `${config.apiUrl}/api/get-my-product-assign-feature/${id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((res) => {
                    // console.log(res.data.result, "resposnse");
                    if (res.data.result.length == 0) {
                        console.log("iff multi");
                    } else {
                        // const Naveen = [];
                        const selectedFeatures = res.data.result.map(
                            (item) => item.my_feature_id
                        );
                        this.checkboxValues = this.labels.map((label) =>
                            selectedFeatures.includes(label.id)
                        );
                        // this.checkboxValues = Naveen;
                    }

                    // let ddd = {
                    //     name: res.data.result.name,
                    //     description: res.data.result.product_price,
                    //     image: res.data.result.product_discount,
                    // };

                    // this.features = [];
                    // this.features.push(ddd);

                    // Handle response
                    // this.$router.push({ name: AddFeatureVue});
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },
    },
    mounted() {
        const url = new URL(window.location.href);
        const id = url.pathname.split("/").pop();
        const isNum = /^\d+$/.test(id);
        if (isNum) {
            this.getFormDataW(id);
            this.EditIds = id;
        }
    },
};
</script>
