<template>
    <div>
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <div class="product-info">
              <form @submit.prevent="AddProduct">
                <div class="product-group">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input
                          class="form-control"
                          placeholder="Enter Product Name"
                          type="text"
                          v-model="product.name"
                        />
                        <span class="error text-danger" v-if="validationErrors.name">{{ validationErrors.name }}</span>
                      </div>
                    </div>
                  </div>
  
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label">Product Price</label>
                        <input
                          class="form-control"
                          placeholder="Enter Product Price"
                          type="number"
                          v-model="product.productPrice"
                        />
                        <span class="error text-danger" v-if="validationErrors.productPrice">{{ validationErrors.productPrice }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label class="form-label">Product Discount</label>
                        <input
                          class="form-control"
                          placeholder="Enter Product Discount"
                          type="number"
                          v-model="product.discount"
                        />
                        <span class="error text-danger" v-if="validationErrors.discount">{{ validationErrors.discount }}</span>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div>
                  <div
                    class="drop-zone"
                    @dragover.prevent="dragOver"
                    @drop="dropFiles"
                    @click="openFileInput"
                  >
                    <p>Drag and drop files here or click to select</p>
                  </div>
  
                  <input
                    type="file"
                    ref="fileInput"
                    multiple
                    style="display: none"
                    @change="handleFileUpload"
                  />
                  <span class="error text-danger" v-if="validationErrors.files">{{ validationErrors.files }}</span>

                  <button class="btn btn-danger mt-4" @click="cancelFiles">
                    Cancel
                  </button>
  
                  <button
                    type="submit"
                    class="btn btn-primary mt-4 radius"
                  >
                    Add Product
                  </button>
  
                  <div v-if="imagePreviews.length > 0">
                    <div v-for="(file, index) in imagePreviews" :key="index">
                      <img :src="file.url" :alt="file.name" />
                      <button
                      type="button"
                        class="btn btn-danger mt-4 radius"
                        @click="removeImage(index)"
                      >
                        Remove image
                      </button>
                    </div>
                  </div>
  
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import breadCrumbs from "../../layout/breadCrumbs.vue";
  import VueRouter from "vue-router";
  import config from "../../config";
  import axios from "axios";
  import AddFeatureVue from "./AddFeature.vue";
  
  export default {
    components: {
      breadCrumbs,
    },
    data() {
      return {
        parentId: "",
        EditIds: null,
        imagePreviews: [],
        selectedFiles: [],
        main: "Add ",
        title: " Add Product Data ",
        product: {
          name: "",
          productPrice: "",
          discount: "",
        },
        validationErrors: {
          name: '',
          productPrice: '',
          discount: '',
          files: ''
        }
      };
    },
    methods: {
      validateForm() {
        // Reset the validation errors
        this.validationErrors.name = '';
        this.validationErrors.productPrice = '';
        this.validationErrors.discount = '';
        this.validationErrors.files = '';
  
        // Perform form validation
        let isValid = true;
  
        if (!this.product.name) {
          this.validationErrors.name = 'Product Name is required';
          isValid = false;
        }
  
        if (!this.product.productPrice) {
          this.validationErrors.productPrice = 'Product Price is required';
          isValid = false;
        }
  
        if (!this.product.discount) {
          this.validationErrors.discount = 'Product Discount is required';
          isValid = false;
        }
  
        // if (this.selectedFiles.length === 0) {
        //   this.validationErrors.files = 'Please select at least one file';
        //   isValid = false;
        // }
  
        return isValid;
      },
      dragOver(event) {
        event.preventDefault();
      },
      dropFiles(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        this.handleFileUpload(files);
      },
      openFileInput() {
        this.$refs.fileInput.click();
      },
  
      cancelFiles() {
        this.selectedFiles = [];
        this.product.name = "";
        this.product.productPrice = "";
        this.product.discount = "";
        this.$refs.fileInput.value = null;
      },
      removeImage(index) {
        console.log(index,'index')
       if (confirm("Are you sure you want to remove the image?")) {
        const imagePath = this.imagePreviews[index].url;
            console.log("Removing image:", imagePath);

            const fileName = imagePath.split("/").pop();
            console.log("Image file name:", fileName);

            const fullPath = "product_images/" + fileName;
            console.log("Full image path:", fullPath);

            this.imagePreviews.splice(index, 1);
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
                ).then((res)=>{
                  console.log(res,'res')
                }).catch((error)=>{
                  console.log(error,'error')
              })
            
       }
      
      },
      handleFileUpload(event) {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
          const file = files[i];
          const url = URL.createObjectURL(file);
          this.imagePreviews.push({ url: url });
          this.selectedFiles.push({ file: file });
        }
      },
      AddProduct() {
        const url = new URL(window.location.href);
        const id = url.pathname.split("/").pop();
        const isNum = /^\d+$/.test(id);
        if (isNum) {
          this.parentId = id;
        }
        if (this.validateForm()) {
          const formData = new FormData();
          formData.append("name", this.product.name);
          formData.append("product_price", this.product.productPrice);
          formData.append("product_discount", this.product.discount);
          formData.append("parent_id", this.parentId);
          this.selectedFiles.forEach((file, index) => {
            formData.append(`files[${index}]`, file.file);
          });
  
          let token = localStorage.getItem("token");
  
          axios
            .post(`${config.apiUrl}/api/my-product`, formData, {
              headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "multipart/form-data",
              },
            })
            .then((res) => {
              console.log(res.data);
              // this.$router.replace("/admin");
              window.location.reload();
            })
            .catch((error) => {
              console.error(error);
            });
          this.imagePreviews = [];
          this.product = {
            name: "",
            productPrice: "",
            discount: "",
          };
        }
      },
  
      getFormDataW(id) {
        let token = localStorage.getItem("token");
        axios
          .get(`${config.apiUrl}/api/my-product/${id}`, {
            headers: {
              Authorization: `Bearer ${token}`,
              "Content-Type": "multipart/form-data",
            },
          })
          .then((res) => {
            let ddd = {
              name: res.data.result.name,
              productPrice: res.data.result.product_price,
              discount: res.data.result.product_discount,
            };
  
            this.product = ddd;
            this.imagePreviews = res.data.result.image_path.map((image) => ({
              url: `${config.imageUrl}/${image}`,
              name: image,
            }));
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
  
  .radius {
    border-radius: 22px;
    margin-left: 4px;
  }
  </style>
  