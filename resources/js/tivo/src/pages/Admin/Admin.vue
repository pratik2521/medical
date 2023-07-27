<template>
    <breadCrumbs :title="title" :main="main" />
    <div class="col-sm-12">
        <div class="card">
            <div style="text-align: right"></div>
            <div class="card-body">
                <div class="col-md-12 rowData">
                    <div class="col-md-6">
                        <button
                            style="margin-bottom: 20px"
                            class="btn btn-primary radius"
                            type="button"
                            @click="addLead()"
                        >
                            Add Product
                        </button>
                        <button
                            style="margin-bottom: 20px"
                            class="btn btn-primary ml-4 radius"
                            type="button"
                            @click="layout()"
                        >
                            Layout
                        </button>
                    </div>
                    <div class="mb-3 col-md-6 rowData justify-content-end">
                        <label
                            for="table-complete-search"
                            class="col-xs-3 col-sm-auto col-form-label colFormLabel"
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
                </div>
                <div class="table-responsive theme-scrollbar data-table">
                    <table
                        class="table table-striped table-bordered"
                        v-if="mapData != null"
                    >
                        <thead>
                            <tr>
                                <th scope="col" v-for="tt in keyValue">
                                    {{ tt }}
                                </th>
                                <!-- <th scope="col">Convert</th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in mapData" :key="data.id">
                                <!-- {{console.log(data,'pppp')}} -->
                                <td
                                    style="text-transform: capitalize"
                                    v-for="(ir, i, u) in data"
                                    :key="u"
                                    v-if="u !== '0'"
                                >
                                    <div v-if="i != 'is_convert'">
                                        {{
                                            i == "id"
                                                ? (pagination.current_page -
                                                      1) *
                                                      pagination.per_page +
                                                  1 +
                                                  index
                                                : ir
                                        }}
                                    </div>
                                    <div v-if="i == 'is_convert'">
                                        <div v-if="ir == null">
                                            Not converted
                                        </div>
                                        <div v-if="ir == 1">converted</div>
                                    </div>
                                </td>

                                <!-- <td>

                                    <div class="flex-grow-1 text-end icon-state">

                                        <button @click="convert1111(data.id)" :disabled="data.is_convert == 1" class="btn btn-primary display" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#exampleModal">
                                            Convert
                                        </button>

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Do you really want to convert?
                                                        </h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="button" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button data-bs-dismiss="modal" class="btn btn-secondary" type="button" @click="convert(convertId)">
                                                            Convert
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td> -->
                                <td>
                                    <div class="icons d-flex">
                                        <div>
                                            <i
                                                className="fa fa-pencil-square-o fa-lg"
                                                @click="EditForm(data.id)"
                                            ></i>
                                        </div>
                                        <!-- <div>
                                          <i className="fa fa-eye fa-lg" @click="ViewForm(data.id)"></i>
                                        </div> -->
                                        <div>
                                            <i
                                                className="fa fa-trash-o fa-lg"
                                                @click="DeleteForm(data.id)"
                                            ></i>
                                        </div>
                                        <div>
                                            <i
                                                className="fa fa-eye fa-lg"
                                                @click="preview(data.id)"
                                            ></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="no-content" v-if="mapData == null">
                    No Content Found
                </div>
                <div v-if="mapData != null">
                    <ul
                        class="pagination justify-content-end pagination-primary"
                    >
                        <li
                            style="margin-top: 2px; margin-right: 5px"
                            class="page-item d-flex"
                        >
                            <span class="mt-3 mx-1" style="color: black"
                                >Total Count
                                <button
                                    style="
                                        border: none;
                                        margin-top: 4px;
                                        border-radius: 7px;
                                        color: white;
                                        background: rgb(13, 110, 253);
                                        height: 30px;
                                    "
                                >
                                    {{ pagination.total }}
                                </button></span
                            >
                        </li>
                        <li>
                            <Paginations
                                :totalCount="pagination.total"
                                :currentPage="pagination.current_page"
                                :pageSize="pagination.per_page"
                                @page-change="handlePageChange"
                            />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import breadCrumbs from "../../layout/breadCrumbs.vue";
import config from "../../config";
import Paginations from "../Paginations.vue";

