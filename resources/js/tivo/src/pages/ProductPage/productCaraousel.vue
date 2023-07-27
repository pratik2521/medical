<template>
    <div class="carousel">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="item in review" :key="item.id">
                    <div class="card review-br">
                        <p class="rating-bar">
                            <span class="jenna">{{ item.user_name }}</span>
                        </p>
                        <p style="font-size: 20px" class="rating-bar">
                            <u style="text-decoration: none">
                                <span
                                    v-html="generateRatingStars(item.rating)"
                                    class="star-container"
                                ></span>
                            </u>
                            <br />
                        </p>
                        <p class="rating-bar">
                            <span class="spring">{{ item.location }}</span>
                        </p>
                        <p class="dolor rating-bar">{{ item.review }}</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div
            class="swiper-button-prev"
            @click="prevSlide"
            v-if="showPrevButton"
        >
            &#10094;
        </div>
        <div
            class="swiper-button-next"
            @click="nextSlide"
            v-if="showNextButton"
        >
            &#10095;
        </div>
    </div>
</template>

<script>
import Swiper from "swiper";
export default {
    props: {
        review: {
            type: Array,
            required: true,
            default: () => [],
        },
    },

    data() {
        return {
            swiperInstance: null,
        };
    },
    mounted() {
        this.initSwiper();
    },

    destroyed() {
        if (this.swiperInstance) {
            this.swiperInstance.destroy();
        }
    },
    computed: {
        showPrevButton() {
            return this.review.length > 0;
        },
        showNextButton() {
            return this.review.length > 1;
        },
    },
    methods: {
        generateRatingStars(rating) {
            const numStars = 5;
            let starsHtml = "";
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating - fullStars >= 0.5;
            for (let i = 0; i < fullStars; i++) {
                starsHtml += '<i class="fa fa-star b-c star-full"></i>';
            }
            if (hasHalfStar) {
                starsHtml += '<i class="fa fa-star b-c star-half"></i>';
            }
            for (
                let i = 0;
                i < numStars - fullStars - (hasHalfStar ? 1 : 0);
                i++
            ) {
                starsHtml += '<i class="fa fa-star-o b-c star-empty"></i>';
            }
            return starsHtml;
        },
        initSwiper() {
            this.$nextTick(() => {
                this.swiperInstance = new Swiper(".swiper-container", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    pagination: {
                        el: ".swiper-pagination",
                    },
                });
                console.log("swiperInstance", this.swiperInstance);
            });
        },
        prevSlide() {
            if (this.swiperInstance) {
                this.swiperInstance.slidePrev();
            }
        },

        nextSlide() {
            if (this.swiperInstance) {
                this.swiperInstance.slideNext();
            }
        },
    },
};
</script>
<style>
.swiper-container {
    margin-top: 50px;
    display: flex;
    overflow: hidden;
    width: 100%;
}

.swiper-wrapper {
    display: flex;
    margin-right: 20px;
    transition: transform 0.3s ease-in-out;
}

.swiper-slide {
    flex: 0 0 294px;
}
.swiper-container::-webkit-scrollbar {
    width: 0;
    height: 0;
}
.star-full {
    color: #0096d9;
}
.swiper-container {
    display: flex;
    overflow: hidden;
    width: 100%;
}
.swiper-button-prev,
.swiper-button-next {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    cursor: pointer;
    user-select: none;
    width: 30px;
    height: 30px;
    position: absolute;
    top: 45%;
    transform: translateY(-50%);
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 50%;
}

.swiper-button-prev {
    left: -27px;
    font-size: 15px;
}

.swiper-button-next {
    right: -22px;
    font-size: 15px;
}

.star-half {
    position: relative;
    color: #0096d9;
    width: 0.5em;
    overflow: hidden;
}

.star-half:before {
    content: "\f089";
    position: absolute;
    left: 0;
}

.star-empty {
    color: #ccc;
}
.review-br {
    padding: 18px;
    border-radius: 26px;
    border: 4px solid #011f27;
}
.jenna {
    font-weight: 600;
    font-size: 18px;
}
.rating-bar {
    margin-bottom: 8px;
}
</style>
