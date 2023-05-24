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
                    :items="modulos"
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
                        <span class="text-h5">Módulo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        v-model="registro.nombre"
                                        label="Nombre"
                                        required
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        v-model="registro.key"
                                        label="Key"
                                        required
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        v-model="registro.route"
                                        label="Route"
                                        required
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                >
                                    <v-text-field
                                        v-model="registro.mdi_icon"
                                        label="MDI Icon"
                                        required
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-select
                                        v-model="registro.status"
                                        label="Status"
                                        density="compact"
                                        item-value="id"
                                        item-title="nombre"
                                        :items="status"
                                        variant="outlined"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
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
        
        <Overlay :overlay="overlay"/>
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
            modulos: [],
            overlay: false,
            dialog: false,
            registro: { id: null, nombre: null, key: null, $router: null, mdi_icon: null, status: null },
            breadcrumbs: [
                {
                    title: 'Dashboard',
                    disabled: false,
                    href: '/',
                },
                {
                    title: 'Registros',
                    disabled: true,
                    href: '/registro',
                },
                {
                    title: 'Nuevo',
                    disabled: false,
                    href: '/registro/nuevo',
                },
            ],
            search: '',
            itemsPerPage: 20,
            headers: [
                { title: 'Nombre', align: 'start', sortable: true, key: 'nombre' },
                { title: 'Key', align: 'start', sortable: true, key: 'key' },
                { title: 'Route', align: 'start', sortable: true, key: 'route' },
                { title: 'MDI Icon', align: 'start', sortable: true, key: 'mdi_icon' },
                { title: '', align: 'end',key: 'actions', sortable: false },
            ],
            status: [
                { id: 1, nombre: 'Activo' },
                { id: 2, nombre: 'Inctivo' },
            ],
        }
    },
    created() {
        this.getModulos();
    },
    methods: {
        async getModulos() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            axios.get(`${this.app_api}/system-modulo`, this.requestHeaders())
                .then(response => {
                    _this.modulos = response.data;

                    _this.modulos.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    this.overlay = false;
                })
                .catch(function (error) {
                    console.log(error.response.status);
                    this.overlay = false;
                });
        },
        async guardar() {
            let _this = this;
            this.overlay = true;

            axios.defaults.withCredentials = true;

            let url = `${this.app_api}/system-modulo`;

            if(this.registro.id) url += `/${this.registro.id}`;

            axios.post(`${url}`, this.registro, this.requestHeaders())
                .then(response => {
                    _this.registro = { id: null, nombre: null, key: null, $router: null, mdi_icon: null, status: null };
                    _this.getModulos();
                    _this.dialog = false;
                    _this.overlay = false;
                    _this.$emit('system-modulos');
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
            this.registro = {...item};
            this.dialog = true;
        },
        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        requestHeaders() {
            return {headers: { Authorization: `Bearer ${this.token}` }};
        }
    }
}
</script>