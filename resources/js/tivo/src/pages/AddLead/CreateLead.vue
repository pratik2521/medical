<template>
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Object Type</h5>
          <button
            class="btn-close"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Object Types</label>
              <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder="Enter Object Type"
                :value="object"
                :disabled="viewOption != null"
              />
              <span class="text-danger">{{
                        errors.name ? errors.name[0] : ""
                      }}</span>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
            Close
          </button>
          <button
            v-if="EditOption == null"
            class="btn btn-secondary"
            type="button"
            @click="formSubmit()"
          >
            Save
          </button>
          <button
            v-if="EditOption != null"
            class="btn btn-secondary"
            type="button"
            @click="formUpdate()"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive theme-scrollbar data-table">
      <button
        class="btn btn-primary"
        type="button"
        data-bs-toggle="modal"
        data-original-title="test"
        data-bs-target="#exampleModal"
      >
        Create Lead
      </button>

      <div class="mb-3 row justify-content-end">
        <label
          for="table-complete-search"
          class="col-xs-3 col-sm-auto col-form-label"
          >Search:</label
        >
        <div class="col-xs-3 col-sm-auto">
          <input
            id="table-complete-search"
            type="text"
            @keyup="filter()"
            class="form-control"
            v-model="filterQuery"
          />
        </div>
      </div>
      <table class="table table-striped table-bordered text-center">
        <thead>
          <tr>
            <th>S/n</th>
            <th>Id</th>
            <th>Object Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(data, index) in mapData" :key="data.id">
            <td>{{ index + 1 }}</td>
            <td>{{ data.id }}</td>
            <td>{{ data.name }}</td>

            <td class="d-flex justify-content-center">
              <div>
                <button
                  type="button"
                  class="btn btn-sm btn-outline-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  @click="edit(data.id)"
                >
                  <i className="fa fa-pencil-square-o fa-lg"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-sm btn-outline-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#exampleModal"
                  @click="viewForm(data.id)"
                >
                  <i className="fa fa-eye fa-lg"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-sm btn-outline-danger"
                  @click="deleteForm(data.id)"
                >
                  <i className="fa fa-trash-o fa-lg"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import config from '../../config';

import axios from "axios";

export default {

  data() {
    return {

      EditOption: null,
      viewOption: null,
      object: "",
      filterQuery: "",
      mapData: null,
     errors:{
        name:''
     }
    };
  },
  methods: {
    filter() {
      let query = this.filterQuery;
      let token = localStorage.getItem("token");

      let promise = axios.get(
        `${config.apiUrl}/api/form-object_types?search=${query}`,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            // console.log("hhhh", d.data.result.data);
            this.mapData = d.data.result.data;
          })
          .catch((e) => {
            console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
    formSubmit() {
      let gg = document.getElementById("exampleInputEmail1");
      let data = {
        name: gg.value,
      };

      let token = localStorage.getItem("token");

      let promise = axios.post(
        config.apiUrl + '/api/form-object_types',
        data,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            console.log("hhhh", d);
            this.getData();
          })
          .catch((e) => {
            console.log("ttttttttt", e.response.data.errors);
            this.errors = e.response.data.errors;
          });
      };
      consumer();
    },
    getData() {
      console.log("fffffff");
      let token = localStorage.getItem("token");

      let promise = axios.get(
        config.apiUrl + '/api/form-object_types',

        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            //console.log("hhhh", d.data.result.data);
            this.mapData = d.data.result.data;
          })
          .catch((e) => {
            //console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
    edit(data) {
      this.EditOption = data;
      let token = localStorage.getItem("token");

      let promise = axios.get(
        `${config.apiUrl}/api/form-object_types/${data}`,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            console.log("hhhh", d.data.result.name);
            this.object = d.data.result.name;
          })
          .catch((e) => {
            console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
    formUpdate() {
      console.log("fffffff");
      let gg = document.getElementById("exampleInputEmail1");
      let datas = {
        name: gg.value,
      };

      let token = localStorage.getItem("token");

      let promise = axios.put(
        `${config.apiUrl}/api/form-object_types/${this.EditOption}`,
        datas,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            console.log("hhhh", d);
            this.getData();
          })
          .catch((e) => {
            console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
            this.errors = e.response.data.errors;
          });
      };
      consumer();
    },
    deleteForm(id) {
      if (confirm("Do you really want to delete?")) {
        let token = localStorage.getItem("token");

        let promise = axios.delete(
          `${config.apiUrl}/api/form-object_types/${id}`,

          {
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
          }
        );
        const consumer = () => {
          promise
            .then((d) => {
              console.log("hhhh", d);
              this.getData();
            })
            .catch((e) => {
              console.log("ttttttttt", e);
              // this.error = e.response.data.errors;
            });
        };
        consumer();
      }
    },
    viewForm(id) {
      this.viewOption = id;
      let token = localStorage.getItem("token");

      let promise = axios.get(
        `${config.apiUrl}/api/form-object_types/${id}`,
        {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      const consumer = () => {
        promise
          .then((d) => {
            console.log("hhhh", d.data.result.name);
            this.object = d.data.result.name;
          })
          .catch((e) => {
            console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
  },
  mounted() {

    this.getData();
    this.edit();
  },
};
</script>
<style></style>
