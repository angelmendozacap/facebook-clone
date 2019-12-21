<template>
  <div class="flex flex-col items-center py-4">
    <NewPost />
    <span v-if="loading" class="mt-6">Loading...</span>
    <Post v-else v-for="post in posts.data" :post="post" :key="post.data.post_id" />
  </div>
</template>

<script>

import NewPost from '../components/NewPost'
import Post from '../components/Post'

export default {
  name: 'NewsFeed',
  components: {
    NewPost,
    Post
  },

  data() {
    return {
      posts: [],
      loading: true
    }
  },

  methods: {
    async getPosts() {
      try {
        const res = await axios.get('/api/posts')
        this.posts = res.data
        this.loading = false
      } catch (e) {
        console.log('Unable to fetch posts')
      }
    }
  },

  mounted() {
    this.getPosts()
  }
}
</script>