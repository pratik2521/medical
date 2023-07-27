<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div v-for="(feature, index) in features" :key="index">
                            <div>
                                <input
                                    type="hidden"
                                    v-model="features[index].idd"
                                />
                                <label for="name"
                                    >Feature Name:{{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Enter Product name"
                                    v-model="features[index].name"
                                    ref="featureNameInput"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.name[index]"
                                    >{{ validationErrors.name[index] }}</span
                                >
                            </div>

                            <div>
                                <label for="description"
                                    >Feature Description:{{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Enter Product Description"
                                    v-model="features[index].description"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.description[index]"
                                    >{{
                                        validationErrors.description[index]
                                    }}</span
                                >
                            </div>

                            <div>
                                <label for="image"
                                    >Feature Image:{{ index }}</label
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
                                <img :src="feature.url" v-if="feature.url" />
                                <!-- <button
                                    class="mt-2 btn btn-danger radius"
                                    type="button"
                                    @click="removeImage(index)"
                                >
                                    Remove Image
                                </button> -->
                                <!-- <img
                                    :src="imagePreview[index].url"
                                    alt="nn"
                                /> -->
                            </div>

                            <button
                                class="marginLeft radius"
                                type="button"
                                @click="removeOneTilte(index)"
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
                            class="mt-4 btn btn-primary radius ml-4"
                            type="submit"
                        >
                            Submit
                        </button>
                        <!-- <button class="mt-4 btn btn-primary ml-4"  @click="Update()"    v-if="EditIds !== null" type="submit">
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
            existId: [],
            EditIds: null,
            parentId: "",
            dataArray: [],
            features: [
                {
                    name: "",
                    description: "",
                    image: null,
                    idd: null,
                },
            ],
            storeParentID: null,
            imagePreview: [],
            validationErrors: {
                name: [],
                description: [],
                image: [],
            },
            formData: new FormData(), // Move formData declaration here
        };
    },
    methods: {
        removeOneTilte(index) {
            console.log(index, "index");
            this.features.splice(index, 1);
        },

        cancelAdd() {
            if (this.features.length > 1) {
                this.features.pop();
                this.validationErrors.name.pop();
                this.validationErrors.description.pop();
                this.validationErrors.image.pop();
                this.imagePreview.pop();
            }
        },
        // handleImageUpload(event, index) {
        //     const files = event.target.files;
        //     for (let i = 0; i < files.length; i++) {
        //         const file = files[i];
        //         const url = URL.createObjectURL(file);
        //         this.features[index].image= file;

        //         // this.dataArray.push(this.features);
        //         this.imagePreview[index] = { file: file, url: url };
        //     }
        //     // console.log(this.features.image[index].file,'ddd')
        // },
        handleImageUpload(event, index) {
            const files = event.target.files;
            if (files.length > 0) {
                const file = files[0];
                const url = URL.createObjectURL(file);
                this.features[index].image = file;
                this.imagePreview[index] = { file: file, url: url };
            } else {
                // If no file is selected, remove the image and its preview
                this.features[index].image = null;
                this.imagePreview[index] = null;
            }
        },
        validateForm() {
            this.validationErrors.name = this.features.map((feature) =>
                feature.name ? "" : "Feature Name is required"
            );

            this.validationErrors.description = this.features.map((feature) =>
                feature.description ? "" : "Feature description is required"
            );
            // this.validationErrors.image = this.features.map((feature) =>
            //     feature.image ? "" : "Feature image is required"
            // );
            return Object.values(this.validationErrors).every((errors) =>
                errors.every((error) => !error)
            );
        },
        addMore() {
            this.features.push({
                name: "",
                description: "",
                image: null,
            });
            this.validationErrors.name.push("");
            this.validationErrors.description.push("");
            this.validationErrors.image.push("");
            this.imagePreview.push("");
        },
        submitForm() {
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }

            if (this.validateForm()) {
                this.formData = new FormData(); // Clear the formData before appending new data
                this.features.forEach((feature, index) => {
                    console.log(feature, "ddd");
                    this.formData.append(`name[${index}]`, feature.name);
                    this.formData.append(
                        `description[${index}]`,
                        feature.description
                    );
                    this.formData.append(
                        `icon[${index}]`,
                        feature.image === undefined ? " " : feature.image
                    );
                    this.formData.append(`parent_id[${index}]`, this.parentId);
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
                        `${config.apiUrl}/api/my-product-features`,
                        this.formData,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                                "Content-Type": "multipart/form-data",
                            },
                        }
                    )
                    .then((res) => {
                        console.log("Error", res);
                        // this.$router.replace("/admin");
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error(error);
                    });

                this.features = [
                    {
                        name: "",
                        description: "",
                        image: "",
                    },
                ];
                this.validationErrors = {
                    name: [],
                    description: [],
                    image: [],
                };
                this.imagePreview = [];
            }
        },
        getFormDataW(id) {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/get-my-product-feature/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    //   console.log(res.data.result,'resposnse');
                    if (res.data.result.length == 0) {
                        // console.log("ifddd")
                    } else {
                        const Naveen = [];
                        res.data.result.forEach((it) => {
                            //    this.existId.push(it.id)
                            let title = {
                                name: it.title,
                                url: `${config.imageUrl}${it.icon_path}`,
                                // image: `${config.imageUrl}${it.icon_path}`,
                                description: it.description,
                                idd: it.id,
                            };

                            Naveen.push(title);
                        });
                        this.features = Naveen;
                    }
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },
        removeImage(index) {
            console.log(index, "index");

            this.features[index].image = null;
            this.imagePreview[index] = null;
            const imagePath = this.features[index].url;
            console.log(imagePath, "image path ");
            const fileName = imagePath.split("/").pop();
            console.log("Image file name:", fileName);

            const fullPath = "product_images/" + fileName;
            console.log("Full image path:", fullPath);
            const object = {
                path: fullPath,
            };
            console.log(object, "removed data");
            const dataString = JSON.stringify(object);
            console.log(dataString);

            this.features[index].url = null;
            this.handleImageUpload()
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

img {
    width: 25%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
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
.radius {
    border-radius: 22px !important;
}
.marginLeft {
    margin-left: 790px !important;
}
</style>
