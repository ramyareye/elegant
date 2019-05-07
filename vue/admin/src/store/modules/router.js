const state = {
  router: []
}

const getters = {
  routes: (state) => state.router
}

const actions = {
  changeRoute ({commit}, { to }) {
    commit('ADD_ROUTE_TO_ROUTER', to)

    setTimeout(() => commit('RESET_ROUTER'), 500)
  }
}

const mutations = {
  ADD_ROUTE_TO_ROUTER (state, newRoute) {
    state.router.push(newRoute)
  },

  RESET_ROUTER (state) {
    state.router = []
  }
}

export default {
  state,
  actions,
  getters,
  mutations
}
