// Polyfills
// import 'es6-promise/auto'
// import 'babel-polyfill'
import Vue from 'vue'

// import Vuemit from 'vuemit'
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import App from './App'
import store from './store'
import router from './router'
import VeeValidate from 'vee-validate'
import YmapPlugin from 'vue-yandex-maps'
import VueClipboard from 'vue-clipboard2'
import VueSweetalert2 from 'vue-sweetalert2'
import VuesticPlugin from 'vuestic-theme/vuestic-plugin'


import Vueditor from 'vueditor'

import 'vueditor/dist/style/vueditor.min.css'

// your config here
let config = {
  fontName: [
    {val: 'Samim'}
  ]
}

// import './packages/MediaManager/js/manager'

// window.EventHub = require('vuemit')
// window.keycode = require('keycode')
// window.Fuse = require('fuse.js')

import './i18n'

// Elegant
import { sync } from 'vuex-router-sync'

Vue.use(YmapPlugin)
Vue.use(VueClipboard)
Vue.use(VuesticPlugin)
Vue.use(VueSweetalert2)
Vue.use(Vueditor, config)

// NOTE: workaround for VeeValidate + vuetable-2
Vue.use(VeeValidate, { fieldsBagName: 'formFields' })

sync(store, router)

router.beforeEach((to, from, next) => {
  store.commit('setLoading', true)
  next()
})

router.afterEach((to, from) => {
  store.commit('setLoading', false)
})

router.beforeEach((to, from, next) => {
  if (
    store.getters.permissions.length && 
    !store.getters.permissions.includes(to.meta.per)
  ) {
    store.dispatch('addToastMessage', { text: Vue.i18n.translate('errors.403') })
    next({
      path: '/'
    })
  } else {
    if (to.matched.some(record => record.meta.userAuth)) {
      if (!store.getters.token) {
        next({
          path: '/auth/login'
        })
      } else {
        next()
      }
    } else if (to.matched.some(record => record.meta.userNotAuth)) {
      if (store.getters.token) {
        next({
          path: '/'
        })
      } else {
        next()
      }
    } else {
      next()
    }
  }
})

/* eslint-disable no-new */

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
