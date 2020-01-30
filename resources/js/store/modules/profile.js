const SET_USER = 'profile/SET_USER'
const SET_USER_STATUS = 'profile/SET_USER_STATUS'

const state = {
  user: null,
  userStatus: null,
}
const getters = {
  userProfile(state) {
    return state.user
  }
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  },
  [SET_USER_STATUS](state, status) {
    state.userStatus = status
  }
}

const actions = {
  async fetchUser({ commit }, userId) {
    try {
      commit(SET_USER_STATUS, 'loading')

      const res = await axios.get(`/api/users/${userId}`);
      commit(SET_USER, res.data)

      commit(SET_USER_STATUS, 'success')
    } catch (err) {
      console.log("Unable to fetch the user from the server");
      commit(SET_USER_STATUS, 'error')
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}