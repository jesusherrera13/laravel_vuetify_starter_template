import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import App from '@/App.vue';
import Main from '@/components/Main.vue';
import Login from '@/components/Auth/Login.vue';

import router from '@/router/index';

import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';
import { createVuetify } from 'vuetify'

import * as components_ from 'vuetify/components';
import * as directives from 'vuetify/directives';
import * as labs from 'vuetify/labs/components';

const app = createApp(App);
const vuetify = createVuetify({
  components: {

    ...components_,
    ...labs,
  },
  directives,
});

app.use(router);
app.use(vuetify)
app.component('Login', Login);
app.component('Main', Main);

app.mount('#app');