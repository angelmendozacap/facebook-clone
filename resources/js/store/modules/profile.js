const SET_USER = 'profile/SET_USER'
const SET_USER_STATUS = 'profile/SET_USER_STATUS'
const SET_USER_FRIENDSHIP = 'profile/SET_USER_FRIENDSHIP'

const state = {
  user: null,
  userStatus: null,
}
const getters = {
  userProfile(state) {
    return state.user
  },
  friendship(state) {
    return state.user.data.attributes.friendship
  },
  friendButtonText(state, getters, rootState) {
    if (!getters.friendship) {
      return 'Add Friend'
    } else if (!getters.friendship.data.attributes.confirmed_at) {
      return 'Pending Friend Request'
    }

  }
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  },
  [SET_USER_FRIENDSHIP](state, friendship) {
    state.user.data.attributes.friendship = friendship
  },
  [SET_USER_STATUS](state, status) {
    state.userStatus = status
  },
}

const actions = {
  async fetchUser({ commit, dispatch }, userId) {
    try {
      commit(SET_USER_STATUS, 'loading')

      const res = await axios.get(`/api/users/${userId}`);
      commit(SET_USER, res.data)

      commit(SET_USER_STATUS, 'success')
    } catch (err) {
      console.log("Unable to fetch the user from the server");
      commit(SET_USER_STATUS, 'error')
    }
  },
  async sendFriendRequest({ commit }, friendId) {
    try {
      const res = await axios.post('/api/friend-request', { friend_id: friendId })
      commit(SET_USER_FRIENDSHIP, res.data)
    } catch (err) {
    }
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}