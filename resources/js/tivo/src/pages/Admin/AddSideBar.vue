<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div v-for="(feature, index) in features" :key="index">
                            <div>
                                <input type="hidden" v-model="feature.idd" />

                                <label for="name"
                                    >Sidebar Title:{{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Enter Product name"
                                    v-model="feature.name"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.name[index]"
                                    >{{ validationErrors.name[index] }}</span
                                >
                            </div>

                            <div>
                                <label for="image"
                                    >Sidebar Image:{{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    type="file"
                                    @change="handleImageUpload($event, index)"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.image[index]"
                                    >{{ validationErrors.image[index] }}</span
                                >
                                <img :src="feature.url" />
                                <!-- <button type="button" class="btn btn-danger radius" @click="removeImage(index)">
                                    RemoveImage

                                    
                                </button> -->
                            </div>

                            <button
                                type="button"
                                class="btn marginLeft radius"
                                @click="removeOneTitle(index)"
                                v-if="index > 0"
                            >
                                Remove
                            </button>
                            <hr />
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
            formData: new FormData(),
            features: [
                {
                    name: "",
                    image: null,
                    idd: null,
                },
            ],
            imagePreview: [],
            validationErrors: {
                name: [],
                image: [],
            },
        };
    },

    methods: {
       
        removeOneTitle(index) {
            this.features.splice(index, 1);
        },

        handleImageUpload(event, index) {
            const file = event.target.files[0];
            const url = URL.createObjectURL(file);

            this.features[index].image = file;
            // this.features[index].url = url;
        },

        validateForm() {
            this.validationErrors.name = this.features.map((feature) =>
                feature.name ? "" : "Sidebar Title is required"
            );
            // this.validationErrors.image = this.features.map((feature) =>
            //   feature.image ? "" : "Sidebar Image is required"
            // );

            return Object.values(this.validationErrors).every((errors) =>
                errors.every((error) => !error)
            );
        },
        removeImage(index) {
        console.log(index,'index')

      this.features[index].image = null;
      this.imagePreview[index] = null;
      const imagePath = this.features[index].url;
      console.log(imagePath,'image path ')
      const fileName = imagePath.split("/").pop();
            console.log("Image file name:", fileName);

            const fullPath = "product_images/" + fileName;
            console.log("Full image path:", fullPath);
            const object = {
                 path: fullPath,
          };
          console.log(object, "removed data");
          const dataString = JSON.stringify(object);
          console.log(dataString)
      
        this.features[index].url = null;
    },

        submitForm() {
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }

            if (this.validateForm()) {
                this.formData = new FormData();
                this.features.forEach((feature, index) => {
                    this.formData.append(`name[${index}]`, feature.name);
                    // this.formData.append(`icon[${index}]`, feature.image);
                    this.formData.append(
                        `icon[${index}]`,
                        feature.image === undefined ? " " : feature.image
                    );

                    this.formData.append(`parent_id[${index}]`, this.parentId);
                    // this.formData.append(
                    //   `newid[${index}]`,
                    //   feature.idd === undefined  ? null : feature.idd
                    // );
                    this.formData.append(
                        `newid[${index}]`,
                        feature.idd === null || feature.idd === undefined
                            ? " "
                            : feature.idd
                    );
                });

                let token = localStorage.getItem("token");

                axios
                    .post(
                        `${config.apiUrl}/api/my-product-sidebar`,
                        this.formData,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                                "Content-Type": "multipart/form-data",
                            },
                        }
                    )
                    .then((response) => {
                        console.log("Response", response);
                        // this.$router.replace("/admin");
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error(error);
                    });

                this.resetForm();
            }
        },

        addMore() {
            this.features.push({
                name: "",
                image: null,
            });
            this.validationErrors.name.push("");
            this.validationErrors.image.push("");
        },

        cancelAdd() {
            if (this.features.length > 1) {
                this.features.pop();
                this.validationErrors.name.pop();
                this.validationErrors.image.pop();
            }
        },

        resetForm() {
            this.features.forEach((feature) => {
                feature.name = "";
                feature.image = null;
                feature.url = "";
            });
            this.validationErrors.name = this.features.map(() => "");
            this.validationErrors.image = this.features.map(() => "");
        },

        getFormDataW(id) {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/my-product-get-sidebar/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    if (res.data.result.length == 0) {
                        return;
                    } else {
                        const Naveen = [];
                        res.data.result.forEach((it) => {
                            let title = {
                                name: it.title,
                                url: `${config.imageUrl}${it.icon_path}`,
                                idd: it.id,
                            };

                            Naveen.push(title);
                        });
                        this.features = Naveen;
                    }
                })
                .catch((error) => {
                    console.error(error);
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

<style scoped>
h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"] {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

img {
    width: 25%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
}

button[type="submit"],
button[type="button"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover,
button[type="button"]:hover {
    background-color: #0056b3;
}
.marginLeft {
    margin-left: 780px !important;
}
.ml-4{
    margin-left: 4px;
}
.radius{
    border-radius: 22px !important
}
</style>
