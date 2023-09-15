<template>
    <div class="card-body">
        <errors :success="success" :failure="failure" :message="message" :loading="loading"/>
        <form @submit.prevent="validate" method="post" ref="form" autocomplete="off">
            <div class="form-group">
                <label for="exampleInputEmail1">Social Media Type<span style="color: red">*</span></label>

                <select name="type" class="form-control form-select form-select-sm"  v-model="socialTypeValue" @change="openForm" required>
                    <option value="" selected disabled>--Select Social Type--</option>
                    <option v-for="(name, id) in socialType" :value="id">{{ name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Execution ON<span style="color: red">*</span></label>
                <select name="type" class="form-control form-select form-select-sm"  v-model="timePeriod" required>
                    <option value="" selected disabled>--Select Time Period--</option>
                    <option v-for="(name, id) in timeFrame" :value="id">{{ name }}</option>
                </select>
            </div>

            <div class="form-group" v-if="showSocialTyleVal === 2">
                <label for="exampleInputEmail1">Content Type<span style="color: red">*</span></label>
                <select name="type" class="form-control form-select form-select-sm" v-model="content" required>
                    <option value="" selected disabled>--Select Time Period--</option>
                    <option v-for="(name, id) in contentType" :value="id">{{ name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Time<span style="color: red">*</span></label>
                <div class="row g-3">
                    <div v-for="(val, index) in inputValues" class="col-md-12" id="timeBlock">
                        <input
                            class='form-control'
                            type="time"
                            :key="index"
                            v-model="dynamicValues[index]"
                            name="time"
                            style="margin-bottom: 15px;"
                        />
                        <button @click="removeInputField(index)">Remove</button>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <button type="button" class="btn-dark" style="float: left; width: 200px" @click="addTimeBlock">Add More Time Periods</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
import Errors from '../partials/Errors.vue'

export default {
    components: {Errors},
    name: "Credentials",
    data() {
        return {
            type: null,
            success: false,
            failure: false,
            message: '',
            token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
            socialTypeValue: null,
            timePeriod: null,
            content: null,
            showSocialTyleVal: 0,
            dynamicValues: [],
            inputValues: [{ id: Date.now()}],
            socialType: {
                1: 'YOUTUBE',
                2: 'INSTAGRAM',
                3: 'FACEBOOK',
                4: 'GOOGLE DRIVE'
            },
            timeFrame: {
                1: 'HOURLY',
                2: 'DAILY',
                3: 'WEEKLY',
                4: 'MONTHLY',
                5: "YEARLY"
            },
            contentType: {
                1: 'POST',
                2: 'REEL/SHORTS',
                3: 'CAROUSAL'
            },
            errors: {
                email: '',
            },
            inputFields: [
                { id: Date.now(), value: ''}
            ] // Array to store input field data
        }
    },
    methods: {

        openForm() {
            this.showSocialTyleVal = parseInt(this.socialTypeValue);
        },

        removeInputField(index) {
            this.dynamicValues.splice(index, 1);
        },

        addTimeBlock()
        {
            // Generate a unique ID for each input field
            const newInputField = { id: Date.now(), value: ''};
            // Push the new input field to the array
            this.inputValues.push(newInputField);
        },

        validate(e) {
            event.preventDefault();

            this.loading = true
            this.failure = false
            this.success = false

            let request = {
                'type': this.socialTypeValue,
                'period': this.timePeriod,
                'contentType': this.content,
                'timeSlot': this.dynamicValues,
                _token: this.token
            }

            // Empty the errors
            this.errors.email = null
            axios.post('/addSchedulerData', request)
                .then(res => {
                    this.loading = false
                    this.success = true
                    this.message = "Successfully."
                    this.failure = false

                    setTimeout(() => {
                        window.location.href = '/addSchedule'
                    }, 1000)
                })
                .catch(err => {
                    console.log(err.response)
                    this.loading = false
                    this.failure = true

                    // Show the error message
                    this.message = err.response.data.message
                    //this.errors.email = err.response.data.errors.email ? err.response.data.errors.email[0] : null
                    this.success = false
                });
        }
    }
}
</script>
