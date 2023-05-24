<template>
    <div class="py-4">
        <v-img
            class="mx-auto mb-10"
            max-width="228"
            src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
        ></v-img>

        <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >

            <div class="text-subtitle-1 text-medium-emphasis">Account</div>

            <v-text-field
                v-model="user.email"
                density="compact"
                placeholder="Email address"
                prepend-inner-icon="mdi-email-outline"
                variant="outlined"
            ></v-text-field>

            <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                Password

                <a
                    class="text-caption text-decoration-none text-blue"
                    href="#"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    Forgot login password?
                </a>
            </div>

            <v-text-field
                v-model="user.password"
                :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                :type="visible ? 'text' : 'password'"
                density="compact"
                placeholder="Enter your password"
                prepend-inner-icon="mdi-lock-outline"
                variant="outlined"
                @click:append-inner="visible = !visible"
            ></v-text-field>

            <v-btn
                block
                class="mb-8"
                color="blue"
                size="large"
                variant="tonal"
                @click="login"
            >
                Log In
            </v-btn>

        </v-card>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        token: String,
        app_name: String,
        app_api: String,
    },
    data() {
        return {
            user: {
                email: 'eljuegoperfectomx13@gmail.com',
                password: null,
            },
            overlay: false,
            visible: false,
        }
    },
    created() {
    },
    methods: {
        login() {
            this.overlay = true;
            let _this = this;
            axios.post(`${this.app_api}/login`, this.user)
                .then(function (response) {
                    // _this.jugadores = response.data;
                    _this.overlay = false;
                    _this.$emit('login', response.data);
                })
                .catch(function (error) {
                    // manejar error
                    console.log(error.response.status);
                })
                .then(function () {
                    // siempre sera executado
                    _this.overlay = false;
                });
        }
    }
}
</script>