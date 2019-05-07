let maxToastId = 0

const state = {
  messages: []
}

const getters = {
  toastMessages: (state) => state.messages.filter(t => t.show)
}

const actions = {
  addToastMessage ({commit}, {text, type = 'success', dismissAfter = 5000}) {
    const id = ++maxToastId

    commit('ADD_TOAST_MESSAGE', {
      id,
      text,
      type,
      dismissAfter,
      show: true
    })
    setTimeout(() => commit('REMOVE_TOAST_MESSAGE', id), dismissAfter)
  },

  removeToastMessage ({commit}, id) {
    commit('REMOVE_TOAST_MESSAGE', id)
  },

  changeShowToastMessage ({commit}, id) {
    commit('CHANGE_SHOW_TOAST_MESSAGE', id)
  }
}

const mutations = {
  ADD_TOAST_MESSAGE (state, data) {
    state.messages.push(data)
  },

  REMOVE_TOAST_MESSAGE (state, id) {
    state.messages = state.messages.filter(m => m.id !== id)
  },

  CHANGE_SHOW_TOAST_MESSAGE (state, id) {
    state.messages = state.messages.map(m => {
      if (m.id === id) {
        m.show = false
      }
      return m
    })
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
