<template>
    <v-container>
        <v-card class="mb-3">
            <v-card-text>
                <v-row >
                    <v-col
                    >
                        <h2>MÓDULOS</h2>
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
                        <v-text-field
                            v-model="search"
                            prepend-inner-icon="mdi-magnify"
                            label="Buscar..."
                            single-line
                            hide-details
                            clear-icon="mdi-close-circle"
                            clearable
                            variant="outlined"
                            density="compact"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6" class="text-right">
                        <v-btn
                            size="small"
                            prepend-icon="mdi-plus"
                            @click="dialog = true"
                            class="mr-1"
                        >
                            Nuevo
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card>
            <v-container>
                <v-data-table
                    v-model:items-per-page="itemsPerPage"
                    :headers="headers"
                    :items="usuarios"
                    :search="search"
                    density="compact"
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            size="small"
                            variant="flat"
                            icon="mdi-square-edit-outline"
                            @click="editItem(item.raw)"
                        ></v-btn>
                        <v-btn
                            size="small"
                            variant="flat"
                            icon="mdi-cog"
                            @click="$router.push(`/system-modulo/${item.raw.id}`)"
                        ></v-btn>
                        <v-btn
                            size="small"
                            variant="flat"
                            icon="mdi-delete"
                            @click="deleteItem(item.raw)"
                        ></v-btn>
                    </template>
            
                </v-data-table>
            </v-container>
        </v-card>


        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                persistent
                width="800"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Usuario</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field v-show="false"
                                        v-model="usuario.id"
                                        type="hidden"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="usuario.name"
                                        label="Nombre"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        v-model="usuario.email"
                                        label="Email"
                                        hint="Escriba un Email válido"
                                        required
                                        type="email"
                                        :readonly="usuario.id ? true : false"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" v-show="!usuario.id || password_reset">
                                    <v-text-field
                                        v-model="usuario.password"
                                        label="Password"
                                        persistent-hint
                                        required
                                        type="password"
                                        :readonly="usuario.id  && !password_reset ? true : false"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" v-show="!usuario.id || password_reset">
                                    <v-text-field
                                        v-model="usuario.password_confirmation"
                                        label="Password confirmation"
                                        required
                                        type="password"
                                        :readonly="usuario.id  && !password_reset ? true : false"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        v-model="usuario.rol_id"
                                        label="Rol"
                                        density="compact"
                                        item-value="id"
                                        item-title="nombre"
                                        :items="system_roles"
                                        variant="outlined"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn v-show="usuario.id"
                            color="blue-darken-1"
                            variant="text"
                            @click="setResetPassword"
                        >
                            Reset Password
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="dialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue-darken-1"
                            variant="text"
                            @click="guardar"
                        >
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
        
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
            usuario: { id: null, name: null, email: null, password: null, rol_id: null },
            breadcrumbs: [
                { title: 'Dashboard', disabled: false, href: '/' },
                { title: 'Registros', disabled: true, href: '/registro' },
                { title: 'Nuevo', disabled: false, href: '/registro/nuevo' },
            ],
            search: '',
            itemsPerPage: 20,
            headers: [
                { title: 'Nombre', align: 'start', sortable: true, key: 'name' },
                { title: 'Email', align: 'start', sortable: true, key: 'email' },
                { title: 'Rol', align: 'start', sortable: true, key: 'rol' },
                { title: '', align: 'end',key: 'actions', sortable: false },
            ],
            status: [
                { id: 1, nombre: 'Activo' },
                { id: 2, nombre: 'Inctivo' },
            ],
            usuarios: [],
            system_roles: [],
        }
    },
    created() {
        this.getUsuarios();
        this.getSystemRoles();
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
        async getSystemRoles() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            axios.get(`/${this.app_api}/system-roles`, this.requestHeaders())
                .then(response => {
                    _this.system_roles = response.data;

                    _this.system_roles.sort((a, b) => {
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

            let url = this.app_api;

            if(this.usuario.id) url += `/user-update/${this.usuario.id}`;
            else url += `/register`;

            axios.post(`${url}`, this.usuario, this.requestHeaders())
                .then(response => {
                    _this.usuario = { id: null, name: null, email: null, password: null, rol_id: null };
                    _this.getUsuarios();
                    _this.dialog = false;
                    _this.overlay = false;
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
    }
}
</script>