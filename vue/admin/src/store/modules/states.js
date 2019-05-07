import api from 'src/packages/Api'

const state = {
  states: []
}

const actions = {

  async getStates ({commit, dispatch}) {
    api.get('states').then(response => {
      commit('ALL_STATES_OK', response.data)
    }).catch(error => {
      commit('ALL_STATES_FAIL', error.response)
    })
  }

}

const mutations = {

  ALL_STATES_OK (state, data) {
    state.states = data
  },

  ALL_STATES_FAIL (state, error) {
    state.states = []
  }
}

export default {
  state,
  actions,
  mutations
}
