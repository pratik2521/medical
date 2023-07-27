<template>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="product-info">
                    <form @submit.prevent="submitForm">
                        <div v-for="(feature, index) in features" :key="index">
                            <!-- {{ this.features }} -->
                            <div>
                                <input type="hidden" v-model="feature.idd" />

                                <label :for="'headline' + index"
                                    >Headline: {{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    :id="'headline' + index"
                                    type="text"
                                    placeholder="Enter Headline"
                                    v-model="feature.headline"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.headline[index]"
                                >
                                    {{ validationErrors.headline[index] }}
                                </span>
                            </div>

                            <div>
                                <label :for="'additionalImage' + index"
                                    >Additional Image: {{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    :id="'additionalImage' + index"
                                    type="file"
                                    @change="
                                        handleAdditionalImageUpload(
                                            $event,
                                            index
                                        )
                                    "
                                />
                                <span
                                    class="error text-danger"
                                    v-if="
                                        validationErrors.additionalImage[index]
                                    "
                                >
                                    {{
                                        validationErrors.additionalImage[index]
                                    }}
                                </span>
                                <img :src="features[index].url" />
                                <!-- <button
                                    type="button"
                                    class="btn btn-danger ml-2 radius"
                                    @click="removeImage(index)"
                                >
                                    Remove Image
                                </button> -->
                            </div>
                            <div>
                                <label :for="'textInput' + index"
                                    >Image position: {{ index }}</label
                                >
                                <input
                                    class="form-control"
                                    :id="'textInput' + index"
                                    type="text"
                                    placeholder="Enter Text left/right only"
                                    v-model="feature.imagePosition"
                                />
                                <span
                                    class="error text-danger"
                                    v-if="validationErrors.imagePosition[index]"
                                >
                                    {{ validationErrors.imagePosition[index] }}
                                </span>
                            </div>
                            <button
                                class="mt-4 btn btn-primary ml-4 removeMoreMargin"
                                v-if="index > 0"
                                @click="removeMore(index)"
                            >
                                Remove more
                            </button>

                            <div
                                v-for="(
                                    subFeature, subIndex
                                ) in feature.subFeatures"
                                :key="subIndex"
                            >
                                <div>
                                    <!-- {{ subFeature[subIndex].url }} -->

                                    <input
                                        type="hidden"
                                        v-model="subFeature.idd"
                                    />
                                    <label :for="'name' + index + subIndex"
                                        >Feature Name: {{ subIndex }}</label
                                    >
                                    <input
                                        class="form-control"
                                        :id="'name' + index"
                                        type="text"
                                        placeholder="Enter Product name"
                                        v-model="subFeature.name"
                                    />
                                    <span
                                        class="error text-danger"
                                        v-if="
                                            validationErrors.name[index][
                                                subIndex
                                            ]
                                        "
                                    >
                                        {{
                                            validationErrors.name[index][
                                                subIndex
                                            ]
                                        }}
                                    </span>
                                </div>

                                <div>
                                    <label
                                        :for="'description' + index + subIndex"
                                        >Feature Description:
                                        {{ subIndex }}</label
                                    >
                                    <input
                                        class="form-control"
                                        :id="'description' + index + subIndex"
                                        type="text"
                                        placeholder="Enter Product Description"
                                        v-model="subFeature.description"
                                    />
                                    <span
                                        class="error text-danger"
                                        v-if="
                                            validationErrors.description[index][
                                                subIndex
                                            ]
                                        "
                                    >
                                        {{
                                            validationErrors.description[index][
                                                subIndex
                                            ]
                                        }}
                                    </span>
                                </div>

                                <div>
                                    <label :for="'image' + index + subIndex"
                                        >Feature Image: {{ subIndex }}</label
                                    >
                                    <input
                                        class="form-control"
                                        :id="'image' + index + subIndex"
                                        type="file"
                                        @change="
                                            handleImageUpload(
                                                $event,
                                                index,
                                                subIndex
                                            )
                                        "
                                    />
                                    <span
                                        class="error text-danger"
                                        v-if="
                                            validationErrors.image[index][
                                                subIndex
                                            ]
                                        "
                                    >
                                        {{
                                            validationErrors.image[index][
                                                subIndex
                                            ]
                                        }}
                                    </span>
                                    <img :src="subFeature.url" />
                                    <!-- <button
                                        type="button"
                                        class="btn btn-danger ml-2 radius"
                                        @click="removeImage(index, subIndex)"
                                    >
                                        Remove Image
                                    </button> -->
                                </div>
                                <button
                                    type="button"
                                    class="btn btn-primary marginLeft radius"
                                    v-if="subIndex > 0"
                                    @click="removeField(index, subIndex)"
                                >
                                    Remove field
                                </button>
                            </div>
                            <hr />
                        </div>

                        <div>
                            <button
                                class="mt-4 btn radius"
                                type="button"
                                @click="addFields"
                            >
                                Add More Fields
                            </button>
                            <button
                                class="mt-4 btn ml-4 radius"
                                type="button"
                                @click="addMore"
                            >
                                Add More
                            </button>
                            <button
                                class="mt-4 btn btn-primary ml-4 radius"
                                type="submit"
                            >
                                Submit
                            </button>
                        </div>
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
            features: [
                {
                    idd: null,
                    additionalImage: null,
                    headline: "",
                    imagePosition: "",
                    subFeatures: [
                        {
                            name: "",
                            description: "",
                            image: null,
                            idd: null,
                        },
                    ],
                },
            ],
            imagePreview: [[]],
            additionalImagePreview: [],
            validationErrors: {
                headline: [],
                name: [[]],
                description: [[]],
                image: [[]],
                additionalImage: [],
                imagePosition: [],
            },
            formattedData: [], // Add this property
        };
    },

    methods: {
        removeField(index, subIndex) {
            this.features[index].subFeatures.splice(subIndex, 1);
            this.validationErrors.name[index].splice(subIndex, 1);
            this.validationErrors.description[index].splice(subIndex, 1);
            this.validationErrors.image[index].splice(subIndex, 1);
            this.imagePreview[index].splice(subIndex, 1);
        },
        removeMore(index) {
            this.features.splice(index, 1);
        },
        handleImageUpload(event, index, subIndex) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);
                this.features[index].subFeatures[subIndex].image = file;
                this.imagePreview[index][subIndex] = {
                    name: file.name,
                    url: url,
                    type: file.type,
                };
            }
        },

        handleAdditionalImageUpload(event, index) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);
                this.features[index].additionalImage = file;
                this.additionalImagePreview[index] = {
                    name: file.name,
                    url: url,
                    type: file.type,
                };
            }
        },

        validateForm() {
            let isValid = true;

            this.validationErrors.headline = this.features.map(
                (feature, index) => {
                    if (!feature.headline) {
                        isValid = false;
                        return `Headline ${index} is required`;
                    }
                    return "";
                }
            );

            this.validationErrors.imagePosition = this.features.map(
                (feature, index) => {
                    if (!feature.imagePosition) {
                        isValid = false;
                        return `Image position ${index} is required`;
                    }
                    return "";
                }
            );

            this.validationErrors.name = this.features.map((feature, index) => {
                const subFeatureErrors = feature.subFeatures.map(
                    (subFeature, subIndex) => {
                        if (!subFeature.name) {
                            isValid = false;
                            return `Feature Name ${subIndex} of feature ${index} is required`;
                        }
                        return "";
                    }
                );
                return subFeatureErrors;
            });

            this.validationErrors.description = this.features.map(
                (feature, index) => {
                    const subFeatureErrors = feature.subFeatures.map(
                        (subFeature, subIndex) => {
                            if (!subFeature.description) {
                                isValid = false;
                                return `Feature Description ${subIndex} of feature ${index} is required`;
                            }
                            return "";
                        }
                    );
                    return subFeatureErrors;
                }
            );

            return isValid;
        },

        submitForm() {
            console.log("submit");
            const url = new URL(window.location.href);
            const id = url.pathname.split("/").pop();
            const isNum = /^\d+$/.test(id);
            if (isNum) {
                this.parentId = id;
            }

            if (this.validateForm()) {
                const formData = new FormData();
                this.features.forEach((feature, i) => {
                    formData.append(`title[${i}]`, feature.headline);

                    // formData.append(`image[${i}]`, feature.additionalImage);
                    formData.append(
                        `image[${i}]`,
                        feature.additionalImage === undefined
                            ? " "
                            : feature.additionalImage
                    );

                    formData.append(`parent_id[${i}]`, this.parentId);

                    formData.append(
                        `image_position[${i}]`,
                        feature.imagePosition
                    );
                    // formData.append(
                    //     `newid[${i}]`,
                    //     feature.idd === undefined ? null : feature.idd
                    // );
                    formData.append(
                        `newid[${i}]`,
                        feature.idd === null || feature.idd === undefined
                            ? " "
                            : feature.idd
                    );

                    feature.subFeatures.forEach((subFeature, j) => {
                        formData.append(
                            `sub_title[${i}][${j}]`,
                            subFeature.name
                        );
                        formData.append(
                            `description[${i}][${j}]`,
                            subFeature.description
                        );
                        // formData.append(`icon[${i}][${j}]`, subFeature.image);
                        formData.append(
                            `icon[${i}][${j}]`,
                            subFeature.image === undefined
                                ? " "
                                : subFeature.image
                        );

                        // formData.append(
                        //     `newid2[${i}][${j}]`,
                        //     subFeature.idd === undefined ? null : subFeature.idd
                        // );
                        formData.append(
                            `newid2[${i}][${j}]`,
                            subFeature.idd === null ||
                                subFeature.idd === undefined
                                ? " "
                                : subFeature.idd
                        );
                    });
                });

                let token = localStorage.getItem("token");
                const apiUrl = `${config.apiUrl}/api/my-product-specification`;

                axios
                    .post(apiUrl, formData, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        console.log("Success:", response);
                        // this.$router.replace("/admin");
                        window.location.reload();
                        // Handle success, e.g., show a success message or redirect
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        // Handle error, e.g., show an error message or log the error
                    });

                this.features = [
                    {
                        idd: null,
                        additionalImage: null,
                        headline: "",
                        imagePosition: "",
                        subFeatures: [
                            {
                                name: "",
                                description: "",
                                image: null,
                                idd: null,
                            },
                        ],
                    },
                ];
                this.validationErrors = {
                    headline: [],
                    name: [[]],
                    description: [[]],
                    image: [[]],
                    additionalImage: [],
                    imagePosition: [],
                };
            }
        },

        addMore() {
            this.features.push({
                idd: null,
                additionalImage: null,
                headline: "",
                imagePosition: "",
                subFeatures: [
                    {
                        name: "",
                        description: "",
                        image: null,
                        idd: null,
                    },
                ],
            });
            this.validationErrors.headline.push("");
            this.validationErrors.name.push([""]);
            this.validationErrors.description.push([""]);
            this.validationErrors.image.push([""]);
            this.imagePreview.push([]);
        },

        addFields() {
            const lastFeatureIndex = this.features.length - 1;
            const newSubFeature = {
                name: "",
                description: "",
                image: null,
                idd: null,
            };
            this.features[lastFeatureIndex].subFeatures.push({
                ...newSubFeature,
            });
            const lastSubFeatureIndex =
                this.features[lastFeatureIndex].subFeatures.length - 1;
            this.validationErrors.name[lastFeatureIndex].push("");
            this.validationErrors.description[lastFeatureIndex].push("");
            this.validationErrors.image[lastFeatureIndex].push("");
            this.imagePreview[lastFeatureIndex].push("");
        },

        getFormDataW(id) {
            let token = localStorage.getItem("token");
            const apiUrl = `${config.apiUrl}/api/my-product-get-specification/${id}`;

            axios
                .get(apiUrl, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    //   console.log(response, "response");

                    if (response.data.result.length === 0) {
                        this.features = [
                            {
                                idd: null,
                                additionalImage: null,
                                headline: "",
                                imagePosition: "",
                                subFeatures: [
                                    {
                                        name: "",
                                        description: "",
                                        image: null,
                                        idd: null,
                                    },
                                ],
                            },
                        ];
                        this.validationErrors = {
                            headline: [],
                            name: [[]],
                            description: [[]],
                            image: [[]],
                            additionalImage: [],
                            imagePosition: [],
                        };
                        this.imagePreview = [[]];
                        return;
                    }

                    const updatedFeatures = [];
                    const updatedValidationErrors = {
                        headline: [],
                        name: [[]],
                        description: [[]],
                        image: [[]],
                        additionalImage: [],
                        imagePosition: [],
                    };
                    const updatedImagePreview = [[]];

                    response.data.result.forEach((item) => {
                        const subFeatures = [];
                        const subFeatureValidationErrors = [];
                        const subFeatureImagePreview = [];

                        item.subspecification.forEach((subItem) => {
                            const subFeature = {
                                name: subItem.sub_title,
                                description: subItem.description,
                                image: null, // Add a placeholder for the image data
                                url: `${config.imageUrl}${subItem.icon}`,
                                idd: subItem.id,
                            };
                            subFeatures.push(subFeature);
                            subFeatureValidationErrors.push("");
                            subFeatureImagePreview.push(subFeature.url);
                        });

                        const feature = {
                            idd: item.id,
                            headline: item.title,
                            imagePosition: item.image_position,
                            url: `${config.imageUrl}${item.image_url}`,
                            subFeatures: subFeatures,
                        };

                        updatedFeatures.push(feature);
                        updatedValidationErrors.headline.push("");
                        updatedValidationErrors.name.push(
                            subFeatureValidationErrors
                        );
                        updatedValidationErrors.description.push(
                            subFeatureValidationErrors
                        );
                        updatedValidationErrors.image.push(
                            subFeatureValidationErrors
                        );
                        updatedImagePreview.push(subFeatureImagePreview);
                    });

                    this.features = updatedFeatures;
                    this.validationErrors = updatedValidationErrors;
                    this.imagePreview = updatedImagePreview;
                })
                .catch((error) => {
                    console.error(error);
                    // Handle error
                });
        },
    },
    mounted() {
        const url = new URL(window.location.href);
        const id = url.pathname.split("/").pop();
        const isNum = /^\d+$/.test(id);
        if (isNum) {
            this.getFormDataW(id);
            this.EditIds = id;
        }
    },
};
</script>

<style scoped>
h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="file"] {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

img {
    width: 25%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
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

.radius {
    border-radius: 22px !important;
}
.ml-4 {
    margin-left: 4px;
}
.marginLeft {
    margin-left: 727px !important;
}
</style>
