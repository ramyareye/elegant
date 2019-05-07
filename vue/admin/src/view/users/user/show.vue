<template>
  <div class="widget-body">
    <loading v-if="!loaded"/>
    <div class="row" v-else>
      <div class="col-md-3 d-flex">
        <vuestic-widget class="profile-card-widget">
          <vuestic-profile-card 
          	:name="`${user.name} ${user.family}`" 
          	:photoSource="avatar" 
          	:location="''" 
          	:social="''"
          >
          </vuestic-profile-card>

          <ul class="vue-unordered">
            <li>
              {{'user.active' | translate}} : 
              <span v-if="user.active">
                {{'user.active_y' | translate}}
              </span>
              <span v-else>
                {{'user.active_n' | translate}}
              </span>
            </li>

            <li>
              {{'user.gender' | translate}} :
              <span v-if="user.gender">
                {{'user.gender_m' | translate}}
              </span>
              <span v-else>
                {{'user.gender_f' | translate}}
              </span>
            </li>

            <li>
              {{'user.email' | translate}} : {{ user.email }}
            </li>

            <li>
              {{'user.mobile' | translate}} : {{ user.mobile }}
            </li>

            <li>
              {{'user.birthdate' | translate}} : {{ user.birthdate_persian }}
            </li>
          </ul>

          <ul class="vue-unordered">
            <li>
              {{'menu.roles.roles' | translate}} :

              <ul class="vue-list-inner">
                <li v-for="role in user.roles.data">
                  {{ role.name }}
                </li>
              </ul>
            </li>
          </ul>
        </vuestic-widget>
      </div>
      <div class="col-md-9 d-flex">
        <vuestic-widget>

          <div class="row show-buttons-area">
            <router-link
              :to="{ name: 'Admins' }"
              class="btn btn-info btn-micro"
            >
              {{'menu.admins.admins' | translate}}
            </router-link>
            <router-link 
              class="btn btn-primary btn-micro"
              :to="{ name: 'updateAdmin', params: { id: this.$route.params.id } }"
            >
              {{'buttons.update' | translate}}
            </router-link>
          </div>

          <div class="row">
            <div class="col vue-misc well" if="user.about" v-html="user.about"></div>
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
    name: 'Admin',
    components: {
    },
    data () {
      return {
        user: {},
        avatar: '',
        loaded: false
      }
    },
    created () {
      api.get(`admins/${this.$route.params.id}`).then(res => {
        this.user = res.data
        this.avatar = res.data.avatar_id ? res.data.avatar.data.path : ''

        this.loaded = true
      }).catch(error => {
        this.$store.dispatch('addToastMessage',
          { text: Vue.i18n.translate(`errors.${error.data.status_code}`) }
        )
        this.$router.push({ name: 'Admins' })
      })
    },
    computed: {
      mapOptions () {
        return {
          clickableIcons: false
        }
      }
    }
  }
</script>

<style lang="scss">
  
</style>
