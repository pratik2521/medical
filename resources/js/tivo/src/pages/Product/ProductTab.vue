<template>
      <breadCrumbs :title="title" :main="main" />
  <div class="col-sm-12 col-xl-12">
            <div class="card basic-tab">
              <div class="card-header pb-0">
                <!-- <h4>Basic Tabs</h4> -->
              </div>
              <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                  <li class="nav-item"><a class="nav-link active" id="product-tab" data-bs-toggle="tab" href="#product" role="tab" aria-controls="product" aria-selected="true">Product Details</a></li>
                  <li class="nav-item"><a class="nav-link " id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Product Price</a></li>
                 
                 
                  <li class="nav-item"><a class="nav-link" id="profile-tabs" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Update Ship Price</a></li>
                  <li class="nav-item"><a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Update Attribute(features,groupons,colors)</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
                    <!-- <ProductForm/> -->
                    <ProductDetails/>
                  </div>
                  <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                    <ProductPriceForm/>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <UpdateShipPrice/>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                   <UpdateAttribute/>
                  </div>
                </div>
              </div>
            </div>
          </div>
</template>
<script>
  import breadCrumbs from "../../layout/breadCrumbs.vue"
  import ProductPriceForm from './ProductPriceForm.vue'
  import ProductForm from './ProductFrom.vue'
  import UpdateShipPrice from './UpdateShipPrice.vue'
  import UpdateAttribute from './UpdateAttribute.vue'
import ProductDetails from './ProductDetails.vue'

//   import ProductPriceForm from "../pages/Product/ProductPriceForm.vue"
// import LeadForm from '../Lead/LeadForm.vue';
  

export default {
    components: {
      breadCrumbs,
      ProductPriceForm,
      UpdateShipPrice,
      UpdateAttribute,
      ProductForm,
      ProductDetails

      // LeadForm
    //   Paginations
    },
  data(){
      return{
        main: "Edit Product",
        title: " Edit Product Data",
      }
  },

}
</script>
<style>
 .nav-link.active {
   
    background-color: #5c61f2!important;
    color: white !important;;
}

</style>