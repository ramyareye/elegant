<template>
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="role.name">
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
                <input type="checkbox" 
                  name="permissions" 
                  :name="permission.id"
                  :value="permission.id" 
                  v-model="permissions">
                <label :for="permission.id">{{ permission.name }}</label>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col text-center">
              <button class="btn btn-success"  @click="add">
                {{'buttons.update' | translate}}
              </button>
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

  export default {
    name: 'update-role',
    data () {
      return {
        role: {},
        id: '',
        name: '',
        permissions: [],
        permissionsItems: []
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
    },
    methods: {
      add () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            const data = {
              name: this.name,
              permissions: this.permissions
            }

            api.put(`roles/${this.id}`, data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: Vue.i18n.translate('role.updated'), type: 'success' }
              )
              this.$router.push({ name: 'role', params: { id: response.data.id } })
            }).catch(error => {
              this.$store.dispatch('addToastMessage',
                { text: Vue.i18n.translate('errors.any'), error }
              )
              this.$store.dispatch('addToastMessage',
                { text: error.data.message }
              )
            })
          }
        })
      }
    }
  }
</script>
