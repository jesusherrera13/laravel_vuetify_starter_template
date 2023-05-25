<template>
    <v-container>
        <v-card class="mb-3">
            <v-card-text>
                <v-row >
                    <v-col
                    >
                        <h2>ACCESOS</h2>
                        <v-breadcrumbs
                            :items="breadcrumbs"
                            divider="/"
                            >
                        </v-breadcrumbs>
                    </v-col>
                </v-row>
                <v-row align="center" no-gutters>
                    <v-col
                        cols="6"
                    >
                    {{ user_id }}
                    <v-autocomplete
                        v-model="user_id"
                        clearable
                        label="Autocomplete"
                        :items="usuarios"
                        item-value="id"
                        item-title="name"
                        @change="nuevo()"

                    ></v-autocomplete>
                    </v-col>

                    <v-col cols="6" class="text-right">
                        <v-btn
                            size="small"
                            prepend-icon="mdi-content-save"
                            @click="guardar"
                            class="mr-1"
                        >
                            Guardar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card>
            {{ selected }}
            <v-container>
                <v-data-table
                    v-model:items-per-page="itemsPerPage"
                    :headers="headers"
                    :items="system_modulos"
                    :search="search"
                    density="compact"
                    v-model="selected"
                    show-select
                >
            
                </v-data-table>
            </v-container>
        </v-card>
        
    </v-container>
</template>
<script>
import axios from 'axios';
export default {
    props: {
        user: Object,
        token: String,
        app_name: String,
        app_api: String,
    },
    data() {
        return {
            overlay: false,
            dialog: false,
            password_reset: false,
            selected: [],
            user_id: null,
            usuarios: [],
            breadcrumbs: [
                { title: 'Dashboard', disabled: false, href: '/' },
                { title: 'Registros', disabled: true, href: '/registro' },
                { title: 'Nuevo', disabled: false, href: '/registro/nuevo' },
            ],
            search: '',
            itemsPerPage: 20,
            headers: [
                { title: 'Módulo', align: 'start', sortable: true, key: 'nombre' },
                { title: '', align: 'end',key: 'actions', sortable: false },
            ],
            status: [
                { id: 1, nombre: 'Activo' },
                { id: 2, nombre: 'Inctivo' },
            ],
            system_modulos: [],
        }
    },
    created() {
        this.getUsuarios();
        this.getSystemModulos();
    },
    methods: {
        async getUsuarios() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            axios.get(`/${this.app_api}/system-usuario`, this.requestHeaders())
                .then(response => {
                    _this.usuarios = response.data;

                    _this.usuarios.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    _this.overlay = false;
                })
                .catch(function (error) {
                    console.log(error.response.status);
                    _this.overlay = false;
                });
        },
        async getSystemModulos() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            axios.get(`/${this.app_api}/system-modulo`, this.requestHeaders())
                .then(response => {
                    _this.system_modulos = response.data;

                    _this.system_modulos.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    _this.overlay = false;
                })
                .catch(function (error) {
                    // console.log(error.response.status);
                    _this.overlay = false;
                });
        },
        async guardar() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            let payload = {
                user_id: this.user_id,
                selected_modules: this.selected,
            };

            axios.post(`/${this.app_api}/system-accesos-setup`, payload, this.requestHeaders())
                .then(response => {
                    // _this.getUsuarios();
                    // _this.dialog = false;
                    // _this.overlay = false;
                    // _this.$emit('system-usuarios');
                })
                .catch(function (error) {
                    console.log(error.response.status);
                    this.overlay = false;
                });
        },
        nuevo() {
            console.log('nuevo')
        },
        editItem (item) {
            this.usuario = {...item};
            this.dialog = true;
        },
        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        setResetPassword () {
            this.usuario.password = null;
            this.usuario.password_confirmation = null;
            this.password_reset = !this.password_reset;
        },
        requestHeaders() {
            return {headers: { Authorization: `Bearer ${this.token}` }};
        }
    },
    watch:{
        user_id(val, oldval) {
                //watch you code here
                console.log(val, oldval)
        },
        selected(val, oldval) {
                //watch you code here
                console.log(val, oldval)
        }
    }
}
</script>