<template>
    <breadCrumbs :title="title" :main="main" />
    <div class="col-sm-12">
        <div class="card">
            <div style="text-align: right">
                <!-- <button class="toggle " type="contained" @click="drawerVisible = true">
          Show Menu
        </button> -->
            </div>
            <div class="card-body">
                <div class="col-md-12 rowData">
                    <div class="col-md-6">
                        <!-- <button style="margin-bottom: 20px" class="btn btn-primary" type="button" @click="addLead()"
            >
              Create Lead
            </button> -->
                        <button
                            style="margin-bottom: 20px"
                            class="btn btn-primary radius"
                            type="button"
                            @click="addEmployee()"
                        >
                            Create Employee
                        </button>
                    </div>
                    <div class="mb-3 col-md-6 rowData justify-content-end">
                        <label
                            for="table-complete-search"
                            class="col-xs-3 col-sm-auto col-form-label colFormLabel"
                            >Search:</label
                        >
                        <div class="col-xs-3 col-sm-auto">
                            <!-- <input id="table-complete-search" type="text" @keyup="filter()" class="form-control" -->
                            <input
                                id="table-complete-search"
                                type="text"
                                class="form-control"
                                v-model="filterQuery"
                                @keyup="filter()"
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
                                <!-- <th>S/N</th> -->
                                <!-- <th>name</th>
                    <th>Mobile no</th>
                     <th>date</th>
                      <th>city</th> -->
                                <!-- {{keyValue}} -->
                                <th scope="col" v-for="tt in keyValue">
                                    {{ tt }}
                                </th>
                                <!-- <th scope="col">Convert

                </th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in mapData" :key="data.id">
                                {{
                                    console.log(index, "datahhhhhhhhhhh")
                                }}
                                {{
                                    console.log(
                                        data,
                                        "adsasdasddsadassadsadatahhhhhhhhhhh"
                                    )
                                }}
                                <!-- <td>{{ index + 1 }}</td> -->
                                <!-- <td>{{ index + 1 }}</td> -->
                                <td
                                    style="text-transform: capitalize"
                                    v-for="(ir, i, u) in data"
                                    :key="u"
                                    v-if="u !== '0'"
                                >
                                    {{
                                        i == "id"
                                            ? (pagination.current_page - 1) *
                                                  pagination.per_page +
                                              1 +
                                              index
                                            : ir
                                    }}
                                </td>
                                <!-- <td v-if="keyValue !== data.mobileno">{{ data.mobileno   }}</td>
                  <td v-if="keyValue !== data.email">{{ data.email }}</td>
                  <td v-if="keyValue !== data.date">{{ data.date }}</td>
                  <td v-if="keyValue !== data.city">{{ data.city }}</td> -->
                                <!-- <td>{{ data.terms&condition }}</td> -->
                                <!-- <td>
                  <div class="flex-grow-1 text-end icon-state">
                    <label class="switch">
                      <input type="checkbox" @change="convert(data.id)" :checked="data.is_convert"><span
                        class="switch-state"></span>
                    </label>
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
                            <span class="mt-4 mx-1" style="color: black"
                                >Total Count
                                <button
                                    style="
                                        border: none;
                                      
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
                        <!-- <li class="page-item d-flex">
              <span class="mt-2 text-primary mx-1">Row Per Page</span>
              <input class="page-link" type="text" style="width: 50px" v-model="pagination.per_page"
                @change="RowperPage()" />
            </li>
            <li class="page-item">
              <button @click="PageDecri()" :disabled="pageCount == 1" class="page-link">
                &laquo;
              </button>
            </li>
            <li class="page-item">
              <a class="page-link">{{ pageCount }}</a>
            </li>
            <li class="page-item">
              <button class="page-link" @click="pageIncri()" v-if="pageCount <= pagination.last_page"
                :disabled="pageCount == pagination.last_page">
                &raquo;
              </button>
            </li>  -->
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
import config from "../../config";
import breadCrumbs from "../../layout/breadCrumbs.vue";
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
            main: "Employee",
            title: "Employee Data",
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
                        `${config.apiUrl}/api/employee-form?page=${this.pagination.current_page}&search=${this.filterQuery}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        console.log("ttttt", res);
                        this.mapData = res.data.result.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                axios
                    .get(
                        `${config.apiUrl}/api/employee-form?page=${this.pagination.current_page}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        console.log("tttdddddtt", res);
                        this.mapData = res.data.result.data;
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
        addEmployee() {
            this.$router.replace("/create-employee-form");
        },
        EditForm(data) {
            this.$router.replace(`/create-employee-form/${data}`);

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
            let token = localStorage.getItem("token");
            if (confirm("Do you really want to delete?")) {
                axios
                    .delete(`${config.apiUrl}/api/employee-form/${data}`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        console.log("errrr", res);
                        this.getFormFieldsList();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        ViewForm(data) {
            this.$router.push(`/employee-view-form/${data}`);
        },
        convertCamelCaseToNormalString(camelCase) {
            const normalString = camelCase.replace(/([A-Z])/g, " $1");

            const capitalizedString =
                normalString.charAt(0).toUpperCase() + normalString.slice(1);
            return capitalizedString.trim();
        },
        getFormFieldsList() {
            let token = localStorage.getItem("token");
            // console.log(token);
            let promise = axios.get(config.apiUrl + "/api/employee-form", {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });
            const consumer = () => {
                promise
                    .then((d) => {
                        // console.log("tttttt", d.data.result.pagination);
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
                                        // console.log(value,'inside of value')
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
                .get(config.apiUrl + "/api/form-data?obect_type_id=3", {
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
                        `${config.apiUrl}/api/employee-form?search=${this.filterQuery}`,
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
                    .get(`${config.apiUrl}/api/employee-form`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        this.mapData = res.data.result.data;
                        this.pagination = res.data.result.pagination;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
    },
    handleInputChange() {
        this.pagination.per_page = this.pagination.per_page;
    },
    PageDecri() {
        this.pageCount--;
        let token = localStorage.getItem("token");

        axios
            .get(`${config.apiUrl}/api/form-fields?page=${this.pageCount}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            })
            .then((res) => {
                this.apiResFormList = res.data.result.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    pageIncri() {
        this.pageCount++;
        let token = localStorage.getItem("token");

        axios
            .get(`${config.apiUrl}/api/form-fields?page=${this.pageCount}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            })
            .then((res) => {
                this.apiResFormList = res.data.result.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    RowperPage() {
        let token = localStorage.getItem("token");

        axios
            .get(
                `${config.apiUrl}/api/form-fields?page_size=${this.pagination.per_page}`,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }
            )
            .then((res) => {
                this.apiResFormList = res.data.result.data;
            })
            .catch((error) => {
                console.error(error);
            });
    },
    mounted() {
        this.getFormFieldsList();
        this.getConsumer();
    },
};
</script>

<style>
.icons {
    padding: 5px;
    gap: 6px;
    font-size: 16px;
    color: blue;
}

.table th {
    white-space: nowrap;
}

.aerrowButton {
    border-radius: 15px;
    background-color: blue;
    color: white;
}

.count {
    padding: 5px;
}

.rowInput {
    width: 30px;
    height: 30px;
}

.no-content {
    font-size: 20px;
    font-weight: 600;
}

.card {
    border-radius: 10px !important;
}

.rowData {
    display: flex;
    flex-wrap: wrap;
}
</style>
