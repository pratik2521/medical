<template>
          <breadCrumbs :title="title" :main="main" />
  <div>
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="product-info">
            <form>
              <div class="product-group">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3">
                      <label class="form-label">Product Name</label>
                      <input class="form-control" placeholder="Enter Product Name" type="text" v-model="product.name" />
                      <span class="error text-danger" v-if="validationErrors.name">{{ validationErrors.name }}</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3">
                      <label class="form-label">Product Price</label>
                      <input class="form-control" placeholder="Enter Product Price" type="number" v-model="product.productPrice" />
                      <span class="error text-danger" v-if="validationErrors.productPrice">{{ validationErrors.productPrice }}</span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3">
                      <label class="form-label">Product Discount</label>
                      <input class="form-control" placeholder="Enter Product Discount" type="number" v-model="product.discount" />
                      <span class="error text-danger" v-if="validationErrors.discount">{{ validationErrors.discount }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            
            <div>
                            <div
                                class="drop-zone"
                                @dragover.prevent="dragOver"
                                @drop="dropFiles"
                                @click="openFileInput"
                            >
                                <p>
                                    Drag and drop files here or click to select
                                </p>
                            </div>

                            <input
                                type="file"
                                ref="fileInput"
                                multiple
                                style="display: none"
                                @change="handleFileUpload"
                            />
                  <span class="error text-danger" v-if="validationErrors.files">{{ validationErrors.files }}</span>

                            <button
                                class="btn btn-danger mt-4"
                                @click="cancelFiles"
                            >
                                Cancel
                            </button>

                            <button
                                class="btn btn-primary mt-4"
                                @click="AddProduct"
                            >
                                Add
                            </button>

                            <div v-if="selectedFiles.length > 0">
                                <div
                                    v-for="(file, index) in imagePreview"
                                    :key="index"
                                >
                                    <img :src="file.url" :alt="file.name" />
                                    <button
                                        class="btn btn-danger mt-4"
                                        @click="removeImage(index)"
                                    >
                                        Remove image
                                    </button>
                                </div>
                            </div>
                        </div>

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
      imagePreview: [],
      selectedFiles: [],
      main: "Add ",
      title: " Add Product Data ",
      product: {
        name: "",
        model: "",
        productPrice: "",
        discount: "",
      },
      validationErrors: {
        name: '',
        productPrice: '',
        discount: '',
        files:''
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
      if (this.selectedFiles.length === 0) {
          this.validationErrors.files = 'Please select at least one file';
          isValid = false;
        }

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
      this.product.model = "";
      this.product.productPrice = "";
      this.product.discount = "";

      this.$refs.fileInput.value = null;
    },
    removeImage(index) {
      this.imagePreview.splice(index, 1);

      if (this.imagePreview.length === 0) {
        this.$refs.fileInput.value = null;
      }
    },
    handleFileUpload(event) {
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const url = URL.createObjectURL(file);
        this.imagePreview.push({ url: url });
        this.selectedFiles.push({ file: file });
      }
    },
    AddProduct() {
      if (this.validateForm()) {
        const formData = new FormData();
        formData.append("name", this.product.name);
        formData.append("product_modelname", this.product.model);
        formData.append("product_price", this.product.productPrice);
        formData.append("product_discount", this.product.discount);
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
            this.$router.replace("/admin");
          })
          .catch((error) => {
            console.error(error);
          });

        this.imagePreview = [];
        this.product = {
          name: "",
          model: "",
          productPrice: "",
          discount: "",
        };
      }
    },
  },
};
</script>

<style scoped >
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
.error {
  font-size: 14px;
  margin-top: 5px;
}
</style>
