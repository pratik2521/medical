<template>
    <div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="product-info">
                        <form>
                            <div class="product-group"></div>
                        </form>
                        <!-- <div class="row"> 
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input class="form-control" placeholder="Enter Product Price" type="hidden" v-model="product.productPrice">
                        <span class="text-danger"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row"> 
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input class="form-control" placeholder="Enter Product Price" type="hidden" v-model="product.productPrice">
                        <span class="text-danger"></span>
                      </div>
                    </div>
                  </div> -->

                        <div>
                            <div
                                class="drop-zone"
                                @dragover.prevent="dragOver1"
                                @drop="dropFiles1"
                                @click="openFileInput1"
                            >
                                <p>
                                    Drag and drop files here or click to select
                                </p>
                            </div>

                            <input
                                type="file"
                                ref="fileInput1"
                                multiple
                                style="display: none"
                                @change="handleFileUpload1"
                            />
                            <button
                                class="btn btn-danger mt-4"
                                @click="cancelFiles1"
                            >
                                Cancel
                            </button>

                            <div v-if="imagePreview1.length > 0">
                                <div
                                    v-for="(file, index) in imagePreview1"
                                    :key="index"
                                >
                                    <img :src="file.url" :alt="file.name" />
                                    <button
                                        class="btn btn-danger mt-4"
                                        @click="removeImage1(index)"
                                    >
                                        Remove image
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- <div>
                            <div
                                class="drop-zone"
                                @dragover.prevent="dragOver2"
                                @drop="dropFiles2"
                                @click="openFileInput2"
                            >
                                <p>
                                    Drag and drop files here or click to select
                                </p>
                            </div>

                            <input
                                type="file"
                                ref="fileInput2"
                                multiple
                                style="display: none"
                                @change="handleFileUpload2"
                            />
                            <button
                                class="btn btn-danger mt-4"
                                @click="cancelFiles2"
                            >
                                Cancel
                            </button>

                            <div v-if="selectedFiles2.length > 0">
                                <div
                                    v-for="(file, index) in imagePreview2"
                                    :key="index"
                                >
                                    <img :src="file.url" :alt="file.name" />
                                    <button
                                        class="btn btn-danger mt-4"
                                        @click="removeImage2(index)"
                                    >
                                        Remove image
                                    </button>
                                </div>
                            </div>
                        </div> -->

                        <button
                            class="btn btn-primary mt-4"
                            @click="submitData"
                        >
                            Submit
                        </button>
                        <!-- <button
                            class="mt-4 btn btn-primary ml-4"
                            @click="Update()"
                            v-if="EditIds !== null"
                            type="submit"
                        >
                            Update
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import breadCrumbs from "../../layout/breadCrumbs.vue";
import config from "../../config";
import axios from "axios";

export default {
    components: {
        breadCrumbs,
    },
    data() {
        return {
            removeData: [],
            EditIds: null,
            parentId: "",
            imagePreview1: [],
            selectedFiles1: [],
            imagePreview2: [],
            selectedFiles2: [],
            main: "Add",
            title: "Add Data",
            product: {
                name: "",
                model: "",
                productPrice: "",
                discount: "",
            },
            dataObject: {}, // Object to store the submitted data
        };
    },
    methods: {
        getFormDataW(id) {
            let token = localStorage.getItem("token");
            axios
                .get(
                    `${config.apiUrl}/api/get-my-product-slider-single/${id}/slider`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((res) => {
                    // console.log(res);
                    if (res.data.result.length == 0) {
                        // console.log("hhh");
                        return;
                    } else {
                        const getImage = [];

                        res.data.result.forEach((item) => {
                            let dtt = {
                                url: `${config.imageUrl}${item.image_path}`,
                            };
                            getImage.push(dtt);
                        });
                        this.imagePreview1 = getImage;
                    }
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },

        dragOver1(event) {
            event.preventDefault();
        },
        dropFiles1(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            this.handleFileUpload1(files);
        },
        openFileInput1() {
            this.$refs.fileInput1.click();
        },
        handleFileUpload1(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);
                this.imagePreview1.push({ url });
                this.selectedFiles1.push({ file: file });
            }
        },
        cancelFiles1() {
            console.log("canel");
            this.imagePreview1 = [];
            this.$refs.fileInput1.value = null;
        },
        removeImage1(index) {
            if(confirm(`Are you sure you want to remove the image?`)){
                const imagePath = this.imagePreview1[index].url;
            console.log("Removing image:", imagePath);

            const fileName = imagePath.split("/").pop();
            console.log("Image file name:", fileName);

            const fullPath = "product_images/" + fileName;
            console.log("Full image path:", fullPath);

            this.imagePreview1.splice(index, 1);

            const object = {
                path: fullPath,
            };
            
            console.log(object, "removed data");
            const dataString = JSON.stringify(object);

            let token = localStorage.getItem("token");

            axios
                .post(
                    `${config.apiUrl}/api/my-product-image-delete`,
                    dataString,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "application/json",
                        },
                    }
                )
                .then((res) => {
                    console.log("res", res);
                   
                })
                .catch((error) => {
                    console.error(error);
                });
            }
        },
        dragOver2(event) {
            event.preventDefault();
        },
        dropFiles2(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            this.handleFileUpload2(files);
        },
        openFileInput2() {
            this.$refs.fileInput2.click();
        },
        handleFileUpload2(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);
                this.imagePreview2.push({ url });
                this.selectedFiles2.push({ file: file });
            }
        },
        cancelFiles2() {
            this.selectedFiles2 = [];
            this.$refs.fileInput2.value = null;
        },
        removeImage2(index) {
            this.imagePreview2.splice(index, 1);

            if (this.imagePreview2.length === 0) {
                this.$refs.fileInput2.value = null;
            }
        },
        submitData() {
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }
            const files1 = this.selectedFiles1.map((file) => ({
                // name: file.name,
                // url: file.url,
                file: file.file,
            }));

            const files2 = this.selectedFiles2.map((file) => ({
                // name: file.name,
                // url: file.url,
                file: file.file,
            }));

            const combinedFiles = [...files1, ...files2]; // Combine the files1 and files2 arrays

            this.dataObject = { files: combinedFiles }; // Assign the combined files to the dataObject variable

            // Perform your submit logic here

            let data = {
                files: this.dataObject.files.map((obj) => obj.file), // Extract the 'file' property from each object
            };

            let collectData = {
                type: "slider",
                files: data.files,
                parent_id: this.parentId,
            };
            console.log(collectData, "ddd");
            let token = localStorage.getItem("token");

            axios
                .post(
                    `${config.apiUrl}/api/my-product-upload-gallery`,
                    collectData,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((res) => {
                    console.log("Error", res);
                    // this.apiResFormList = res.data.result.data;
                    // this.mapData = res.data.result.data;
                    window.location.reload();
                })
                .catch((error) => {
                    console.error(error);
                });

            // Clear form fields and selected files
            this.product.name = "";
            this.product.model = "";
            this.product.productPrice = "";
            this.product.discount = "";
            this.selectedFiles1 = [];
            this.selectedFiles2 = [];
            this.imagePreview1 = [];
            this.imagePreview2 = [];
            this.$refs.fileInput1.value = null;
            this.$refs.fileInput2.value = null;
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
.drop-zone {
    border: 2px dashed blue;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}

.drop-zone p {
    margin: 0;
    font-size: 18px;
}

.drop-zone:hover {
    background-color: #f5f5f5;
}

img {
    width: 25%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
}
</style>
