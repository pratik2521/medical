<template>
    <div class="product-details tr5_carousel">
        <div class="nagar col-md-12 row">
            <div class="col-md-6">
                <div
                    class="col-md-6"
                    v-for="(item, index) in imageData"
                    :key="index"
                >
                    <div class=""  v-if="index === 0">
                        <img
                            :src="`http://localhost:8001/storage/${item.image_path}`"
                            :alt="`Product Image`"
                            class="SlderImage"
                            :id="`product-slider`"
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p class="product-name">Product Name: {{ mapData.name }}</p>
                <div style="margin-bottom: 10px">
                    <span class="product-name"
                        >Product Price: ${{ mapData.product_price }}</span
                    >
                </div>
                <div>
                    <span class="product-name"
                        >Product Discount: ${{ mapData.product_discount }}</span
                    >
                </div>
            </div>
            <!--  -->
            <div class="product-thumbnails">
                <div class="d-flex justify-content-start">
                    <div
                        v-for="(item, index) in imageData"
                        :key="index"
                        class="thumbnail me-2"
                    >
                        <img
                            v-if="item.image_path && item.image_path.length > 0"
                            :src="`http://localhost:8001/storage/${item.image_path}`"
                            :alt="index"
                            class="thumbnail-image"
                            @click="selectThumbnail(index, item)"
                            :class="{ active: index === selectedThumbnail }"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import config from "../../config";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";

export default {
    name: "ProductDetails",
    props: {
        mapData: {
            type: Object,
            required: true,
            default: () => ({}),
        },
        imageData: {
            type: Array,
            required: true,
            default: () => [],
        },
    },
    data() {
        return {
            selectedThumbnail: 0,
            storeSlderImage:
                this.imageData && this.imageData.length > 0
                    ? this.imageData[0]
                    : {},
        };
    },

    methods: {
        selectThumbnail(index, item) {
            console.log("888888888888", item);
            this.storeSlderImage = item;
            this.selectedThumbnail = index;

            let slider = document.getElementById("product-slider");
            console.log(" let slider", slider);
            slider.src = "http://localhost:8001/storage/" + item.image_path;
        },
        selectNextThumbnail() {
            this.selectedThumbnail =
                (this.selectedThumbnail + 1) % this.imageData.length;
            const slider = document.getElementById(
                `product-slider-${this.selectedThumbnail}`
            );
            const carousel = new bootstrap.Carousel(slider, {});
        },
    },
};
</script>
<style scoped >
.product-details {
    display: flex;
    flex-direction: column;
}

.thumbnail {
    display: inline-block;
}
.thumbnail-image.active {
    border: 2px solid #007bff;
}
.thumbnail-image {
    width: 75px !important;
    height: auto;
    cursor: pointer;
    opacity: 0.6;
}

.thumbnail-image.active {
    opacity: 1;
}
.SlderImage {
    width: 100%;
    margin-left: 36px;
    margin-bottom: 50px;
}
.carousel-control-next,
.carousel-control-prev {
    width: 2% !important;
}

.images {
    max-width: 882px !important;
}

.store-image {
    font-size: 20px;
    font-weight: 600;
}
.product-name {
    font-size: 20px;
    font-weight: 600;
    color: #373333;
}
</style>
