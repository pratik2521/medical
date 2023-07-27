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
                            Create Lead
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
                                <th scope="col">Convert</th>
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

                                <td>
                                    <div
                                        class="flex-grow-1 text-end icon-state"
                                    >
                                        <button
                                            @click="convert1111(data.id)"
                                            :disabled="data.is_convert == 1"
                                            class="btn btn-primary display radius"
                                            type="button"
                                            data-bs-toggle="modal"
                                            data-original-title="test"
                                            data-bs-target="#exampleModal"
                                        >
                                            Convert
                                        </button>

                                        <div
                                            class="modal fade"
                                            id="exampleModal"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="exampleModalLabel"
                                            aria-hidden="true"
                                        >
                                            <div
                                                class="modal-dialog"
                                                role="document"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="exampleModalLabel"
                                                        >
                                                            Do you really want
                                                            to convert?
                                                        </h5>
                                                        <button
                                                            class="btn-close"
                                                            type="button"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button
                                                            class="btn btn-primary"
                                                            type="button"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            Close
                                                        </button>
                                                        <button
                                                            data-bs-dismiss="modal"
                                                            class="btn btn-secondary"
                                                            type="button"
                                                            @click="
                                                                convert(
                                                                    convertId
                                                                )
                                                            "
                                                        >
                                                            Convert
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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
                            <span class="mt-3 mx-1" style="color: black"
                                >Total Count
                                <button
                                    style="
                                        border: none;
                                        margin-top: 7px;
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
import config from "../../config";
import breadCrumbs from "../../layout/breadCrumbs.vue";
import Paginations from "../Paginations.vue";
import axios from "axios";
export default {
    components: {
        breadCrumbs,
        Paginations,
    },
    data() {
        return {
            status: 1,
            main: "Lead",
            title: "Lead Data",
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
            convertId: "",
        };
    },
    methods: {
        handlePageChange(page) {
            this.pagination.current_page = page;
            let token = localStorage.getItem("token");
            if (this.filterQuery) {
                axios
                    .get(
                        `${config.apiUrl}/api/lead-form?page=${this.pagination.current_page}&search=${this.filterQuery}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        console.log("Error", res);
                        // this.apiResFormList = res.data.result.data;
                        this.mapData = res.data.result.data;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                axios
                    .get(
                        `${config.apiUrl}/api/lead-form?page=${this.pagination.current_page}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        console.log("Error", res);
                        console.log(res.data.result.data, "dddd");
                        // this.apiResFormList = res.data.result.data;
                        this.mapData = res.data.result.data;
                        // console.log(this.mapData)
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }

            console.log("Requested page:", page);
        },
        convert(data) {
            this.$router.replace(`/create-quote-form/${data}-0`);
            // console.log(data, 'convert dir')

            // let token = localStorage.getItem("token");

            // axios
            //     .get(`${config.apiUrl}/api/leadstatus/${data}`, {
            //         headers: {
            //             Authorization: `Bearer ${token}`,
            //         },
            //     })
            //     .then((res) => {
            //         if (res.status == 200) {
            //             this.$router.replace(`/create-quote-form/${data}-0`);
            //         }
            //     })
            //     .catch((error) => {
            //         console.error(error);
            //     });
        },
        convert1111(id) {
            this.convertId = id;
        },
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
            return sta;
        },
        addLead() {
            this.$router.replace("/create-lead-form");
        },
        EditForm(data) {
            this.$router.replace(`/create-lead-form/${data}`);
        },
        DeleteForm(data) {
            let token = localStorage.getItem("token");
            if (confirm("Do you really want to delete?")) {
                axios
                    .delete(`${config.apiUrl}/api/lead-form/${data}`, {
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
        ViewForm(data) {
            this.$router.push(`/lead-view-form/${data}`);
        },
        convertCamelCaseToNormalString(camelCase) {
            const normalString = camelCase.replace(/([A-Z])/g, " $1");

            const capitalizedString =
                normalString.charAt(0).toUpperCase() + normalString.slice(1);
            return capitalizedString.trim();
        },
        getFormFieldsList() {
            let token = localStorage.getItem("token");
            let promise = axios.get(config.apiUrl + "/api/lead-form", {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });
            const consumer = () => {
                promise
                    .then((d) => {
                        this.pagination = d.data.result.pagination;
                        var datas = d.data.result.data;
                        if (datas.length == 0) {
                            this.keyValue = keyValueNot;
                        }
                        const dataMain = [];
                        for (let key in datas) {
                            if (datas.hasOwnProperty(key)) {
                                const value = datas[key];

                                let tableTH = [];
                                let dataIn = {};
                                for (let key1 in value) {
                                    var keyNew = this.removePrefix(key1);
                                    if (value.hasOwnProperty(key1)) {
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
                                        }
                                    }
                                }

                                dataMain.push(dataIn);
                                if (key === "0") {
                                    this.keyValue = tableTH;
                                }
                            }
                        }

                        this.mapData = dataMain;
                    })
                    .catch((e) => {
                        console.log("Error", e);
                    });
            };

            consumer();
        },
        getConsumer() {
            let token = localStorage.getItem("token");
            axios
                .get(config.apiUrl + "/api/form-data?obect_type_id=1", {
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
                        `${config.apiUrl}/api/lead-form?search=${this.filterQuery}`,
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
                    .get(`${config.apiUrl}/api/lead-form`, {
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

.colFormLabel {
    margin-right: 15px !important;
}
</style>
