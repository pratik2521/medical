<template>
    <Breadcrumbs main="Product" title="Product Details" />
    <div class="container-fluid">
        <div class="row product-page-main p-0">
            <productSwiper :mapData="mapData" :imageData="imageData" />
        </div>
        <div class="col-md-12 row">
            <div class="col-md-8 mt-4   ">
                <div class="row product-page-main p-0">
                    <productFeature :features="features" />
                    <!-- {{ console.log(fetchdata.main_gallery, "dddddddddddddddddd") }} -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="row product-page-main p-0 sideBarMarginTop">
                    <Sidebar :sidebar="sidebar" />
                </div>
            </div>
        </div>
        <div class="m-4">
            <div class="row product-page-main p-0">
                <ProductTable  :compareProduct="compareProduct"/>
            </div>
        </div>
        <div class="m-4">
            <div class="row product-page-main p-0">
                <ProductYoutubeLink :youtubelink="youtubelink" />
            </div>
        </div>
        <div class="m-4">
            <div class="row product-page-main p-0">
                <productHeadingFaq :specification="specification" />
            </div>
            <div class="row product-page-main p-0">
                <productSliderImages :slider_gallery="slider_gallery" />
            </div>

            <div class="unedi-ted">
                <h1>
                    <span class="unedited"
                        >Uncensored, Unedited, Unfiltered </span
                    >"Customer Reviews"
                </h1>
                <p class="here">
                    To help you decide for yourself how good Frozen™ Cold Plunge
                    is, we have listed REAL, UNCENSORED, UNEDITED reviews,
                    emails and comments from customers who have paid for and
                    used Frozen.
                </p>
            </div>

            <div class="m-4">
                <div class="row product-page-main p-0">
                    <productImages :single_gallery="single_gallery" />
                </div>
            </div>
           
            <div class="m-8">
                <div class="row product-page-main p-0">
                    <productCaraousel :review="review" />
                </div>
            </div>
            <div class="m-8">
                <div class="row product-page-main p-0">
                    <Faq :faq="faq" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import productSwiper from "../ProductPage/productSwiper.vue";
import Sidebar from "../ProductPage/Sidebar.vue";
import productFeature from "../ProductPage/productFeature.vue";
import productSliderImages from "../ProductPage/productSliderImages.vue";
import ProductTable from "../ProductPage/ProductTable.vue";
import ProductYoutubeLink from "../ProductPage/ProductYoutubeLink.vue";
import productHeadingFaq from "../ProductPage/productHeadingFaq.vue";
import productImages from "../ProductPage/productImages.vue";
import Faq from "../ProductPage/Faq.vue";
import productCaraousel from "../ProductPage/productCaraousel.vue";
import axios from "axios";
import breadCrumbs from "../../layout/breadCrumbs.vue";
import { ref, onMounted } from "vue";
import config from "../../config";


export default {
    components: {
        breadCrumbs,
        productSwiper,
        productFeature,
        ProductTable,
        ProductYoutubeLink,
        productHeadingFaq,
        productImages,
        productCaraousel,
        Faq,
        Sidebar,
        productSliderImages
    },
    data() {
        return {
            imageData: null,
            features: "",
            mapData: "",
            youtubelink: "",
            faq: "",
            specification: "",
            single_gallery: "",
            sidebar:'',
            compareProduct:'',
            slider_gallery:"",
            review:"",
        };
    },

    methods: {
        getFormDataW(id) {
            console.log("deepaktiwari", id);
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/get-my-product-preview/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log("raju", response.data.result);
                    this.mapData = response.data.result;
                    console.log("999999999", response.data.result);
                    const imagee = [];
                    const featuresData = [];
                    const youtubelink = [];
                    const faq = [];
                    const specification = [];
                    const single_gallery = [];
                    const sidebar=[]
                    const compareProduct=[]
                    const slider_gallery=[]
                    const review=[]
                    this.mapData.main_gallery.forEach((item) => {
                        imagee.push(item);
                        // console.log('consoleee',item);
                    });
                    this.mapData.features.forEach((item) => {
                        featuresData.push(item);
                        // console.log('consoleee',item);specification
                    });
                    this.mapData.youtubelink.forEach((item) => {
                        youtubelink.push(item);
                        // console.log('consoleee',item);
                    });
                    this.mapData.faq.forEach((item) => {
                        faq.push(item);
                        // console.log('consoleee',item);
                    });
                    this.mapData.specification.forEach((item) => {
                        specification.push(item);
                        // console.log('consoleee',item);
                    });
                
                    this.mapData.single_gallery.forEach((item) => {
                        single_gallery.push(item);
                        // console.log("99999999999", item);
                    });
                    this.mapData.sidebar.forEach((item) => {
                        sidebar.push(item);
                        // console.log("99999999999", item);
                    });
                    this.mapData.compareProduct.forEach((item) => {
                        compareProduct.push(item);
                        // console.log("99999999999", item);
                    });
                    
                    this.mapData.slider_gallery.forEach((item) => {
                        slider_gallery.push(item);
                        // console.log(slider_gallery,'ddd')
                    });
                    this.mapData.review.forEach((item) => {
                        review.push(item);
                        console.log("review", item);
                    });

                    // console.log(imagee[0]);
                    this.imageData = imagee;
                    this.features = featuresData;
                    this.youtubelink = youtubelink;
                    this.faq = faq;
                    this.specification = specification;
                    this.single_gallery = single_gallery;
                    this.sidebar = sidebar;
                    this.compareProduct = compareProduct;
                    this.slider_gallery = slider_gallery;
                    this.review=review
                    // console.log( this.compareProduct,'pratik');
                    // console.log("data.result", this.mapData.main_gallery[0]);
                    // if (res.data.result.length == 0) {
                    //     // console.log("iff sidebar")
                    // } else {
                    //     this.youtubelink = res.data.result.youtubelink;
                    // }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        const url = new URL(window.location.href);
        let id = url.pathname
            .split("/")
            .filter((part) => part !== "")
            .pop();
        const isNum = /^\d+$/.test(id);
        console.log(isNum);
        if (isNum) {
            this.getFormDataW(id);
            console.log("@@@@@@@@@@@dddddddddddddddd", id);
        }
    },
};
</script>

<style scoped>
.unedited {
    color: #0096d9;
    font-size: 32px;
    font-weight: 600;
}
.unedi-ted {
    text-align: center;
    font-weight: 600;
    margin-top: 30px;
    margin-bottom: 43px;
}
.here {
    text-align: center;
    font-size: 15px;
}
.sideBarMarginTop{
    margin-top: 125px;
}
</style>
