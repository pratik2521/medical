<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div v-for="(feature, index) in features" :key="index">
                            <div>
                                <label for="name"
                                    >Question Name:{{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Enter Product name"
                                    v-model="features[index].name"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.name[index]"
                                    >{{ validationErrors.name[index] }}</span
                                >
                            </div>

                            <div>
                                <label for="desc"
                                    >Question Answer:{{ index }}</label
                                >
                                <textarea
                                    class="form-control"
                                    placeholder="Enter Product Description"
                                    v-model="features[index].description"
                                    name="w3review"
                                    rows="4"
                                    cols="50"
                                >
                                </textarea>
                                <!-- <input class="form-control" type="text" placeholder="Enter Product Description" v-model="features[index].answer" /> -->
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.description[index]"
                                    >{{
                                        validationErrors.description[index]
                                    }}</span
                                >
                            </div>
                            <button class="btn btn-primary marginLeft mt-4 radius" @click="removeOneTitle(index)" v-if="index > 0">Remove</button>


                            <!-- <div>
           <label for="image">Feature Image:</label>
           <input class="form-control" type="file" @change="handleImageUpload($event, index)" />
           <span class="error text-danger" v-if="validationErrors.image[index]">{{ validationErrors.image[index] }}</span>
           <img :src="imagePreview[index].url" :alt="imagePreview[index].name" v-if="imagePreview[index]" />
         </div> -->
         <hr>
                        </div>

                        <button
                            class="mt-4 btn radius"
                            type="button"
                            @click="addMore"
                        >
                            Add More
                        </button>
                        <button
                            class="mt-4 ml-4 btn btn-primary radius"
                            type="submit"
                        >
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
                        <!-- <button
                            class="mt-4 ml-4 btn btn-danger radius"
                            type="button"
                            @click="cancelAdd"
                        >
                            Cancel
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
            parentId: "",
            features: [
                {
                    name: "",
                    description: "",
                    //    image: null,
                    //    url:''
                },
            ],
            //    imagePreview: [],
            validationErrors: {
                name: [],
                description: [],
                //  image: [],
            },
        };
    },
    methods: {
        removeOneTitle(index) {
            console.log(index);
            this.features.splice(index, 1);
        },
        cancelAdd() {
            if (this.features.length > 1) {
                this.features.pop();
                this.validationErrors.name.pop();
                this.validationErrors.description.pop();
            }
        },
        validateForm() {
            this.validationErrors.name = this.features.map((feature) =>
                feature.name ? "" : "question Name is required"
            );
            this.validationErrors.description = this.features.map((feature) =>
                feature.description ? "" : "question description is required"
            );
            //    this.validationErrors.image = this.features.map((feature) => (feature.image ? '' : 'Feature Image is required'));

            return Object.values(this.validationErrors).every((errors) =>
                errors.every((error) => !error)
            );
        },

        submitForm() {
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }
            if (this.validateForm()) {
                const data = this.features.map(
                    ({ name, description, image }) => ({
                        name,
                        description,
                        parent_id: this.parentId,
                        //    image: { name: image.name, url: this.features.url, type: image.type },
                    })
                );
                console.log(data);
                let token = localStorage.getItem("token");

                axios
                    .post(`${config.apiUrl}/api/my-product-faq`, data, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            // "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((res) => {
                        console.log(res.data);
                        this.features = [
                            {
                                name: "",
                                description: "",
                                //  image: null,
                            },
                        ];
                        this.validationErrors = {
                            name: [],
                            description: [],
                            //    image: [],
                        };
                        // this.$router.replace("/admin");
                        window.location.reload();
                        // Handle response
                        // this.$router.push({ name: AddFeatureVue});
                    })
                    .catch((error) => {
                        console.error(error);
                        // Handle error
                    });

                //  this.imagePreview = [];
                //   this.$refs.imageInput.forEach((input) => {
                //     input.value = null;
                //   });
            }
        },
        getFormDataW(id) {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/get-my-product-faq/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    // console.log('NNNNNNN',res.data.result);
                    if (res.data.result.length == 0) {
                        // console.log('ifffffffffffff');
                    } else {
                        console.log("elseeeeeeeeeee");

                        // console.log(res.data.result, "resdddposnse");

                        const Naveen = [];
                        for (
                            let index = 0;
                            index < res.data.result.length;
                            index++
                        ) {
                            var ddd = {
                                name: res.data.result[index].title,
                                description: res.data.result[index].description,
                            };

                            Naveen.push(ddd);
                        }

                        this.features = Naveen;
                        // this.features.push(ddd);
                    }
                    // Handle response
                    // this.$router.push({ name: AddFeatureVue});
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },

        addMore() {
            this.features.push({
                name: "",
                description: "",
                //  image: null,
            });
            this.validationErrors.name.push("");
            this.validationErrors.description.push("");
            //    this.validationErrors.image.push('');
            //  this.imagePreview.push('');
        },
        // Update() {
        //     console.log("upadte");

        //     const url = new URL(window.location.href);
        //     const id = url.pathname.split("/").pop();
        //     const isNum = /^\d+$/.test(id);
        //     if (isNum) {
        //         this.parentId = id;
        //     }

        //     if (this.validateForm()) {
        //         this.formData = new FormData(); // Clear the formData before appending new data
        //         this.features.forEach((feature, index) => {
        //             this.formData.append(`name[${index}]`, feature.name);
        //             this.formData.append(
        //                 `description[${index}]`,
        //                 feature.description
        //             );
        //             this.formData.append(`icon[${index}]`, feature.image);
        //             this.formData.append(`parent_id[${index}]`, this.parentId);
        //         });

        //         let token = localStorage.getItem("token");

        //         axios
        //             .put(
        //                 `${config.apiUrl}/api/my-product-faq/${this.EditIds}`,
        //                 this.formData,
        //                 {
        //                     headers: {
        //                         Authorization: `Bearer ${token}`,
        //                         "Content-Type": "multipart/form-data",
        //                     },
        //                 }
        //             )
        //             .then((res) => {
        //                 console.log("Error", res);
        //             })
        //             .catch((error) => {
        //                 console.error(error);
        //             });

        //         this.features = [
        //             {
        //                 name: "",
        //                 description: "",
        //                 image: "",
        //             },
        //         ];
        //         this.validationErrors = {
        //             name: [],
        //             description: [],
        //             image: [],
        //         };
        //         this.imagePreview = [];
        //     }
        // },
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

<style scoped>
h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* form div {
 margin-bottom: 20px;
} */

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"] {
    width: 100%;
    /* padding: 10px; */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}



button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
.marginLeft{
  margin-left:  763px !important
}
.radius{
    border-radius: 22px  !important
}
</style>
