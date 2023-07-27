<template>
    <div>
        <div
            class="right-drawer"
            :style="{
                width: drawerVisible ? '60vw' : '0',
                // paddingLeft: drawerVisible ? '.625rem' : '0',
            }"
        >
            <div class="modal_header">
                <div class="mt-3 mx-3">
                    <p class="text-white">Create a new property</p>
                </div>
                <div class="mt-3 px-3">
                    <button class="close" @click="ShowHideModal()">
                        &#9587;
                    </button>
                </div>
            </div>
            <div class="progressbar col-10">
                <div class="progress" id="progress"></div>

                <div
                    class="progress-step"
                    :style="{
                        background: pageIndex == 0 ? 'blue' : '',
                    }"
                    data-title="BASIC INFO"
                ></div>
                <div
                    class="progress-step"
                    :style="{
                        background: pageIndex == 1 ? 'blue' : '',
                    }"
                    data-title="FIELD TYPE"
                ></div>
                <div
                    class="progress-step"
                    :style="{
                        background: pageIndex == 2 ? 'blue' : '',
                    }"
                    data-title="RULES"
                ></div>
            </div>
            <form class="form" @submit="addProduct">
                <div v-if="pageIndex === 0" class="">
                    <div class="col-10 mt-3 m-auto">
                        <label for="exampleFormControlInput1" class="label"
                            >Object type*</label
                        >

                        <select
                            :disabled="EditOption"
                            required="required"
                            @change="onObjectType()"
                            class="selectpicker"
                            id="exampleFormControlInput1"
                            v-model="values.form_object_type_id"
                            aria-label="Default select example"
                        >
                            <option selected value="">
                                Select Object Type
                            </option>
                            <option v-for="data in apiRes" :value="data.id">
                                {{ data.name }}
                            </option>
                        </select>
                        <span class="text-danger" v-if="errors.objectId !== ''">
                            {{ errors.objectId }}</span
                        >
                    </div>
                    <div class="col-10 m-auto mt-3">
                        <label for="exampleFormControlInput1" class="label"
                            >Group*</label
                        >
                        <select
                            required="required"
                            class="selectpicker"
                            id="exampleFormControlInput1"
                            v-model="values.form_object_type_group_id"
                            aria-label="Default select example"
                        >
                            <option selected value="">Select group</option>
                            <option
                                v-for="data in apiResGroup"
                                :value="data.id"
                            >
                                {{ data.name }}
                            </option>
                        </select>
                        <span class="text-danger" v-if="errors.groupId !== ''">
                            {{ errors.groupId }}</span
                        >
                    </div>
                    <div class="col-10 m-auto mt-3">
                        <label for="exampleFormControlInput1" class="label"
                            >Label*</label
                        >
                        <input
                            required="required"
                            v-model="values.label_name"
                            type="text"
                            class="form-control mt-1"
                            id="exampleFormControlInput1"
                            placeholder="Label"
                        />
                        <span
                            class="text-danger"
                            v-if="errors.labelName !== ''"
                        >
                            {{ errors.labelName }}</span
                        >
                    </div>
                    <div class="col-10 m-auto mt-3">
                        <label for="exampleFormControlInput1" class="label"
                            >Description</label
                        >
                        <input
                            v-model="values.label_description"
                            type="text"
                            class="form-control mt-1"
                            id="exampleFormControlInput1"
                            placeholder="Label discription"
                        />
                        <span
                            class="text-danger"
                            v-if="errors.label_description !== ''"
                        >
                            {{ errors.label_description }}</span
                        >
                    </div>
                </div>

                <div v-if="pageIndex === 1" class="filed-type">
                    <div class="col-10 m-auto mt-3">
                        <label for="exampleFormControlInput1" class="label"
                            >Field type</label
                        >
                        <select
                            class="selectpicker"
                            id="exampleFormControlInput1"
                            v-model="values.field_type"
                            @change="onChange()"
                            aria-label="Default select example"
                        >
                            <option selected value="">Select filed type</option>
                            <optgroup label="Text input">
                                <option class="optionssss" value="text">
                                    Single-line text
                                </option>
                                <option value="MultiLineText">
                                    Multi-line
                                </option>
                            </optgroup>
                            <optgroup label="Choosing options">
                                <option value="checkbox">
                                    Single checkbox
                                </option>
                                <option value="textarea">Text Area</option>

                                <option value="dropdownSelect">
                                    Dropdown select
                                </option>
                                <option value="radio">Radio select</option>
                                <option value="date">Date picker</option>
                                <option value="time">Time picker</option>
                            </optgroup>
                            <optgroup label="Values">
                                <option value="number">Number</option>
                            </optgroup>
                        </select>
                        <span class="text-danger" v-if="errors.filedTy !== ''">
                            {{ errors.filedTy }}</span
                        >
                    </div>
                    <!-- <div :class="EditOption?'dataType':''"> -->
                    <div class="col-10 m-auto mt-3">
                        <label for="exampleFormControlInput1" class="label"
                            >Data types</label
                        >
                        <div
                            v-if="
                                values.field_type !== 'radio' &&
                                values.field_type !== 'MultiLineText' &&
                                values.field_type !== 'checkbox' &&
                                values.field_type !== 'number'
                            "
                        >
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                                v-model="values.data_type"
                                @change="onChange()"
                                aria-label="Default select example"
                            >
                                <option selected value="">
                                    Select Data type
                                </option>

                                <option class="optionssss" value="string">
                                    string
                                </option>

                                <option value="integer">int</option>
                                <option value="boolean">boolean</option>

                                <option value="date">date</option>
                            </select>
                        </div>
                        <div v-if="values.field_type == 'MultiLineText'">
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                                v-model="values.data_type"
                                @change="onChange()"
                                aria-label="Default select example"
                            >
                                <option selected value="">
                                    Select Data type
                                </option>

                                <option class="optionssss" value="string">
                                    string
                                </option>
                            </select>
                        </div>
                        <div v-if="values.field_type == 'radio'">
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                                v-model="values.data_type"
                                @change="onChange()"
                                aria-label="Default select example"
                            >
                                <option selected value="">
                                    Select Data type
                                </option>

                                <option class="optionssss" value="string">
                                    string
                                </option>
                            </select>
                        </div>
                        <div v-if="values.field_type == 'checkbox'">
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                                v-model="values.data_type"
                                @change="onChange()"
                                aria-label="Default select example"
                            >
                                <option selected value="">
                                    Select Data type
                                </option>

                                <option class="optionssss" value="string">
                                    string
                                </option>
                            </select>
                        </div>
                        <div v-if="values.field_type == 'number'">
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                                v-model="values.data_type"
                                @change="onChange()"
                                aria-label="Default select example"
                            >
                                <option selected value="">
                                    Select Data type
                                </option>

                                <option class="optionssss" value="integer">
                                    int
                                </option>
                            </select>
                        </div>
                        <span class="text-danger" v-if="errors.dataTy !== ''">
                            {{ errors.dataTy }}</span
                        >
                    </div>
                    <!-- </div> -->
                    <div
                        v-if="values.field_type === 'text'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div class="mt-3">
                            <label
                                for="exampleFormControlTextarea1"
                                class="label"
                                >Preview</label
                            >
                            <input
                                disabled
                                value="This is single Example"
                                placeholder="Sample text.."
                                class="form-control mt-1"
                                id="exampleFormControlTextarea1"
                            />
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'MultiLineText'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div>
                            <label
                                for="exampleFormControlTextarea1"
                                class="label"
                                >Preview</label
                            >
                            <textarea
                                placeholder="Sample text.."
                                class="form-control mt-1"
                                id="exampleFormControlTextarea1"
                                rows="4"
                            ></textarea>
                        </div>
                        <!-- <div class="mt-3">
                            <label for="exampleFormControlTextarea1" class="label">Preview</label>
                            <input disabled value="This is single Example" placeholder="Sample text.."
                                class="form-control mt-1" id="exampleFormControlTextarea1" />
                            <label for="exampleFormControlTextarea1" class="label">Preview</label>
                            <input disabled value="This is single Example" placeholder="Sample text.."
                                class="form-control mt-1" id="exampleFormControlTextarea1" />
                        </div> -->
                    </div>

                    <div
                        v-if="values.field_type === 'checkbox'"
                        class="yyy col-10 m-auto form-group mt-3 d-flex"
                    >
                        <div class="mt-3">
                            <div class="form-group">
                                <label
                                    for="exampleFormControlSelect1"
                                    class="label"
                                    >Example select</label
                                >
                                <div class="mx-3">
                                    <input
                                        type="checkbox"
                                        name="exampleFormControlSelect"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'textarea'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div>
                            <label
                                for="exampleFormControlTextarea1"
                                class="label"
                                >Preview</label
                            >
                            <textarea
                                placeholder="Sample text.."
                                class="form-control mt-1"
                                id="exampleFormControlTextarea1"
                                rows="4"
                            ></textarea>
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'dropdownSelect'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div class="card mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th
                                            colspan="2"
                                            class="table_label"
                                            scope="col"
                                        >
                                            LABEL
                                        </th>
                                        <th
                                            colspan="2"
                                            class="table_label"
                                            scope="col"
                                        >
                                            INTERNAL VALUE
                                        </th>
                                        <th class="table_label" scope="col">
                                            IN FORMS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            input, index
                                        ) in values.inputFields"
                                        :key="index"
                                    >
                                        <th colspan="2">
                                            <input
                                                type="search"
                                                class="form-control rounded"
                                                v-model="input.value1"
                                                placeholder="Enter label"
                                                aria-label="Search"
                                                aria-describedby="search-addon"
                                            />
                                        </th>
                                        <th colspan="2">
                                            <input
                                                type="search"
                                                class="form-control rounded"
                                                v-model="input.value"
                                                placeholder="Enter value"
                                                aria-label="Search"
                                                aria-describedby="search-addon"
                                            />
                                        </th>
                                        <th>
                                            <svg
                                                @click="removeInputField(index)"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                width="24"
                                                height="24"
                                                class="ml-2 cursor-pointer"
                                            >
                                                <path
                                                    fill="none"
                                                    d="M0 0h24v24H0z"
                                                />
                                                <path
                                                    fill="#EC4899"
                                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                                                />
                                            </svg>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="list_down">
                                <button
                                    type="button"
                                    @click="addInputField"
                                    class="btn btn-link text-decoration-none"
                                >
                                    Add an Option
                                </button>
                            </div>
                        </div>
                        <div>
                            <label
                                for="exampleFormControlTextarea1"
                                class="label"
                                >Preview</label
                            >
                            <select
                                class="selectpicker"
                                id="exampleFormControlInput1"
                            >
                                <option selected value="">Example</option>

                                <option value="">Select 1</option>
                                <option value="">Select 2</option>
                                <option value="">Select 3</option>
                            </select>
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'radio'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div class="card mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th
                                            colspan="2"
                                            class="table_label"
                                            scope="col"
                                        >
                                            LABEL
                                        </th>
                                        <th
                                            colspan="2"
                                            class="table_label"
                                            scope="col"
                                        >
                                            INTERNAL VALUE
                                        </th>
                                        <th class="table_label" scope="col">
                                            IN FORMS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(
                                            input, index
                                        ) in values.inputFields"
                                        :key="index"
                                    >
                                        <th colspan="2">
                                            <input
                                                type="search"
                                                class="form-control rounded"
                                                v-model="input.value"
                                                placeholder="Enter label"
                                                aria-label="Search"
                                                aria-describedby="search-addon"
                                            />
                                        </th>
                                        <th colspan="2">
                                            <input
                                                type="search"
                                                class="form-control rounded"
                                                placeholder="Enter value"
                                                aria-label="Search"
                                                aria-describedby="search-addon"
                                            />
                                        </th>
                                        <th>
                                            <svg
                                                @click="removeInputField(index)"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                width="24"
                                                height="24"
                                                class="ml-2 cursor-pointer"
                                            >
                                                <path
                                                    fill="none"
                                                    d="M0 0h24v24H0z"
                                                />
                                                <path
                                                    fill="#EC4899"
                                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                                                />
                                            </svg>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="list_down">
                                <button
                                    type="button"
                                    @click="addInputField"
                                    class="btn btn-link text-decoration-none"
                                >
                                    Add an Option
                                </button>
                            </div>
                        </div>
                        <div>
                            <label
                                for="exampleFormControlTextarea1"
                                class="label"
                                >Preview</label
                            >
                            <!-- <textarea placeholder="Sample text.." class="form-control mt-1" id="exampleFormControlTextarea1" rows="4"></textarea> -->
                            <div class="mt-3">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlSelect1"
                                        class="label"
                                        >Example select</label
                                    >
                                    <div class="mx-3">
                                        <input
                                            type="radio"
                                            name="exampleFormControlSelect"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'date'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div class="mt-3">
                            <div class="m-auto mt-3">
                                <label
                                    for="exampleFormControlInput1"
                                    class="label"
                                    >Description</label
                                >
                                <input
                                    type="date"
                                    class="form-control mt-1"
                                    id="exampleFormControlInput1"
                                    placeholder="Last Name"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="values.field_type === 'number'"
                        class="yyy col-10 m-auto form-group mt-3"
                    >
                        <div class="mt-3">
                            <div class="form-group">
                                <label
                                    for="exampleFormControlSelect1"
                                    class="label"
                                    >Format</label
                                >
                                <select
                                    v-model="numberFormatter"
                                    @change="onNumberChange()"
                                    class="selectpicker"
                                    id="exampleFormControlInput1"
                                >
                                    <option value="formattedNumber">
                                        Formatted number
                                    </option>
                                    <option value="unformattedNumber">
                                        Unformatted number
                                    </option>
                                    <option value="Curruncy">Currency</option>
                                </select>
                            </div>

                            <div v-if="numberFormatter == 'formattedNumber'">
                                <div class="col m-auto mt-3">
                                    <label
                                        for="exampleFormControlInput1"
                                        class="label"
                                        >Preview</label
                                    >
                                    <input
                                        required="required"
                                        type="number"
                                        class="form-control mt-1"
                                        id="exampleFormControlInput1"
                                        placeholder="formattedNumber"
                                    />
                                </div>
                            </div>

                            <div v-if="numberFormatter == 'unformattedNumber'">
                                <div class="col m-auto mt-3">
                                    <label
                                        for="exampleFormControlInput1"
                                        class="label"
                                        >Preview</label
                                    >
                                    <input
                                        required="required"
                                        type="number"
                                        class="form-control mt-1"
                                        id="exampleFormControlInput1"
                                        placeholder="unformattedNumber"
                                    />
                                </div>
                            </div>

                            <div v-if="numberFormatter == 'Curruncy'">
                                <div class="col m-auto mt-3">
                                    <label
                                        for="exampleFormControlInput1"
                                        class="label"
                                        >Preview</label
                                    >
                                    <input
                                        required="required"
                                        type="number"
                                        class="form-control mt-1"
                                        id="exampleFormControlInput1"
                                        placeholder="Curruncy"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="pageIndex === 2" class="">
                    <div class="col-10 m-auto mt-3">
                        <p class="fw-bold">Select property rules</p>
                        <div>
                            <div>
                                <label
                                    for="exampleFormControlTextarea1"
                                    class="label fw-bold"
                                    >Property visibility</label
                                >

                                <!-- <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                    <span class="h8">Show in forms, pop-up forms, and bots</span>
                </div> -->
                                <div>
                                    <div class="form-check mt-3">
                                        <input
                                            class="form-check-input"
                                            v-model="values.is_display_frontend"
                                            type="checkbox"
                                            id="flexCheckIndeterminate"
                                        />
                                        <span class="h8">
                                            Display on List View</span
                                        >
                                    </div>
                                    <div class="form-check mt-3">
                                        <input
                                            class="form-check-input"
                                            v-model="values.is_required"
                                            type="checkbox"
                                            id="flexCheckIndeterminate"
                                        />
                                        <span class="h8"> Is Required</span>
                                    </div>
                                    <div
                                        class="form-check mt-3"
                                        v-if="values.field_type == 'text'"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="values.setMinCharacter"
                                            @change="onChangeCharLimit()"
                                            id="flexCheckIndeterminate"
                                        />
                                        <span class="h8"
                                            >Set min character limit</span
                                        >
                                    </div>

                                    <div
                                        v-if="values.setMinCharacter == true"
                                        class="form-group col-6"
                                    >
                                        <input
                                            type="number"
                                            id="inputPassword6"
                                            v-model="values.min"
                                            class="form-control mx-sm-3"
                                            aria-describedby="passwordHelpInline"
                                        />
                                    </div>

                                    <div
                                        class="form-check mt-3"
                                        v-if="values.field_type == 'text'"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="values.setMaxCharacter"
                                            id="flexCheckIndeterminate"
                                        />
                                        <span class="h8"
                                            >Set max character limit</span
                                        >
                                    </div>
                                    <div
                                        v-if="values.setMaxCharacter == true"
                                        class="form-group col-6"
                                    >
                                        <input
                                            type="number"
                                            v-model="values.max"
                                            id="inputPassword6"
                                            class="form-control mx-sm-3"
                                            aria-describedby="passwordHelpInline"
                                        />
                                    </div>
                                    <div class="form-check mt-3">
                                        <input
                                            class="form-check-input"
                                            v-model="values.is_numeric"
                                            type="checkbox"
                                            value=""
                                            id="flexCheckIndeterminate"
                                        />
                                        <div class="form_checkbox">
                                            <span class="h8"
                                                >Restrict to numeric
                                                values</span
                                            >
                                            <span class="text-muted"
                                                ><small
                                                    >Don't allow alpha or
                                                    special characters like a,
                                                    @, or $ for this
                                                    property</small
                                                ></span
                                            >
                                        </div>
                                    </div>
                                    <div class="form-check mt-3">
                                        <input
                                            class="form-check-input"
                                            v-model="values.is_character"
                                            type="checkbox"
                                            value=""
                                            id="flexCheckIndeterminate"
                                        />
                                        <div class="form_checkbox">
                                            <span class="h8"
                                                >Don't allow special
                                                characters</span
                                            >
                                            <span class="text-muted"
                                                ><small
                                                    >Don't allow special
                                                    characters like @, #, or &
                                                    for this property</small
                                                ></span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal_footer">
                <div>
                    <button
                        @click="pageIndex--"
                        :disabled="pageIndex == 0"
                        type="button"
                        class="btn btn-light radius"
                    >
                        Back
                    </button>

                    <button
                        @click="ShowHideModal()"
                        type="button"
                        class="btn btn-link text-decoration-none ml-4 radius"
                    >
                        Cancel
                    </button>
                </div>

                <div>
                    <button
                        v-if="pageIndex == 0"
                        @click="Next()"
                        :disabled="pageIndex == 2 && errors"
                        type="button"
                        class="btn btn-light"
                    >
                        Next >
                    </button>

                    <button
                        v-if="pageIndex == 1"
                        @click="Next1()"
                        :disabled="pageIndex == 2 && errors"
                        type="button"
                        class="btn btn-light"
                    >
                        Next >
                    </button>
                    <button
                        v-if="EditOption == false && pageIndex == 2"
                        type="button"
                        @click="addProduct"
                        class="btn btn-primary"
                    >
                        Submit
                    </button>
                    <button
                        v-if="EditOption == true && pageIndex == 2"
                        type="button"
                        @click="updateProduct(values.id)"
                        class="btn btn-primary"
                    >
                        Update
                    </button>
                </div>
            </div>
        </div>

        <!-- We will make the mask fill the screen while the menu is visible. Because its z-index is 1 less than that of the menu, the menu will still be displayed on top of it -->
        <div
            class="drawer-mask"
            :style="{
                width: drawerVisible ? '100vw' : '0',
                opacity: drawerVisible ? '0.6' : '0',
            }"
            @click="isClose()"
        ></div>
    </div>
    <div class="col-sm-12">
        <breadCrumbs :main="'Home'" :title="'Property Data'" />
        <div class="card">
            <div style="text-align: right">
                <!-- <button class="toggle " type="contained" @click="drawerVisible = true">
          Show Menu
        </button> -->
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar data-table">
                    <div class="col-md-12 alignment">
                        <div class="col-md-6">
                            <button
                                class="btn btn-primary radius"
                                style="margin-bottom: 20px"
                                type="button"
                                @click="drawerVisible = true"
                            >
                                Create property
                            </button>
                        </div>
                        <div class="mb-3 col-md-6 row justify-content-end">
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
                    </div>

                    <table
                        class="table table-striped table-bordered"
                        v-if="apiResFormList != null"
                    >
                        <thead>
                            <tr>
                                <!-- <th scope="col" sortable="name">S/n</th> -->
                                <th scope="col" sortable="name">Id</th>
                                <th scope="col" sortable="startDate">
                                    Form Object Type
                                </th>
                                <th scope="col" sortable="invoice">
                                    Form Object Group
                                </th>
                                <th scope="col" sortable="position">
                                    Label No
                                </th>
                                <th scope="col" sortable="credit">
                                    Label Discription
                                </th>
                                <th scope="col" sortable="office">
                                    Filed Type
                                </th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="(data, index) in apiResFormList"
                                :key="data.id"
                            >
                                <!-- <td>{{ index + 1 }}</td> -->
                                <td style="text-transform: capitalize">
                                    {{
                                        (pagination.current_page - 1) *
                                            pagination.per_page +
                                        1 +
                                        index
                                    }}
                                </td>
                                <td style="text-transform: capitalize">
                                    {{ data.form_object_type.name }}
                                </td>
                                <td style="text-transform: capitalize">
                                    {{ data.form_object_type_group.name }}
                                </td>
                                <td style="text-transform: capitalize">
                                    {{ data.label_name }}
                                </td>
                                <td style="text-transform: capitalize">
                                    {{ data.label_description }}
                                </td>
                                <td style="text-transform: capitalize">
                                    {{ data.field_type }}
                                </td>
                                <td style="text-transform: capitalize">
                                    <div class="icons d-flex">
                                        <div>
                                            <i
                                                className="fa fa-pencil-square-o fa-lg"
                                                @click="EditForm(data.id)"
                                            ></i>
                                        </div>
                                        <!-- <div>
                       <i
                        className="fa fa-eye fa-lg"
                        @click="ViewForm(data.id)"
                      ></i>
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
                    <div class="no-content" v-if="apiResFormList == null">
                        No Content Found
                    </div>
                </div>
                <div>
                    <ul class="pagination-aligment">
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
import axios from "axios";
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
            title: "Create Propery",

            pageCount: 1,
            EditOption: false,
            apiRes: null,
            apiResGroup: null,
            apiResFormList: null,
            drawerVisible: false,
            pageIndex: 0,
            phoneNumbers: [
                {
                    phone: "",
                },
            ],
            numberFormatter: "formattedNumber",
            errors: {
                objectId: "",
                groupId: "",
                labelName: "",
                filedTy: "",
                dataTy: "",
            },

            values: {
                id: "",
                form_object_type_id: "",
                form_object_type_group_id: "",
                label_name: "",
                label_description: "",
                field_type: "",
                data_type: "",
                is_required: "",
                is_display_frontend: "",
                min: "",
                max: "",
                is_numeric: "",
                is_character: "",
                setMinCharacter: "",
                setMaxCharacter: "",
                inputFields: [],
            },
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
                        `${config.apiUrl}/api/form-fields?page=${this.pagination.current_page}&search=${this.filterQuery}`,
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
            } else {
                axios
                    .get(
                        `${config.apiUrl}/api/form-fields?page=${this.pagination.current_page}`,
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
            }

            // Fetch data for the new page from the server or perform any other necessary actions
            // For demonstration purposes, let's log the requested page
            console.log("Requested page:", page);
        },
        isClose() {
            this.EditOption = false;
            this.drawerVisible = false;
        },
        addInputField() {
            this.values.inputFields.push({
                value: "",
            }); // Add an empty input field to the array
        },
        removeInputField(index) {
            this.values.inputFields.splice(index, 1); // Remove the input field from the array based on the index
        },
        Next() {
            if (!this.values.form_object_type_id) {
                this.errors.objectId = "The Object Type Field is required";
            }
            if (!this.values.form_object_type_group_id) {
                this.errors.groupId = "The Group Field is required";
            }
            if (!this.values.label_name) {
                this.errors.labelName = "The Label Field is required";
            }
            if (
                this.values.form_object_type_id &&
                this.values.form_object_type_group_id &&
                this.values.label_name &&
                this.pageIndex == 0
            ) {
                this.errors.objectId = " ";
                this.errors.groupId = " ";
                this.errors.labelName = " ";
                this.pageIndex++;
            }
        },

        Next1() {
            if (!this.values.field_type) {
                this.errors.filedTy = "The Field Type is required";
            }
            if (!this.values.data_type) {
                this.errors.dataTy = "The Data Type is required";
            }
            if (
                this.values.field_type &&
                this.values.data_type &&
                this.pageIndex == 1
            ) {
                this.errors.filedTy = " ";
                this.values.dataTy = " ";
                this.pageIndex++;
            }
        },
        onObjectType() {
            let token = localStorage.getItem("token");
            //  id = this.values.form_object_type_id;
            //  this.getListGroup(id)
            axios
                .get(
                    `${config.apiUrl}/api/form-object_type-groups-list?obect_type_id=${this.values.form_object_type_id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                )
                .then((res) => {
                    this.apiResGroup = res.data.result;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        addField(value, fieldType) {
            fieldType.push({
                value: "",
            });
        },
        removeField(index, fieldType) {
            fieldType.splice(index, 1);
        },
        addProduct() {
            if (
                !this.values.form_object_type_id &&
                !this.values.form_object_type_group_id &&
                !this.values.label_name
            ) {
                this.errors = "Please fill required field";
            } else {
                this.errors = "";
                const Naveen = {
                    form_object_type_id: this.values.form_object_type_id,
                    form_object_type_group_id:
                        this.values.form_object_type_group_id,
                    label_name: this.values.label_name,
                    label_description: this.values.label_description,
                    data_type: this.values.data_type,
                    field_type: this.values.field_type,
                    validation_rules: {
                        is_required: this.values.is_required,
                        is_display_frontend: this.values.is_display_frontend,
                        min: this.values.min,
                        max: this.values.max,
                        is_numeric: this.values.is_numeric,
                        is_character: this.values.is_character,
                        setMinCharacter: this.values.setMinCharacter,
                        setMaxCharacter: this.values.setMaxCharacter,
                    },
                    field_values: this.values.inputFields,
                };
                console.log(Naveen, "navdddddddddddddddddeen");
                // console.log('gggg',Naveen);
                // return
                this.drawerVisible = false;
                // this.mapdata.push(Naveen)
                // this.getList();
                // console.log('yuuuyy', Naveen);
                let token = localStorage.getItem("token");
                axios
                    .post(config.apiUrl + "/api/form-fields", Naveen, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        console.log("ddddr", res);
                        this.getFormFieldsList();
                        window.location.reload();
                        // this.values = null
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        ShowHideModal() {
            this.drawerVisible = false;
            this.EditOption = false;
            this.pageIndex = 0;
            let rrrr = {
                id: "",
                form_object_type_id: "",
                form_object_type_group_id: "",
                label_name: "",
                label_description: "",
                field_type: "",
                is_required: "false",
                is_display_frontend: "false",
                min: "",
                max: "",
                is_numeric: "false",
                is_character: "false",
                setMinCharacter: "false",
                setMaxCharacter: "false",
            };

            this.values = rrrr;
        },
        onChange() {
            this.fieldType;
        },
        onNumberChange() {
            this.numberFormatter;
        },
        onChangeCharLimit() {
            this.setMinCharacter;
        },
        onChangeMaxCharLimit() {
            this.setMaxCharacter;
        },
        EditForm(data) {
            let token = localStorage.getItem("token");
            this.EditOption = true;
            axios
                .get(`${config.apiUrl}/api/form-fields/${data}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    this.drawerVisible = true;
                    let uuu = {
                        id: data,
                        form_object_type_id: res.data.result.object_id,
                        form_object_type_group_id: res.data.result.group_id,
                        label_name: res.data.result.label_name,
                        label_description: res.data.result.label_description,
                        field_type: res.data.result.field_type,
                        is_required:
                            res.data.result.validation_rules.is_required,
                        is_display_frontend:
                            res.data.result.validation_rules
                                .is_display_frontend,
                        min: res.data.result.validation_rules.min,
                        max: res.data.result.validation_rules.max,
                        is_numeric: res.data.result.validation_rules.is_numeric,
                        is_character:
                            res.data.result.validation_rules.is_character,
                        setMinCharacter:
                            res.data.result.validation_rules.setMinCharacter,
                        setMaxCharacter:
                            res.data.result.validation_rules.setMaxCharacter,
                        inputFields: res.data.result.field_values,
                        // data_type: res.data.result.data_type,
                    };
                    console.log(res.data.result, "prxxxxxxxxxxxxstik");

                    this.values = uuu;
                    console.log(this.values, "values");
                    this.onObjectType();
                })
                .catch((error) => {
                    console.error(error);
                });

            // this.drawerVisible = true;
            // this.values = data;
        },
        updateProduct(data) {
            if (
                !this.values.form_object_type_id ||
                !this.values.form_object_type_group_id ||
                !this.values.label_name
            ) {
                this.errors = "Please fill required field";
            } else {
                this.errors = "";
                const Naveen = {
                    form_object_type_id: this.values.form_object_type_id,
                    form_object_type_group_id:
                        this.values.form_object_type_group_id,
                    label_name: this.values.label_name,
                    label_description: this.values.label_description,
                    field_type: this.values.field_type,
                    validation_rules: {
                        is_required: this.values.is_required,
                        is_display_frontend: this.values.is_display_frontend,

                        min: this.values.setMinCharacter
                            ? this.values.min
                            : null,
                        max: this.values.setMaxCharacter
                            ? this.values.max
                            : null,
                        is_numeric: this.values.is_numeric,
                        is_character: this.values.is_character,
                        setMinCharacter: this.values.setMinCharacter,
                        setMaxCharacter: this.values.setMaxCharacter,
                    },
                    field_values: this.values.inputFields,
                };
                this.drawerVisible = false;
                // this.mapdata.push(Naveen)
                // this.getList();
                // console.log('yuuuyy', Naveen);
                let token = localStorage.getItem("token");
                axios
                    .put(`${config.apiUrl}/api/form-fields/${data}`, Naveen, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        // this.values = null;
                        window.location.reload();
                        console.log("ddddr", res);
                        this.getFormFieldsList();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        DeleteForm(data) {
            let token = localStorage.getItem("token");
            if (confirm("Do you really want to delete?")) {
                console.log(data);
                axios
                    .delete(`${config.apiUrl}/api/form-fields/${data}`, {
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
        getList() {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/form-object-types-list`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    console.log(res.data.result);
                    this.apiRes = res.data.result;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getFormFieldsList() {
            let token = localStorage.getItem("token");
            axios
                .get(`${config.apiUrl}/api/form-fields`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((res) => {
                    console.log("fffff", res);
                    this.apiResFormList = res.data.result.data;
                    this.pagination = res.data.result.pagination;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        filter() {
            let token = localStorage.getItem("token");

            if (this.filterQuery.length > 0) {
                axios
                    .get(
                        `${config.apiUrl}/api/form-fields?search=${this.filterQuery}`,
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    )
                    .then((res) => {
                        this.apiResFormList = res.data.result.data;
                        this.pagination = res.data.result.pagination;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                axios
                    .get(`${config.apiUrl}/api/form-fields`, {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    })
                    .then((res) => {
                        this.apiResFormList = res.data.result.data;
                        this.pagination = res.data.result.pagination;
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        handleInputChange() {
            this.pagination.per_page = this.pagination.per_page;
        },
        PageDecri() {
            this.pageCount--;
            let token = localStorage.getItem("token");

            axios
                .get(
                    `${config.apiUrl}/api/form-fields?page=${this.pageCount}`,
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
        pageIncri() {
            this.pageCount++;
            let token = localStorage.getItem("token");

            axios
                .get(
                    `${config.apiUrl}/api/form-fields?page=${this.pageCount}`,
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
    },
    mounted() {
        this.getList();
        // this.getListGroup();
        this.getFormFieldsList();
    },
};
</script>

<style scoped>
.small_font {
    color: #516f90;
}

.form_checkbox {
    display: inline-grid;
}

.drag-handler {
    width: 0.625rem;
    position: relative;
    background-color: #e4e6eb;
    background-image: linear-gradient(
        45deg,
        #e4e6eb,
        #e4e6eb 0.125rem,
        #fff 0.125rem,
        #fff 0.25rem,
        #e4e6eb 0.25rem,
        #e4e6eb 0.5625rem,
        #fff 0.5625rem,
        #fff 0.6875rem,
        #e4e6eb 0.6875rem,
        #e4e6eb 1rem,
        #fff 1rem,
        #fff 1.125rem,
        #e4e6eb 1.125rem,
        #e4e6eb 1.375rem
    );
    background-size: 0.625rem 1.25rem;
    cursor: move;
    border-top: 0.125rem solid #fff;
    border-bottom: 0.125rem solid #fff;
}

.drag-handler:active {
    background-image: linear-gradient(
        45deg,
        #bab86c,
        #bab86c 0.125rem,
        #fff 0.125rem,
        #fff 0.25rem,
        #bab86c 0.25rem,
        #bab86c 0.5625rem,
        #fff 0.5625rem,
        #fff 0.6875rem,
        #bab86c 0.6875rem,
        #bab86c 1rem,
        #fff 1rem,
        #fff 1.125rem,
        #bab86c 1.125rem,
        #bab86c 1.375rem
    );
    background-size: 0.625rem 1.25rem;
}

.list_down {
    font-size: 0.9375rem;
    list-style-type: none;
    display: flex;
    color: #0091ae;
    gap: 1.5625rem;
}

.table_label {
    font-size: 0.75rem;
    font-weight: 500;
}

.form {
    height: 27.8125rem;
}

.progressbar {
    position: relative;
    display: flex;
    justify-content: space-between;
    counter-reset: step;
    margin: 16px 0 32px;
}

.progressbar::before,
.progress {
    content: "";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 0.25rem;
    width: 100%;
    background-color: #dcdcdc;
    z-index: -1;
}

.progress {
    background-color: var(--primary-color);
    width: 0%;
    transition: 0.3s;
}

.progress-step {
    font-size: 0.625rem;
    width: 19px;
    height: 19px;
    background-color: #dcdcdc;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.progress-step::after {
    content: attr(data-title);
    position: absolute;
    top: calc(100% + 8px);
    font-size: 13.6px;
    color: #666;
}

.progress-step-active {
    background-color: red;
    color: #f3f3f3;
}

.progress_name {
    font-size: 0.625rem;
}

.yyyy {
    display: flex;
    justify-content: space-evenly;
    text-align: center;
    margin-top: 0.3125rem;
}

/* Make circles that indicate the steps of the form: */
.step {
    height: 0.9375rem;
    width: 0.9375rem;
    margin: 0 0.125rem;
    background-color: #bbbbbb;
    border: none;
    border-radius: 50%;
    display: inline-block;
    opacity: 0.5;
}

.step.active {
    opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
    background-color: #04aa6d;
}

.progressbar {
    counter-reset: step;
    margin: auto;
    margin-top: 0.8125rem;
}

.progressbar li {
    list-style-type: none;
    color: black;
    text-transform: uppercase;
    font-size: 0.5625rem;
    width: 33.33%;
    float: left;
    position: relative;
}

.progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 1.25rem;
    line-height: 1.25rem;
    display: block;
    font-size: 0.625rem;
    color: #333;
    background: white;
    border-radius: 0.1875rem;
    margin: 0 auto 0.3125rem auto;
}

/*progressbar connectors*/
.progressbar li:after {
    content: "";
    width: 100%;
    height: 0.125rem;
    background: black;
    position: absolute;
    left: -50%;
    top: 0.5625rem;
    z-index: -1;
    /*put it behind the numbers*/
}

.progressbar li:first-child:after {
    /*connector not needed before the first step*/
    content: none;
}

/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
.progressbar li.active:before,
#progressbar li.active:after {
    background: #27ae60;
    color: white;
}

.label {
    font-size: small;
    margin-bottom: 8px;
    color: black;
}

.form-select {
    background: #eee;
    border-color: #eee;
    font-size: 0.875rem;
    padding: 0.75rem 0.9375rem;
}

.form-control {
    /* background-color: #eee;
    border-color: #eee;
    font-size: 0.875rem;
    padding: 0.75rem 0.9375rem; */
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.375rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.modal_header {
    display: flex;
    justify-content: space-between;

    background-color: #5c61f2;
    background-image: linear-gradient(-303deg, #5c61f2, #5c61f2);
}

.modal_divider {
    margin-top: 8.125rem;
}

.modal_footer {
    display: flex;
    background: #7080902b;

    padding: 0.6875rem;
    justify-content: space-between;
}

#app {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

h1,
h2,
h3,
h4,
h5 {
    font-weight: 400;
    color: #0ca3a3;
}

h1 {
    color: teal;
}

a {
    color: #0091ae;
    text-decoration: none;
}

.toggle {
    width: 7.5rem;
    background: white;
    color: tomato;
    border: 0;
    padding: 0.3125rem;
    cursor: pointer;
}

.close {
    background-color: #5c61f2;
    color: white;
    border: 0;
    cursor: pointer;
}

.filed-type {
    max-height: 27.375rem;
    overflow: auto;
}

.right-drawer {
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    /* initially */
    overflow: hidden;
    height: 100vh;
    padding-left: 0;
    /* initially */
    border-left: 0.0625rem solid whitesmoke;
    background: white;
    z-index: 200;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    width: 100%;
    z-index: 99999999;
    position: fixed !important;
}

.drawer-mask {
    position: absolute;
    left: 0;
    top: 0;
    width: 0;
    /* initially */
    height: 100%;
    background: #000;
    opacity: 0.3;
    z-index: 199;
    transition: opacity 0.2s;
}

#exampleFormControlInput1 {
    width: 100%;
    border-radius: 7px;
    background: #eee;
    border-color: #eee;
    font-size: 0.875rem;
    padding: 0.9rem 0.9375rem;
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

.card {
    border-radius: 10px !important;
}

.alignment {
    display: flex;
    justify-content: space-between;
}

.pagination-aligment {
    display: flex;
    justify-content: flex-end;
}
.dataType {
    display: none;
}
</style>
