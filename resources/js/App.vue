<template>
    <Main v-if="token"
        ref="main"
        :user="user"
        :token="token"
        :app_name="app_name"
        :app_api="app_api"
        :system_modulos="system_modulos"
        @logout="logout"
        @system-modulos="systemModulos"
    />
    <Login v-else
        :app_name="app_name"
        :app_api="app_api"
        @login="login"
    />
</template>
<script>
export default {
    data() {
        return {
            user: {},
            app_name: import.meta.env.VITE_APP_NAME,
            app_api: import.meta.env.VITE_APP_API,
            token: null,
            system_modulos: null,
            messages: []
        }
    },
    created() {
        if(localStorage.getItem(`${this.app_name}_token`)) {

            this.user = JSON.parse(localStorage.getItem(`${this.app_name}_user`));
            this.token = localStorage.getItem(`${this.app_name}_token`);

        }
        else this.$router.push('/login');
    },
    mounted() {
        this.systemModulos();
    },
    methods: {
        login(response) {

            if(response.token) {

                let app_name = import.meta.env.VITE_APP_NAME;
                this.user = response.user;
                this.token = response.token;
                this.system_modulos = response.system_modulos;

                localStorage.setItem(`${app_name}_user`, JSON.stringify(this.user));
                localStorage.setItem(`${app_name}_token`, this.token);
                // localStorage.setItem(`${app_name}_system_modulos`, JSON.stringify(this.system_modulos));
                
                this.$router.push('/');
            }
        },
        logout() {

            this.overlay = true;
            let _this = this;

            axios.post(`${this.app_api}/logout`, this.user, this.requestHeaders())
                .then(function (response) {
                    if(response.status == 201) {
                        _this.user = {};
                        _this.token = null;
                        localStorage.clear();
                    }
                    _this.overlay = false;
                })
                .catch(function (error) {
                    console.log(error.response.status);
                })
                .then(function () {
                    _this.overlay = false;
                });
        },
        setTemporada(temporada) {
            let _this = this;
            _this.overlay = true;
            this.temporada = temporada;
            localStorage.setItem(`${app_name}_temporada`, JSON.stringify(temporada));

            /* 
            axios.get(`/${import.meta.env.VITE_APP_API}/temporada-equipos/${this.temporada.id}`, this.requestHeaders())
                .then(function (response) {
                    if(response.status == 200) {
                        _this.temporada_equipos = response.data;
                        _this.temporada_equipos.sort((a, b) => {
                            if(a.descripcion < b.descripcion) return -1;
                        });
                    }
                    _this.overlay = false;
                })
                .catch(function (error) {
                    console.log(error.response.status);
                })
                .then(function () {
                    _this.overlay = false;
                });  
            */
        },
        getTemporada(X) {
            return this.temporada;
        },
        async systemModulos(x) {
            if(this.token) {

                let _this = this;
                this.overlay = true;
                _this.errors = [];
                axios.defaults.withCredentials = true;
    
                await axios.post(`/${this.app_api}/system-modulos`, {}, this.requestHeaders())
                    .then(response => {
                        _this.system_modulos = response.data;
                        console.log(_this.system_modulos)
                        _this.overlay = false;
                    })
                    .catch(function (error) {
    
                       if(error.response.data.errors) {
    
                           Object.keys(error.response.data.errors).forEach(key => {
                               _this.messages.push({key: key, text: error.response.data.errors[key][0]});
                           });
                       }
    
                        _this.dialog = _this.messages.length ? true : false;
    
                        _this.overlay = false;
                    })
                    .then(function () {
                        _this.overlay = false;
                    });
            }
        },
        getCuentaTemporadas() {
            let _this = this;
            this.overlay = true;
            _this.errors = [];
            axios.defaults.withCredentials = true;
            
            axios.get(`/${this.app_api}/cuenta-temporadas/${this.user.cuenta_id}`, this.requestHeaders())
                .then(response => {
                    _this.temporadas = response.data;
                    _this.overlay = false;
                })
                .catch(function (error) {
                    Object.keys(error.response.data.errors).forEach(key => {
                        _this.errors.push({key: key, text: error.response.data.errors[key][0]});
                    });
                    _this.dialog = _this.messages.length ? true : false;
                    _this.overlay = false;
                })
                .then(function () {
                    _this.overlay = false;
                });
        },
        requestHeaders() {
            return {headers: { Authorization: `Bearer ${this.token}` }};
        }
    }
}
</script>