<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div>
                            <label for="username">UserName</label>
                            <input
                                class="form-control"
                                type="text"
                                id="username"
                                placeholder="Enter Username"
                                v-model="ratingObject.userName"
                            />
                            <span
                                class="text-danger"
                                v-if="errors.userName !== ''"
                            >
                                {{ errors.userName }}</span
                            >
                        </div>
                        <div>
                            <label for="rating">Rating</label>
                            <input
                                class="form-control"
                                type="number"
                                id="rating"
                                placeholder="Enter Product Rating Only Integar Value"
                                v-model="ratingObject.ratingNumber"
                            />
                            <span
                                class="text-danger"
                                v-if="errors.ratingNumber !== ''"
                            >
                                {{ errors.ratingNumber }}</span
                            >
                        </div>
                        <div>
                            <label for="location">Location</label>
                            <input
                                class="form-control"
                                type="text"
                                id="location"
                                placeholder="Enter Location"
                                v-model="ratingObject.location"
                            />
                            <span
                                class="text-danger"
                                v-if="errors.location !== ''"
                            >
                                {{ errors.location }}</span
                            >
                        </div>

                        <div>
                            <label for="desc">Review</label>
                            <textarea
                                class="form-control"
                                placeholder="Enter Review"
                                v-model="ratingObject.review"
                                name="w3review"
                                rows="4"
                                cols="50"
                            >
                            </textarea>
                            <span
                                class="text-danger"
                                v-if="errors.review !== ''"
                            >
                                {{ errors.review }}</span
                            >
                        </div>

                        <button
                            class="mt-4 ml-4 btn btn-primary radius"
                            type="submit"
                        >
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import config from "../../config";
import axios from "axios";
export default {
    data() {
        return {
            EditIds: null,
            parentId: "",
            ratingObject: {
                userName: "",
                ratingNumber: null,
                location: "",
                review: "",
            },
            errors: {
                userName: "",
                ratingNumber: "",
                location: "",
                review: "",
            },
        };
    },
    methods: {
        submitForm() {
            this.errors = {
                userName: "",
                ratingNumber: "",
                location: "",
                review: "",
            };

            if (!this.ratingObject.userName) {
                this.errors.userName = "The userName Field is required";
            }
            if (!this.ratingObject.ratingNumber) {
                this.errors.ratingNumber = "The ratingNumber Field is required";
            } else if (this.ratingObject.ratingNumber > 5) {
                this.errors.ratingNumber =
                    "The rating should not be greater than 5";
            }
            if (!this.ratingObject.location) {
                this.errors.location = "The location Field is required";
            }
            if (!this.ratingObject.review) {
                this.errors.review = "The review Field is required";
            }

            if (Object.values(this.errors).some((error) => error !== "")) {
                return;
            }

            const data = {
                user_name: this.ratingObject.userName,
                rating: this.ratingObject.ratingNumber,
                location: this.ratingObject.location,
                review: this.ratingObject.review,
                parent_id: this.parentId,
            };

            let token = localStorage.getItem("token");

            axios
                .post(`${config.apiUrl}/api/my-product-review`, data, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                })
                .then((res) => {
                    console.log(res, "res");
                    console.log(res.data);

                    this.ratingObject = {
                        userName: "",
                        ratingNumber: null,
                        location: "",
                        review: "",
                    };
                    // this.$router.replace("/admin");
                    window.location.reload();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getFormDataW(id) {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/my-product-review/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    const ratingData = res.data;
                    this.ratingObject = {
                        userName: ratingData.user_name,
                        ratingNumber: ratingData.rating,
                        location: ratingData.location,
                        review: ratingData.review,
                    };
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    mounted() {
        const url = new URL(window.location.href);
        const id = url.pathname.split("/").pop();
        const isNum = /^\d+$/.test(id);
        if (isNum) {
            // this.getFormDataW(id);
            this.parentId = id;
        }
    },
};
</script>

<style scoped>
h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

/* form div {
 margin-bottom: 20px;
} */

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"] {
    width: 100%;
    /* padding: 10px; */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

img {
    max-width: 200px;
    margin-top: 10px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
</style>
