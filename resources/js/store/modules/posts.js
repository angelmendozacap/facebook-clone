const SET_POSTS = 'posts/SET_POSTS'
const SET_POSTS_STATUS = 'posts/SET_POSTS_STATUS'

const state = {
  newsPosts: null,
  newsPostsStatus: null,
}
const getters = {
  newsPosts(state) {
    return state.newsPosts
  },
  newsStatus(state) {
    return {
      postsStatus: state.newsPostsStatus
    }
  }
}

const mutations = {
  [SET_POSTS](state, posts) {
    state.newsPosts = posts
  },
  [SET_POSTS_STATUS](state, status) {
    state.newsPostsStatus = status
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
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}