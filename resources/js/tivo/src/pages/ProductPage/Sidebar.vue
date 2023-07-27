<template>
    <div class="col-lg-12 mt-14">
        <div class="header-faq">
            <!-- <h3 class="mainheading">Frozen 2™ Cold Plunge Features :</h3> -->
        </div>
        <div v-for="item in sidebar" class="sidebarStyle">
            <img
                class="imageclass2"
                v-if="item.icon_path && item.icon_path.length > 0"
                :src="`http://localhost:8000/storage/${item.icon_path}`"
                :alt="item.title ? item.title : 'Product Image'"
            />
            <span class="marginHeading">{{ item.title }}</span>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        sidebar: {
            type: Array,
            required: true,
            default: () => [],
        },
    },
};
</script>
<style>
.sidebarStyle {
    /* margin-top: 124px; */
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}
.imageclass2 {
    width: 20% !important ;
    margin: 0px 0px 5px 3px !important;
     /* border-radius: 10px;  */
}
.marginHeading {
    margin-left: 19px;
    font-size: 17px;
    font-weight: 200;
}
.mainheading {
    margin-top: 13px;
    font-size: 23px;
    /* / font-weight: 700; / */
    /* / margin-bottom: 30px; / */
}
</style>
