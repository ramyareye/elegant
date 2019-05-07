import Vue from 'vue'
import Vuex from 'vuex'
import VuexI18n from 'vuex-i18n' // load vuex i18n module

import app from './modules/app'
import auth from './modules/auth'
import toast from './modules/toast'
import router from './modules/router'
import routes from './modules/routes'
import states from './modules/states'

import * as getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: true, // process.env.NODE_ENV !== 'production',
  getters,
  modules: {
    app,
    auth,
    toast,
    router,
    routes,
    states
  },
  state: {},
  mutations: {}
})

Vue.use(VuexI18n.plugin, store)

export default store
