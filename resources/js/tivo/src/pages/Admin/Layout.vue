<template>
  <div>
      <breadCrumbs :title="title" :main="main" />

      <div>
          <div
              class="drop-zone"
              @drop="onDrop($event, 1)"
              @dragenter.prevent
              @dragover="onDragOver"
              ref="scrollContainer"
          >
              <div
                  v-for="item in getList(1)"
                  :key="item.id"
                  class="drag-el"
                  draggable="true"
                  @mousedown="onMouseDown($event, item)"
                  @dragstart="onDragStart($event, item)"
                  @drop="onItemDrop($event, item)"
              >
                  {{ item.title }}
                  <!-- <button class="btn btn-primary btn-sm" @click="duplicateItem(item)">
            Duplicate
          </button> -->
              </div>
          </div>
          <div class="d-flex justify-content-center">
              <button class="btn btn-primary" @click="saveChanges">
                  Save
              </button>
          </div>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import breadCrumbs from "../../layout/breadCrumbs.vue";
import { ref, onMounted } from "vue";
import config from "../../config";

export default {
  components: {
      breadCrumbs,
  },
  data() {
      return {
          main: "Layout",
          title: "Layout Sequence",
          items: [],
      };
  },
  methods: {
      onDragOver(event) {
          event.preventDefault();
          const scrollContainer = this.$refs.scrollContainer;
          const { clientY, offsetHeight, scrollTop } = event;
          const scrollThreshold = 20;

          if (clientY - scrollTop < scrollThreshold) {
              scrollContainer.scrollTop -= scrollThreshold;
          } else if (offsetHeight - (clientY - scrollTop) < scrollThreshold) {
              scrollContainer.scrollTop += scrollThreshold;
          }
      },
      getList(list) {
          return this.items.filter((item) => item.list === list);
      },
      onDragStart(event, item) {
          event.dataTransfer.effectAllowed = "move";
          event.dataTransfer.setData("text/plain", "");
          this.$data.draggedItem = item;
      },
      onItemDrop(event, item) {
          event.preventDefault();
          const dropIndex = this.items.findIndex((i) => i.id === item.id);
          const draggedIndex = this.items.findIndex(
              (i) => i.id === this.$data.draggedItem.id
          );
          this.items.splice(draggedIndex, 1);
          this.items.splice(dropIndex, 0, this.$data.draggedItem);
          this.$data.draggedItem = null;
      },
      onDrop(event, list) {
          event.preventDefault();
      },
      onDragOver(event) {
          event.preventDefault();
      },
      onMouseDown(event, item) {
          this.$data.draggedItem = item;
      },
      saveChanges() {
          console.log(this.items,'dd')
          const newData = this.items.map((item, index) => ({
              // id: item.id,
              myproduct_table: item.title,
              // order_id:  Number(item.order) + Math.floor(Math.random() * 10),
              order_id:index+1 ,
              parent_id: item.sequence,
              // order: index + 1,
              // list: 1,
          }));

          const token = localStorage.getItem("token");
          axios
              .post(`${config.apiUrl}/api/my-product-sequence`, newData, {
                  headers: {
                      Authorization: `Bearer ${token}`,
                  },
              })
              .then((response) => {
                  console.log("Changes saved:", response.data);
                  this.fetchLabels()
                  // this.$router.push(`/layout-form`);
                  window.location.reload();

              })
              .catch((error) => {
                  console.error(error);
              });
      },  
      duplicateItem(item) {
          console.log(item);
          const duplicatedItem = {
              id: this.items.length + Math.floor(Math.random() * 10),
              title: item.title,
              list: item.list,
              order: Number(item.order) + Math.floor(Math.random() * 10),
              parent_id: item.sequence,
          };
          console.log(duplicatedItem, "dddd");
          this.items.push(duplicatedItem);
      },
      fetchLabels() {
          const token = localStorage.getItem("token");
          axios
              .get(`${config.apiUrl}/api/my-product-get-sequnece`, {
                  headers: {
                      Authorization: `Bearer ${token}`,
                  },
              })
              .then((response) => {
                  this.items = response.data.result.map((item) => ({
                      id: item.id,
                      title: item.myproduct_table,
                      order: item.order_id,
                      sequence: item.sequence_id,
                      list: 1,
                  }));
              })
              .catch((error) => {
                  console.error(error);
              });
      },
  },
  mounted() {
      this.fetchLabels();
  },
};
</script>

<style scoped>
.drop-zone {
  width: 500px;
  min-height: 200px;
  background-color: #f2f2f2;
  border: 2px dashed #ccc;
  padding: 10px;
  margin: 20px auto;
}

.drag-el {
  background-color: #3498db;
  color: #fff;
  padding: 10px;
  margin-bottom: 10px;
  cursor: move;
}

.drag-el:hover {
  background-color: #2980b9;
}

button {
  margin-top: 10px;
  padding: 8px 16px;
  background-color: #3498db;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-align: center;
}

button:hover {
  background-color: #2980b9;
}
</style>
