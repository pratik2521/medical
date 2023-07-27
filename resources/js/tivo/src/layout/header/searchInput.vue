<template>
     <div class="serchbox"><i data-feather="search"><vue-feather type="search" @click="collapseFilter()"></vue-feather></i></div>
                <div class="form-group search-form" :class="filtered?'open':''">
                  <input class="form-control" type="text" placeholder="Search Here........">
                </div>
</template>
<script>
export default {
    data () {
      return {
        filtered: false,
      };
    },
      methods: {
     collapseFilter() {
        this.filtered = !this.filtered;
      },
      }
}
</script>