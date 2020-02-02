const SET_POSTS = 'posts/SET_POSTS'
const SET_POSTS_STATUS = 'posts/SET_POSTS_STATUS'
const UPDATE_MESSAGE = 'posts/UPDATE_MESSAGE'
const PUSH_POSTS = 'posts/PUSH_POSTS'
const PUSH_LIKES = 'posts/PUSH_LIKES'
const PUSH_COMMENTS = 'posts/PUSH_COMMENTS'

const state = {
  newsPosts: null,
  newsPostsStatus: null,
  postTextMessage: ''
}
const getters = {
  newsPosts(state) {
    return state.newsPosts
  },
  newsStatus(state) {
    return {
      postsStatus: state.newsPostsStatus
    }
  },
  postTextMessage(state) {
    return state.postTextMessage
  }
}

const mutations = {
  [SET_POSTS](state, posts) {
    state.newsPosts = posts
  },
  [SET_POSTS_STATUS](state, status) {
    state.newsPostsStatus = status
  },
  [UPDATE_MESSAGE](state, message) {
    state.postTextMessage = message
  },
  [PUSH_POSTS](state, post) {
    state.newsPosts.data.unshift(post)
  },
  [PUSH_LIKES](state, data) {
    const { likes, postKey } = data
    state.newsPosts.data[postKey].data.attributes.likes = likes
  },
  [PUSH_COMMENTS](state, data) {
    const { comments, postKey } = data
    state.newsPosts.data[postKey].data.attributes.comments = comments
  }
}

const actions = {
  async fetchNewsPosts({ commit }) {
    try {
      commit(SET_POSTS_STATUS, 'loading')

      const res = await axios.get('/api/posts')
      commit(SET_POSTS, res.data)

      commit(SET_POSTS_STATUS, 'success')
    } catch (err) {
      console.log('Unable to fetch posts')
      commit(SET_POSTS_STATUS, 'error')
    }
  },

  async postMessage({ commit, state }) {
    try {
      commit(SET_POSTS_STATUS, 'loading')

      const res = await axios.post('/api/posts', { body: state.postTextMessage })
      commit(PUSH_POSTS, res.data)
      commit(UPDATE_MESSAGE, '')

      commit(SET_POSTS_STATUS, 'success')
    } catch (err) {
    }
  },

  async likePost({ commit }, data) {
    try {
      const { postId, postKey } = data

      const res = await axios.post(`/api/posts/${postId}/like`)
      commit(PUSH_LIKES, { likes: res.data, postKey })
    } catch (err) {
    }
  },

  async commentPost({ commit }, data) {
    try {
      const { body, postId, postKey } = data

      const res = await axios.post(`/api/posts/${postId}/comment`, { body })
      commit(PUSH_COMMENTS, { comments: res.data, postKey })
    } catch (err) {
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