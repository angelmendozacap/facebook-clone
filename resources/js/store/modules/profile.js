const SET_USER = 'profile/SET_USER'
const SET_USER_STATUS = 'profile/SET_USER_STATUS'
const SET_BUTTON_TEXT = 'profile/SET_BUTTON_TEXT'

const state = {
  user: null,
  userStatus: null,
  friendButtonText: null
}
const getters = {
  userProfile(state) {
    return state.user
  },
  friendship(state) {
    return state.user.data.attributes.friendship
  },
  friendButtonText(state) {
    return state.friendButtonText
  }
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  },
  [SET_USER_STATUS](state, status) {
    state.userStatus = status
  },
  [SET_BUTTON_TEXT](state, text) {
    state.friendButtonText = text
  }
}

const actions = {
  async fetchUser({ commit, dispatch }, userId) {
    try {
      commit(SET_USER_STATUS, 'loading')

      const res = await axios.get(`/api/users/${userId}`);
      commit(SET_USER, res.data)

      commit(SET_USER_STATUS, 'success')
      dispatch('setFriendButton')
    } catch (err) {
      console.log("Unable to fetch the user from the server");
      commit(SET_USER_STATUS, 'error')
    }
  },
  async sendFriendRequest({ commit }, friendId) {
    commit(SET_BUTTON_TEXT, 'Loading...')
    try {
      const res = await axios.post('/api/friend-request', { friend_id: friendId })
      commit(SET_BUTTON_TEXT, 'Pending Friend Request')
    } catch (err) {
      commit(SET_BUTTON_TEXT, 'Add Friend')
    }
  },
  setFriendButton({ commit, getters }) {
    if (!getters.friendship) {
      commit(SET_BUTTON_TEXT, 'Add Friend')
    } else if (!getters.friendship.data.attributes.confirmed_at) {
      commit(SET_BUTTON_TEXT, 'Pending Friend Request')
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