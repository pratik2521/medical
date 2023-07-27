<template>
    <breadCrumbs :title="title" :main="main" />
    <div class="col-sm-12 col-xl-12">
        <div class="card basic-tab">
           
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            id="product-tab"
                            data-bs-toggle="tab"
                            href="#product"
                            role="tab"
                            aria-controls="product"
                            aria-selected="true"
                            >Product Details</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="home-tab"
                            data-bs-toggle="tab"
                            href="#home"
                            role="tab"
                            aria-controls="home"
                            aria-selected="false"
                            >Feature</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="slider-tab"
                            data-bs-toggle="tab"
                            href="#sidebar"
                            role="tab"
                            aria-controls="slider"
                            aria-selected="false"
                            >Sidebar</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="MultiFeaturesTable-tab"
                            data-bs-toggle="tab"
                            href="#MultiFeaturesTable"
                            role="tab"
                            aria-controls="MultiFeaturesTable"
                            aria-selected="false"
                            >AsingFeatures </a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="YoutubeLink-tab"
                            data-bs-toggle="tab"
                            href="#YoutubeLink"
                            role="tab"
                            aria-controls="YoutubeLink"
                            aria-selected="false"
                            >Youtube Link </a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="headingAndFaq-tab"  
                            data-bs-toggle="tab"
                            href="#headingAndFaq"
                            role="tab"
                            aria-controls="slider"
                            aria-selected="false"
                            >Specification</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="slider-tab"
                            data-bs-toggle="tab"
                            href="#slider"
                            role="tab"
                            aria-controls="slider"
                            aria-selected="false"
                            >SliderImage</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="slider-tab"
                            data-bs-toggle="tab"
                            href="#single"
                            role="tab"
                            aria-controls="slider"
                            aria-selected="false"
                            >SingleImage</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="rating-tab"
                            data-bs-toggle="tab"
                            href="#rating"
                            role="tab"
                            aria-controls="compareProduct"
                            aria-selected="false"
                            >Rating </a
                        >
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="profile-tabs"
                            data-bs-toggle="tab"
                            href="#profile"
                            role="tab"
                            aria-controls="profile"
                            aria-selected="false"
                            >FAQ</a
                        >
                    </li>
                   
                    
                   
                   
                   
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="compareProduct-tab"
                            data-bs-toggle="tab"
                            href="#compareProduct"
                            role="tab"
                            aria-controls="compareProduct"
                            aria-selected="false"
                            >CompareProduct </a
                        >
                    </li>
                   
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div
                        class="tab-pane fade show active"
                        id="product"
                        role="tabpanel"
                        aria-labelledby="product-tab"
                    >
             
                        <AddImagePreview/>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="home"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                    >
                        <AddFeature  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="profile"
                        role="tabpanel"
                        aria-labelledby="profile-tab"
                    >
                        <AddQuestion  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="slider"
                        role="tabpanel"
                        aria-labelledby="slider-tab"
                    >
                        <SliderImage  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="single"
                        role="tabpanel"
                        aria-labelledby="slider-tab"
                    >
                        <AddSingleImage  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="sidebar"
                        role="tabpanel"
                        aria-labelledby="slider-tab"
                    >
                        <AddSideBar  />
                    </div>
                   
                    <div
                        class="tab-pane fade"
                        id="headingAndFaq"
                        role="tabpanel"
                        aria-labelledby="slider-tab"
                    >
                        <AddHeadingAndFaq />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="YoutubeLink"
                        role="tabpanel"
                        aria-labelledby="YoutubeLink-tab"
                    >
                        <AddYoutube />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="MultiFeaturesTable"
                        role="tabpanel"
                        aria-labelledby="MultiFeaturesTable-tab"
                    >
                        <AddmultiFeature  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="compareProduct"
                        role="tabpanel"
                        aria-labelledby="compareProduct-tab"
                    >
                        <CompareProduct  />
                    </div>
                    <div
                        class="tab-pane fade"
                        id="rating"
                        role="tabpanel"
                        aria-labelledby="compareProduct-tab"
                    >
                        <AddRating  />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div></div>
</template>
<script>
import breadCrumbs from "../../layout/breadCrumbs.vue";
import AddImagePreview from "../Admin/AddImagePreview.vue";
import AddSingleImage from "../Admin/AddSingleImage.vue";
import AddFeature from "../Admin/AddFeature.vue";
import AddQuestion from "../Admin/AddQuestion.vue";
import SliderImage from "../Admin/SliderImage.vue";
import AddHeadingAndFaq from "../Admin/AddHeadingAndFaq.vue";
import config from "../../config";
import axios from "axios";
import AddSideBar from '../Admin/AddSideBar.vue'
import AddYoutube from '../Admin/AddYoutube.vue'
import AddmultiFeature from '../Admin/AddmultiFeature.vue'
import CompareProduct from '../Admin/CompareProduct.vue'
import AddRating from '../Admin/AddRating.vue'

export default {
    components: {
        breadCrumbs,
        AddImagePreview,
        AddFeature,
        AddQuestion,
        SliderImage,
        AddHeadingAndFaq,
        AddSideBar,
        AddYoutube,
        AddmultiFeature,
        CompareProduct,
        AddRating,
        AddSingleImage
    },
    data() {
        return {
            main: "Add Product",
            title: " Add Product Data",
            imagePreview: [],
            selectedFiles: [],
            main: "Add",
            title: " Add Data ",
            product: {
                name: "",
                model: "",
                productPrice: "",
                discount: "",
            },
            parentId: "",
        };
    },
    methods: {
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
            this.selectedFiles = [], 
            this.product.name = "";
            this.product.model = "";
            this.product.productPrice = "";
            this.product.discount = "";

            this.$refs.fileInput.value = null;
        },
        removeImage(index) {
            this.scopedimagePreview.splice(index, 1);

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
                console.log(this.selectedFiles);
            }
        },
        AddProduct() {
            const formData = new FormData();
            formData.append("name", this.product.name);
            // formData.append("product_modelname", this.product.model);    
            formData.append("product_price", this.product.productPrice);
            formData.append("product_discount", this.product.discount);
            this.selectedFiles.forEach((file, index) => {
                formData.append(`files[${index}]`, file.file);
            });
            console.log(formData)

            let token = localStorage.getItem("token");

            axios
                .post(`${config.apiUrl}/api/my-product`, formData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.log(res.data, "dtata");
                    this.parentId = res.data.result.id;
                    // console.log(this.parentId)

                    // Handle response
                    // this.$router.push({ name: AddFeatureVue});
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
            (this.imagePreview = []),
                (this.product = {
                    name: "",
                    model: "",
                    productPrice: "",
                    discount: "",
                });
        },
    },
};
</script>
<style >
.nav-link.active {
    background-color: #5c61f2 !important;
    color: white !important;
}
</style>
