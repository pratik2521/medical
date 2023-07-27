<template>
    <div class="col-lg-12">
        <div class="header-faq">
            <span class="blue-c"> Frozen 2<sup class="sup-tma">™</sup></span>
            Cold Plunge Features
        </div>
        <div
            class="row default-according style-1 faq-accordion accor"
            id="accordionoc"
        >
            <div class="col-xl-12">
                <div class="bottom-gap" v-for="item in features" :key="item.id">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0" style="display: flex">
                                <button
                                    class="btn btn-link collapsed image-toggle"
                                    data-bs-toggle="collapse"
                                    :data-bs-target="`#collapseicon${item.id}`"
                                    :aria-expanded="
                                        activeItem === item.id
                                            ? 'true'
                                            : 'false'
                                    "
                                    :aria-controls="`collapseicon${item.id}`"
                                    @click="toggleAccordion(item.id)"
                                >
                                    <img
                                        v-if="
                                            item.icon_path &&
                                            item.icon_path.length > 0
                                        "
                                        :src="`http://localhost:8000/storage/${item.icon_path}`"
                                        :alt="
                                            item.image_name
                                                ? item.image_name
                                                : 'Product Image'
                                        "
                                        class="featureImage"
                                    />
                                </button>
                                <span
                                    class="tittle"
                                    @click="open3(item.id)"
                                    :aria-expanded="
                                        show3 === item.id ? 'true' : 'false'
                                    "
                                    :aria-controls="`collapseicon${item.id}`"
                                >
                                    {{ item.title }}
                                </span>
                            </h5>
                        </div>
                        <div
                            class="collapse"
                            :id="`collapseicon${item.id}`"
                            data-bs-parent="#accordionoc"
                            :class="show3 === item.id ? 'show' : ''"
                        >
                            <div class="card-body">
                                {{ item.description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assuming that these are other components -->
                <!-- <intellectualProperty />
          <sellingAccording />
          <navigationView /> -->
            </div>
        </div>
    </div>
</template>

<script>
import config from "../../config";

export default {
    props: {
        features: {
            type: Array,
            required: true,
            default: () => [],
        },
    },

    data() {
        return {
            desc: "",
            show3: null, // Change the initial value to null
        };
    },

    methods: {
        open3(id) {
            if (this.show3 === id) {
                this.show3 = null; // Close the accordion item if it's already open
            } else {
                this.show3 = id; // Open the clicked accordion item
            }
        },

        methods: {
            open3(id) {
                // Toggle the accordion state for the clicked item
                if (this.show3 === id) {
                    this.show3 = null; // Close the accordion item if it's already open
                } else {
                    this.show3 = id; // Open the clicked accordion item
                }
            },
        },
    },
};
</script>

<style scoped>
.image-toggle {
    width: 15% !important;
    margin-top: 12px;
}
.tittle {
    margin-top: 15px;
    cursor: pointer;
}
.bottom-gap {
    margin-bottom: 10px;
}
.blue-c {
    color: #0096d9;
}
.sup-tma {
    margin-left: -2px;
    font-size: 19px !important;
    vertical-align: middle;
    font-weight: 800;
}
.header-faq {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 20px;
}
.featureImage{
    max-width: 53px;
    margin-top: 0px;
}
</style>
