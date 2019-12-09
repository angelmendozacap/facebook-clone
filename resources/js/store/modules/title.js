const state = {
  title: 'Welcome'
}

const getters = {
  pageTitle(state) {
    return state.title
  }
}

const mutations = {
  SET_TITLE(state, title) {
    state.title = `${title} | Facebook`

    document.title = state.title
  }
}

const actions = {
  setPageTitle({ commit }, title) {
    commit('SET_TITLE', title)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}