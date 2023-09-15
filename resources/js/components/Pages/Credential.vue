<template>
    <div class="card-body">
        <errors :success="success" :failure="failure" :message="message" :loading="loading"/>
        <form method="post" ref="form" autocomplete="off">
            <div class="form-group">
                <label for="exampleInputEmail1">Social Media Type<span style="color: red">*</span></label>

                <select name="type" class="form-control form-select form-select-sm" required v-model="socialTypeValue"
                        @change="openForm">
                    <option value="" selected disabled>--Select Social Type--</option>
                    <option v-for="(name, id) in socialType" :value="id">{{ name }}</option>
                </select>
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Redirect URI<span style="color: red">*</span></label>
                <input type="text" class="form-control" id="redirect" v-model="redirectUrl"
                       placeholder="Enter Redirect URI">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Client ID<span style="color: red">*</span></label>
                <input type="text" class="form-control" id="id" v-model="clientId" placeholder="Enter Client ID"
                       required
                       autocomplete="off">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Client Secret<span style="color: red">*</span></label>
                <input type="text" class="form-control" id="secret" v-model="clientSecret"
                       placeholder="Enter Client Secret"
                       required>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">oAuth Url</label>
                <input type="text" class="form-control" id="oAuthUrl" v-model="oAuthurl"
                       placeholder="Enter oAuthUrl">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">OAuth 2.0 Key</label>
                <input type="text" class="form-control" id="oauth" v-model="oAuthKey"
                       placeholder="Enter OAuth 2.0 Key">
            </div>
            <hr>

            <!--            Youtube         -->
            <div v-if="showSocialTyleVal === 1">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email<span style="color: red">*</span></label>
                    <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter Email ID"
                           required>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Youtube Api Base Url<span style="color: red">*</span></label>
                    <input type="text" class="form-control" id="url" v-model="baseUrl" placeholder="Enter Base URL"
                           required>
                </div>

            </div>

            <!--            Instagram         -->
            <div v-if="showSocialTyleVal === 2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email<span style="color: red">*</span></label>
                    <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter Email ID"
                           required>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Instagram User Name<span style="color: red">*</span></label>
                    <input type="email" class="form-control" id="email" v-model="username" placeholder="Enter Username"
                           required>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Instagram Api Base Url<span style="color: red">*</span></label>
                    <input type="text" class="form-control" id="url" v-model="baseUrl" placeholder="Enter Base URL"
                           required>
                </div>

            </div>

            <!--            Instagram         -->
            <div v-if="showSocialTyleVal === 4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email<span style="color: red">*</span></label>
                    <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter Email ID"
                           required>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">google Drive Base Url<span style="color: red">*</span></label>
                    <input type="text" class="form-control" id="url" v-model="baseUrl" placeholder="Enter Base URL"
                           required>
                </div>

            </div>

            <button type="button" class="btn btn-primary" @click="validate($event)">Submit</button>
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
            email: null,
            baseUrl: null,
            oAuthurl: null,
            redirectUrl: null,
            clientId: null,
            clientSecret: null,
            oAuthKey: null,
            username: null,
            success: false,
            failure: false,
            message: '',
            token: document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
            socialType: {
                1: 'YOUTUBE',
                2: 'INSTAGRAM',
                // 3: 'FACEBOOK',
                4: 'GOOGLE DRIVE'
            },
            showSocialTyleVal: 0,
            socialTypeValue: null,
            errors: {
                email: '',
            }
        }
    },
    methods: {
        openForm() {
            this.showSocialTyleVal = parseInt(this.socialTypeValue);
        },

        validate(event) {
            event.preventDefault()
            // Show the loading alert
            this.loading = true
            this.failure = false
            this.success = false

            // Register the user
            let user = {
                socialType: this.socialTypeValue,
                email: this.email,
                baseUrl: this.baseUrl,
                id: this.clientId,
                secret: this.clientSecret,
                redirect: this.redirectUrl,
                oauthUrl: this.oAuthurl,
                oauthKey: this.oAuthKey,
                username: this.username,
                _token: this.token
            }

            // Empty the errors
            this.errors.email = null
            axios.post('credentials', user)
                .then(res => {
                    this.loading = false
                    this.success = true
                    this.message = "Successfully."
                    this.failure = false

                    setTimeout(() => {
                        window.location.href = '/home'
                    }, 1000)
                })
                .catch(err => {
                    console.log(err.response)
                    this.loading = false
                    this.failure = true

                    // Show the error message
                    this.message = err.response.data.message
                    this.errors.email = err.response.data.errors.email ? err.response.data.errors.email[0] : null
                    this.success = false
                })
        }
    }
}
</script>
<style scoped>

</style>
