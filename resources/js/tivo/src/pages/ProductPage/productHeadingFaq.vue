<template>
    <div
        class="row default-according style-1 faq-accordion accor"
        id="accordionoc"
    >
        <div v-if="specification.length > 0">
            <div
                class="container accordion"
                v-for="(item, index) in specification"
                :key="index"
                :class="{ 'image-right': item.image_position === 'right' }"
            >
                <div class="image-container">
                    <img
                    :src="`http://localhost:8001/storage/${item.image_url}`"
                        :alt="item.title"
                    />
                    <!-- {{ console.log(`http://localhost:8001/storage/${item.image_url}`) }} -->
                </div>
                <div class="data-container">
                    <span class="item-title">{{ item.title }}</span>
                    <div class="accordion">
                        <div
                            v-for="(innerItem, i) in item.subspecification"
                            :key="i"
                        >
                            <div class="card">
                                <div class="card-header" style="display: flex">
                                    <img
                                        class=""
                                        style="width: 12%; margin: 0"
                                        @click="open3(innerItem.id)"
                                        :aria-expanded="
                                            show3 === innerItem.id
                                                ? 'true'
                                                : 'false'
                                        "
                                        :aria-controls="`collapseicon${innerItem.id}`"
                                        v-if="
                                            innerItem.icon &&
                                            innerItem.icon.length > 0
                                        "
                                        :src="`http://localhost:8001/storage/${innerItem.icon}`"
                                        :alt="
                                            innerItem.image_name
                                                ? innerItem.image_name
                                                : 'Product Image'
                                        "
                                    />
                                    <h5 class="mb-0">
                                        <button
                                            class="btn btn-link collapsed"
                                            @click="open3(innerItem.id)"
                                            :aria-expanded="
                                                show3 === innerItem.id
                                                    ? 'true'
                                                    : 'false'
                                            "
                                            :aria-controls="`collapseicon${innerItem.id}`"
                                        ></button>
                                        <span
                                            class="tittle"
                                            @click="open3(innerItem.id)"
                                            :aria-expanded="
                                                show3 === innerItem.id
                                                    ? 'true'
                                                    : 'false'
                                            "
                                            :aria-controls="`collapseicon${innerItem.id}`"
                                        >
                                            {{ innerItem.sub_title }}
                                        </span>
                                    </h5>
                                </div>
                                <div
                                    class="collapse des-cription"
                                    :id="`collapseicon${innerItem.id}`"
                                    data-bs-parent="#accordionoc"
                                    :class="
                                        show3 === innerItem.id ? 'show' : ''
                                    "
                                >
                                    {{ innerItem.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>No data to display.</div>
    </div>
</template>

<script>
export default {
    props: {
        specification: Array,
    },
    data() {
        return {
            show3: null,
        };
    },
    methods: {
        open3(id) {
            if (this.show3 === id) {
                this.show3 = null;
            } else {
                this.show3 = id;
            }
        },
    },
};
</script>

<style scoped>
.container {
    display: flex;
    align-items: center;
}

.image-container{
    flex: 1;
    margin-top: 32px;
}

.image-container img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.data-container {
  flex: 1;
  padding: 20px;
}

.data-container h2 {
    font-size: 24px;
    margin-bottom: 15px;
}
.card {
    margin-bottom: 10px !important;
    box-shadow: none !important;
    overflow: hidden;
}

.dddddddddd {
    width: 12%;
}
.image-right {
    flex-direction: row-reverse;
}

.accordion-btn {
    background-color: #f9f9f9;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: background-color 0.2s;
}

.accordion-btn.active {
    background-color: #ddd;
}

.accordion-content {
    display: none;
    padding: 20px;
}

.accordion-content.active {
    display: block;
}
.item-title {
    font-size: 20px;
    font-weight: 600;
    color: #0096d9;
}
.accordion {
    margin-top: 20px;
}
.des-cription {
    padding: 10px;
}
</style>
