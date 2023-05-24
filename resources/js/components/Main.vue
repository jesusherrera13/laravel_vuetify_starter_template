<template>
    <v-app id="inspire">
      <v-navigation-drawer v-model="drawer">
        <v-sheet
        color="grey-lighten-4"
        class="pa-4"
      >
        <v-avatar
          class="mb-4"
          color="grey-darken-1"
          size="64"
        ></v-avatar>

        <div>{{ user.email }}</div>
      </v-sheet>


        <v-list density="compact" >
          <v-list v-model:opened="open" nav :lines="false">
              <v-list-item prepend-icon="mdi-home" title="Dashboard" value="dashboard" to="/"></v-list-item>
              <template v-for="modulo in system_modulos" :value="modulo.id">
                <v-list-group v-if="modulo.menus.length">
                  <template v-slot:activator="{ props }">
                    <v-list-item
                      v-bind="props"
                      :title="modulo.nombre"
                      :prepend-icon="modulo.mdi_icon"
                    ></v-list-item>
                  </template>
                  <v-list-item
                      v-for="(menu, i) in modulo.menus"
                      :key="menu.key"
                      :value="menu.key"
                      :title="menu.nombre"
                      :prepend-icon="menu.mdi_icon"
                      :to="menu.route"
                    ></v-list-item>
                </v-list-group>
                <v-list-item v-else :prepend-icon="modulo.mdi_icon" :title="modulo.nombre" :value="modulo.key" :to="modulo.route"></v-list-item>

              </template>
            </v-list>
        </v-list>

        <template v-slot:append>
            <div class="pa-2">
                <v-btn block 
                    prepend-icon="mdi-logout"
                    @click="$emit('logout')"
                    title="Logout"
                >
                    {{ !rail ? 'Logout' : ''}}
                </v-btn>
            </div>
        </template>


      </v-navigation-drawer>
  
      <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title>Application</v-toolbar-title>
      </v-app-bar>
  
      <v-main>
        <router-view
          :user="user"
          :token="token"
          :app_name="app_name"
          :app_api="app_api"
          :temporada="temporada"
          @system-modulos="$emit('system-modulos', $event)"

        ></router-view>
      </v-main>
    </v-app>
  </template>
  
<script>
export default {
    props: {
        user: Object,
        token: String,
        app_name: String,
        app_api: String,
        temporada: Object,
        system_modulos: Object,
    },
    data: () => ({ 
      drawer: null, 
      rail: null,
      open: ['configuracion'],
    }),
}
</script>