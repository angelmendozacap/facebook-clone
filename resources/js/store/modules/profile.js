const SET_USER = 'profile/SET_USER'
const SET_USER_STATUS = 'profile/SET_USER_STATUS'
const SET_USER_FRIENDSHIP = 'profile/SET_USER_FRIENDSHIP'

const state = {
  user: null,
  userStatus: null
}
const getters = {
  userProfile(state) {
    return state.user
  },
  status(state) {
    return {
      user: state.userStatus,
      posts: state.postsStatus
    }
  },
  friendship(state) {
    return state.user.data.attributes.friendship
  },
  friendButtonText(state, getters, rootState) {
    if (rootState.User.user.data.user_id === state.user.data.user_id) {
      return ''

    } else if (!getters.friendship) {
      return 'Add Friend'

    } else if (!getters.friendship.data.attributes.confirmed_at
      && getters.friendship.data.attributes.friend_id !== rootState.User.user.data.user_id
    ) {
      return 'Pending Friend Request'
    } else if (getters.friendship.data.attributes.confirmed_at) {
      return ''
    }

    return 'Accept'
  }
}

const mutations = {
  [SET_USER](state, user) {
    state.user = user
  },
  [SET_USER_STATUS](state, status) {
    state.userStatus = status
  },
  [SET_USER_FRIENDSHIP](state, friendship) {
    state.user.data.attributes.friendship = friendship
  },
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
  },
  async sendFriendRequest({ commit, getters }, friendId) {
    if (getters.friendButtonText !== 'Add Friend') return

    try {
      const res = await axios.post('/api/friend-request', { friend_id: friendId })
      commit(SET_USER_FRIENDSHIP, res.data)
    } catch (err) {
    }
  },
  async acceptFriendRequest({ commit }, userId) {
    try {
      const res = await axios.post('/api/friend-request-response', { user_id: userId, status: 1 })
      commit(SET_USER_FRIENDSHIP, res.data)
    } catch (err) {
    }
  },
  async ignoreFriendRequest({ commit }, userId) {
    try {
      await axios.delete('/api/friend-request-response/delete', { data: { user_id: userId } })
      commit(SET_USER_FRIENDSHIP, null)
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