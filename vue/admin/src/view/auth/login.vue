<template>
  <div class="login" @keyup.enter="login">
    <h2>{{'auth.welcome' | translate}}</h2>

    <div :class="{'form-group': true, 'has-error': errors.has('email') }">
      <div class="input-group">
        <input type="text" name="email" v-model="email" v-validate="'required|email'"/>
        <label class="control-label" for="email">{{'auth.email' | translate}}</label><i class="bar"></i>
        <small class="help text-danger" v-show="errors.has('email')">{{errors.first('email')}}</small>
      </div>
    </div>
    <div :class="{'form-group': true, 'has-error': errors.has('password') }">
      <div class="input-group">
        <input type="password" name="password" v-model="password" v-validate="'required|min:6'"/>
        <label class="control-label" for="password">{{'auth.password' | translate}}</label><i class="bar"></i>
        <small class="help text-danger" v-show="errors.has('password')">{{errors.first('password')}}</small>
      </div>
    </div>
    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between down-container">
      <button class="btn btn-outline-primary" @click="login" v-if="!button_loading">
        {{'auth.login' | translate}}
      </button>
      <button class="btn btn-outline-primary" v-if="button_loading">
        <i class="fa fa-circle-o-notch fa-spin"></i> {{ $t('loading') }}
      </button>

      <router-link class='link' :to="{name: 'signup'}">{{'auth.createAccount' | translate}}</router-link>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'login',
    data () {
      return {
        email: '',
        password: ''
      }
    },
    computed: mapState({
      button_loading: state => state.auth.authenticating
    }),
    methods: {
      login () {
        this.$store.dispatch('HIDE_ERROR')

        this.$validator.validateAll().then((result) => {
          if (result) {
            this.$store.dispatch('login', {
              'email': this.email,
              'password': this.password
            }).then(() => {

              this.$router.replace({ name: 'dashboard' })
            }).catch(error => {   
              this.$store.dispatch(
                'addToastMessage', 
                { 
                  type: 'error',
                  text: error.status === 422 ? this.$t('errors.422') : error.data.message, 
                }
              )            
            })
          }
        })
      },
      hideError () {
        this.$store.dispatch('HIDE_ERROR')
      }
    }
  }
</script>

<style lang="scss">
  .login {
    @include media-breakpoint-down(md) {
      width: 100%;
      padding-right: 2rem;
      padding-left: 2rem;
      .down-container {
        .link {
          margin-top: 2rem;
        }
      }
    }

    h2 {
      text-align: center;
    }
    width: 21.375rem;

    .down-container {
      margin-top: 3.125rem;
    }
  }
</style>
