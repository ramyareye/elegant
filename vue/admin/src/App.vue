<template>
  <div id="app" :class="setAppClass()">
    <router-view/>
  </div>
</template>

<script>
  import { mapState, mapGetters } from 'vuex'  

  export default {
    name: 'app',
    mounted () {
      this.$store.dispatch('checkLogin')
    },
    methods: {
      setAppClass () {
        return this.$i18n.locale() === 'fa' ? 'app rtl' : 'app'         
      }
    },
    computed: {
      ...mapState({
        authenticated: state => state.auth.authenticated
      }),
      ...mapGetters([
        'routes',
        'isLoading',
        'toastMessages'
      ])
    },
    watch: {
      toastMessages (v) {
        const l = v.length

        if (l && v[l - 1].show) {
          this.showToast(v[v.length - 1].text, {
            theme: 'bubble',
            position: 'bottom-center',
            className: 'vuestic-toast',
            iconPack: 'fontawesome',
            duration: 2500,
            type: v[v.length - 1].type || 'success'
          })

          this.$store.dispatch('changeShowToastMessage', v[l - 1].id)
        }
      },
      routes (routes) {
        routes.length && this.$router.push({ name: routes[0] })
      }
    }
  }
</script>

<style lang="scss">
  @import "sass/main";

  body {
    height: 100%;
    #app {
      height: 100%;
    }
  }
</style>
