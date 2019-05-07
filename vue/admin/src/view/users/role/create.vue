<template>
  <div class="form-elements">
    <div class="row">
      <div class="col-md-12">
        <vuestic-widget :headerText="'menu.roles.create' | translate">
          <div class="row">
            <div class="col">
            </div>
            <div class="col">
              <div class="form-group with-icon-right"
                   :class="{'has-error': errors.has('name')}">
                <div class="input-group">
                  <input
                    id="name"
                    name="name"
                    v-model="name"
                    v-validate="'required'"
                    required/>
                  <i
                    class="fa fa-exclamation-triangle icon-right input-icon"
                    v-show="errors.has('name')"></i>
                  <label class="control-label" for="name">{{'role.name'
                    | translate}}</label><i class="bar"></i>
                  <small v-show="errors.has('name')"
                         class="help text-danger">{{
                    errors.first('name')
                    }}
                  </small>
                </div>
              </div>
            </div>
            <div class="col">
            </div>
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
                {{'buttons.submit' | translate}}
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
    name: 'create-role',
    data () {
      return {
        name: '',
        permissions: [],
        permissionsItems: []
      }
    },
    created () {
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

            api.post('roles', data).then(response => {
              this.$store.dispatch('addToastMessage',
                { text: Vue.i18n.translate('roles.created'), type: 'success' }
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
