<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <div class="col">
        <vuestic-widget :headerText="role.name">
          <div class="row show-buttons-area">
            <router-link
              :to="{ name: 'roles' }"
              class="btn btn-info btn-micro"
            >
              {{'menu.roles.roles' | translate}}
            </router-link>
            <router-link 
              class="btn btn-primary btn-micro"
              :to="{ name: 'update-role', params: { id: this.$route.params.id } }"
            >
              {{'buttons.update' | translate}}
            </router-link>
          </div>

          <div class="row">
            <div class="col">
              <blockquote class="blockquote">
                {{ 'role.permissions' | translate }}
              </blockquote>
            </div>
          </div>

          <div class="row">
            <div class="col col-md-3"
                 :key="permission.id"
                 v-for="permission in permissionsItems">
              <div class="checkbox">
                <input type="checkbox" disabled="disabled" 
                  name="permissions" 
                  :name="permission.id"
                  :value="permission.id" 
                  v-model="permissions">
                <label :for="permission.id">{{ permission.name }}</label>
              </div>
            </div>
          </div>
        </vuestic-widget>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import api from 'src/packages/Api'
  import Loading from 'partials/Loading'

  Vue.component('loading', Loading)

  export default {
    name: 'role',
    components: {
    },
    data () {
      return {
        role: {},
        id: '',
        name: '',
        permissions: [],
        permissionsItems: [],
        loaded: false
      }
    },
    created () {
      api.get(`roles/${this.$route.params.id}`).then(response => {
        const res = response.data

        this.role = res
        this.id = res.id
        this.name = res.name
        this.permissions = res.permissions.data.map(per => per.id)

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'roles' })
      })
      api.get('permissions').then(res => {
        this.permissionsItems = res.data
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.status}`) }
        )
        this.$router.push({ name: 'roles' })
      })
    }
  }
</script>