export default {
    components: {
        breadCrumbs,
        Paginations,
    },
    data() {
        return {
            // totalItems: 100, // Total number of items in the list
            // currentPage: 1,
            // pageSize: 10,

            status: 1,
            main: "Product",
            title: "Product Data",
            pageCount: 1,
            leadKey: [],
            leadValue: [],
            keyValue: [],
            mapData: null,
            keyValueNot: [],
            pagination: {
                current_page: null,
                last_page: null,
                per_page: null,
                total: null,
            },
        };
    },

    methods: {
        handlePageChange(page) {
            // console.log(this.pagination.current_page);
            // Update the current page
            this.pagination.current_page = page;
            let token = localStorage.getItem("token");
            if (this.filterQuery) {
                axios
                    .get(
                        `${config.apiUrl}/api/my-product?page=${this.pagination.current_page}&search=${this.filterQuery}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        // console.log('ttttt',res);
                        this.mapData = res.data.result.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                axios
                    .get(
                        `${config.apiUrl}/api/my-product?page=${this.pagination.current_page}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        this.mapData = res.data.result.data;
                        console.log("ttttt", res.data.result.data);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }

            // Fetch data for the new page from the server or perform any other necessary actions
            // For demonstration purposes, let's log the requested page
            console.log("Requested page:", page);
        },
        // convert(data) {

        //   let token = localStorage.getItem("token");
        //   if (confirm("Do you really want to delete?")) {
        //     axios
        //       .post(`${config.apiUrl}/api/leadstatus/${data}`, {
        //         headers: {
        //           Authorization: `Bearer ${token}`,
        //         },
        //       })
        //       .then((res) => {
        //         console.log("errrr", res);
        //         this.$router.replace(`/create-quote-form/${data}`);
        //       })
        //       .catch((error) => {
        //         console.error(error);
        //       });
        //   }
        // },
        removePrefix(data) {
            if (data) {
                return data.split("_")[1]
                    ? data.split("_")[1]
                    : data.split("_")[0];
            }
            return true;
        },
        isMatchingValue(u) {
            let sta = true;
            console.log(u);
            // if (value === set){
            //   sta =false
            // }
            console.log(sta, "rrrrr");
            return sta;
        },
        addLead() {
            this.$router.replace("/create-addproduct-form");
        },
        EditForm(data) {
            // this.$router.replace("/create-addproduct-form/");

            this.$router.replace(`/update-addproduct-form/${data}`);

            // let token = localStorage.getItem("token");

            // axios
            //   .get(`http://localhost:8000/api/form-fields/${data}`, {
            //     headers: {
            //       Authorization: `Bearer ${token}`,
            //     },
            //   })
            //   .then((res) => {

            //     this.$router.push('/lead-form')
            //     let uuu = {
            //       id: data,

            //     };
            //     console.log(res.data.result);

            //     this.values = uuu;
            //     this.onObjectType();
            //   })
            //   .catch((error) => {
            //     console.error(error);
            //   });
        },
        DeleteForm(data) {
            console.log(data);
            let token = localStorage.getItem("token");
            if (confirm("Do you really want to delete?")) {
                axios
                    .delete(`${config.apiUrl}/api/my-product/${data}`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        console.log("Error", res);
                        this.getFormFieldsList();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        layout() {
            this.$router.push(`/layout-form`);
        },
        preview(id) {
            this.$router.push(`/preview-form/${id}`);
            // console.log(id,'id')
        },
        convertCamelCaseToNormalString(camelCase) {
            const normalString = camelCase.replace(/([A-Z])/g, " $1");

            const capitalizedString =
                normalString.charAt(0).toUpperCase() + normalString.slice(1);
            return capitalizedString.trim();
        },
        getFormFieldsList() {
            // console.log("delre")
            let token = localStorage.getItem("token");
            // console.log(token);
            let promise = axios.get(config.apiUrl + "/api/my-product", {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });
            const consumer = () => {
                promise
                    .then((d) => {
                        // console.log("tttttt", d.data.result.pagination);
                        // console.log(d,'d')
                        this.pagination = d.data.result.pagination;
                        var datas = d.data.result.data;
                        // console.log(datas,'vvvvv')
                        if (datas.length == 0) {
                            this.keyValue = keyValueNot;
                            // console.log(this.keyValue,'jeycal')
                        }
                        const dataMain = [];
                        for (let key in datas) {
                            if (datas.hasOwnProperty(key)) {
                                // console.log(key,'keys id ')
                                const value = datas[key];
                                // console.log(value,'value')
                                let tableTH = [];
                                let dataIn = {};
                                for (let key1 in value) {
                                    // console.log(key1,'inside of key')
                                    var keyNew = this.removePrefix(key1);
                                    if (value.hasOwnProperty(key1)) {
                                        // console.log(key1,'inside of value')
                                        if (key === "0") {
                                            if (
                                                key1 != "is_deleted" &&
                                                key1 != "created_at" &&
                                                key1 != "updated_at" &&
                                                key1 != "uuid"
                                            ) {
                                                tableTH.push(
                                                    this.convertCamelCaseToNormalString(
                                                        keyNew
                                                    )
                                                );
                                                // console.log(tableTH)
                                            }
                                        }
                                        if (
                                            key1 != "is_deleted" &&
                                            key1 != "created_at" &&
                                            key1 != "updated_at" &&
                                            key1 != "uuid"
                                        ) {
                                            dataIn[key1] = value[key1];
                                            // console.log(dataIn[key1],'jjjjasdasdasdadadsad')
                                            // console.log(dataIn,'bbbbbbbbbbbbbbbbbbbb')
                                        }
                                    }
                                }

                                dataMain.push(dataIn);
                                if (key === "0") {
                                    this.keyValue = tableTH;
                                    // console.log(this.keyValue,'key')
                                }
                            }
                        }

                        this.mapData = dataMain;
                        // console.log( this.mapData,'mapdata')
                    })
                    .catch((e) => {
                        console.log("ttttttttt", e);
                    });
            };

            consumer();
        },

        getConsumer() {
            let token = localStorage.getItem("token");
            axios
                .get(config.apiUrl + "/api/my-product", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    var ddd = [];
                    this.datas = res.data.result;
                    this.datas.forEach((element) => {
                        ddd.push(element["label_name"]);
                    });
                    this.keyValueNot = ddd;
                });
        },
        filter() {
            let token = localStorage.getItem("token");
            if (this.filterQuery.length > 0) {
                axios
                    .get(
                        `${config.apiUrl}/api/my-product?search=${this.filterQuery}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        this.pagination = res.data.result.pagination;

                        this.mapData = res.data.result.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                axios
                    .get(`${config.apiUrl}/api/my-product`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        this.pagination = res.data.result.pagination;

                        this.mapData = res.data.result.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
            // if(this.filterQuery==null){
            //   console.log("pratik")
            //   this.getFormFieldsList()
            // }
        },
    },
    mounted() {
        this.getFormFieldsList();
        this.getConsumer();
    },
};
</script>
<style scoped>
.ml-4 {
    margin-left: 4px !important;
}
</style>
