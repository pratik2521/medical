<template>
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <div class="product-info">
          <div>
            <h6>Select Compare Product (Maxmium only 3)</h6>
            <label for="dropdown">Dropdown:</label>
            <select class="form-control" id="dropdown" v-model="selectedOptions" multiple @change="limitSelection">
              <!-- <option value="">Select Compare Product  </option> -->
              <option v-for="option in dropdownOptions" :value="option.id" :key="option.id">
                {{ option.name }}
              </option>
            </select>
          </div>
          <button class="btn btn-primary radius mt-4 " @click="postData">Submit</button>
        </div>
        <p>Selected Options Value: {{ selectedOptions }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import config from "../../config";

export default {
  data() {
    return {
      dropdownOptions: "",
      selectedOptions: [],
      parentId: null
    };
  },

  mounted() {
    const url = new URL(window.location.href);
    const id = url.pathname.split("/").pop();
    const isNum = /^\d+$/.test(id);
    if (isNum) {
      this.parentId = id;
      this.fetchDropdownData(id);
    }
  },

  methods: {
    fetchDropdownData(id) {
      let token = localStorage.getItem("token");
      axios
        .get(`${config.apiUrl}/api/my-product-get-feature-compare/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.dropdownOptions = response.data.result.map(option => ({
            id: option.id,
            name: option.name
          }));
        })
        .catch(error => {
          console.error(error);
        });
    },

    limitSelection() {
      if (this.selectedOptions.length > 3) {
        this.selectedOptions = this.selectedOptions.slice(0, 3);
      }
    },

    postData() {
      let token = localStorage.getItem("token");
      let data = this.selectedOptions.map(optionId => ({
    my_product_with_id: optionId,
    parent_id: this.parentId
  }));
// console.log(data,'data')
      axios
        .post(`${config.apiUrl}/api/my-product-compares-features`, data, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json"
          }
        })
        .then(response => {
          console.log(response.data);
          this.selectedOptions=[]
          window.location.reload();

          // Handle success response
        })
        .catch(error => {
          console.error(error);
          // Handle error
        });
    }
  }
};
</script>

<style scoped>
#dropdown {
  height: 200px; /* Set the desired height */
  overflow-y: auto; /* Enable vertical scrolling */
}
</style>
