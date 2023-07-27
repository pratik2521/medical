<template>
    <div class="col-lg-12">
        <div class="header-faq">
            <h2 class="mb-0 text-center">Frequently Asked Questions</h2>
        </div>
        <div
            class="row default-according style-1 faq-accordion accor"
            id="accordionoc"
        >
            <div class="col-xl-12 asked-qustion">
                <div class="bottom-gap" v-for="item in faq" :key="item.id">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button
                                    class="btn btn-link collapsed"
                                    @click="open3(item.id)"
                                    :aria-expanded="
                                        show3 === item.id ? 'true' : 'false'
                                    "
                                    :aria-controls="`collapseicon${item.id}`"
                                >
                                    {{ item.title }}
                                </button>
                            </h5>
                        </div>
                        <div
                            class="collapse"
                            :id="`collapseicon${item.id}`"
                            data-bs-parent="#accordionoc"
                            :class="show3 === item.id ? 'show' : ''"
                        >
                            <div class="card-body">
                                <p>{{ item.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        faq: {
            type: Array,
            required: true,
            default: () => [],
        },
    },
    components: {},
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
.accor {
    display: flex;
    justify-content: center;
}
.asked-qustion {
    margin-top: 28px;
}
.bottom-gap {
    margin-bottom: 10px;
}
</style>
