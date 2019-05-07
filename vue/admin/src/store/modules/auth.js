import Vue from 'vue'
import api from 'src/packages/Api'

const state = {
  me: {}, // Logged in user  
  permissions: [],
  authenticated: false,
  authenticating: false,
  token: localStorage.getItem('token')
}

const actions = {

  async checkLogin ({commit, dispatch}) {
    const accessToken = this.getters.token

    if (!accessToken) {
      commit('LOGOUT_SUCCESS')

      commit('ADD_ROUTE_TO_ROUTER', 'login')
    } else {
      await api.get('me').then(response => {
        commit('CHECK_LOGIN_SUCCESS', response.data)
      }).catch(error => {
        // it may cause problem!

        commit('LOGOUT_SUCCESS')
        commit('ADD_ROUTE_TO_ROUTER', 'login')
      })
    }
  },


  async login ({commit, dispatch}, data) {
    commit('SET_VALIDATE_ERROR', false)
    commit('BUTTON_LOAD')

    await api.post('login', data).then(response => {
      commit('LOGIN_SUCCESS', response)      

      return Promise.resolve()
    }).catch(error => {
      commit('BUTTON_CLEAR')

      return Promise.reject(error)
    })
  },

  logout ({commit, dispatch}) {
    api.post('logout')

    commit('LOGOUT_SUCCESS')
  },

  // register ({commit, dispatch}, form) {
  //   commit('REGISTER')
  // },

  // updateProfile ({commit, dispatch}, {id, form}) {
  //   commit('UPDATE_PROFILE')
  // },

  HIDE_ERROR ({commit}) {
    commit('SET_VALIDATE_ERROR', false)
  }

}

const mutations = {

  CHECK_LOGIN_SUCCESS (state, user) {
    let permissions = []
    
    user.roles.data.map(role => {
      role.permissions.data.map(per => {
        permissions.push(per.name)
      })
    })

    state.me = user
    state.authenticated = true
    state.permissions = permissions
  },

  LOGIN_SUCCESS (state, {user, token}) {
    let permissions = []
    
    user.roles.map(role => {
      role.permissions.map(per => {
        permissions.push(per.name)
      })
    })

    state.me = user
    state.token = token
    state.authenticated = true
    state.authenticating = false
    state.permissions = permissions
    localStorage.setItem('token', token)
  },

  LOGOUT_SUCCESS (state) {
    state.me = null
    state.token = null
    state.permissions = []    
    state.authenticated = false
    localStorage.removeItem('token')
  },

  // REGISTER_SUCCESS (state, user) {
  //   let permissions = []
  //   user.roles.data.map(role => {
  //     role.permissions.data.map(per => {
  //       permissions.push(per.name)
  //     })
  //   })

  //   state.me = user
  //   state.authenticated = true
  //   state.permissions = permissions
  // },

  // UPDATE_PROFILE_SUCCESS (state, user) {
  //   state.me = user
  // },

  SET_VALIDATE_ERROR (state, error) {
    state.error = error
  },

  SET_ERROR (state, error) {
    state.errors = error.errors
  },

  BUTTON_LOAD (state) {
    state.authenticating = true
  },

  BUTTON_CLEAR (state) {
    state.authenticating = false
  }

}

export default {
  state,
  actions,
  mutations
}
