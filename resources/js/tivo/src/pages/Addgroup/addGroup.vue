<template>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Form object Type Groups
          </h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label class="form-label f-w-500">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Name" :value="object" />
            </div>
            <div class="mb-3">
              <label class="form-label f-w-500">Form Object Types</label>
              <select class="form-control" id="exampleInputEmail2" aria-label="Default select example">
                <option selected value="">Form Object Types</option>
                <option v-for="data in apiRes" :value="data.id">
                  {{ data.name }}
                </option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
            Close
          </button>
          <button class="btn btn-secondary" @click="addProduct" type="button">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive theme-scrollbar data-table">
      <div class="row col-sm-12">
        <div class="col-sm-6">
          <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test"
            data-bs-target="#exampleModal">
            Create Lead
          </button>
        </div>
        <div class="mb-3 col-sm-6 row justify-content-end">
          <label for="table-complete-search" class="col-xs-3 col-sm-auto col-form-label">Search:</label>
          <div class="col-xs-3 col-sm-auto">
            <input id="table-complete-search" type="text" @keyup="filter()" class="form-control" v-model="filterQuery" />
          </div>
        </div>
      </div>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col" sortable="name">S/n</th>
            <th scope="col" sortable="name">Id</th>
            <th scope="col" sortable="name">form object type</th>
            <th scope="col" sortable="invoice">form object group</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(data, index) in mapData" :key="data.id">
            <td>{{ index + 1 }}</td>
            <td>{{ data.id }}</td>
            <td>{{ data.form_object_type_id }}</td>
            <td>{{ data.name }}</td>
            <td class="d-flex justify-content-center">
              <div>
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                  data-bs-target="#exampleModal" @click="edit(data.id)">
                  <i className="fa fa-pencil-square-o fa-lg"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  <i className="fa fa-eye fa-lg"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger">
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
import axios from "axios";
export default {
  data() {
    return {
      EditOption: null,
      object: "",
      filterQuery: "",
      selectedValue: null,
      mapData: null,
    };
  },
  methods: {
    addProduct() {
      let objectgroup = document.getElementById("exampleInputEmail1");
      let objectgroup1 = document.getElementById("exampleInputEmail2");
      // console.log(objectgroup1.value,'objectgroup1');
      // console.log(objectgroup,'objectgroup');
      let data = {
        name: objectgroup.value,
        form_object_types: objectgroup1.value,
      };
      console.log("data check", data);

      let token = localStorage.getItem("token");

      let promise = axios.post(
        "http://localhost:8000/api/form-object_type-groups/",
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
            console.log("deepakram", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
    getData() {
      console.log("fffffff");
      let token = localStorage.getItem("token");

      let promise = axios.get(
        "http://localhost:8000/api/form-object_type-groups",

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
            console.log("hhhh", d.data.result.data);
          })
          .catch((e) => {
            //console.log("ttttttttt", e);
            // this.error = e.response.data.errors;
          });
      };
      consumer();
    },
  },
  getList() {
    let token = localStorage.getItem("token");
    axios
      .get("http://localhost:8000/api/form-object-types-list", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((res) => {
        this.apiRes = res.data.result;
      })
      .catch((error) => {
        console.error(error);
      });
  },
  edit(data) {
    this.EditOption = true;
    let token = localStorage.getItem("token");

    let promise = axios.get(
      `http://localhost:8000/api/form-object_types/${data}`,
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
  mounted() {
    this.getData();
    // this.edit();
  }
};

</script>