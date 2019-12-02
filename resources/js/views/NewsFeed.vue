<template>
  <div class="flex flex-col items-center py-4">
    <NewPost />
    <Post v-for="post in posts.data" :post="post" :key="post.data.post_id" />
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
    }
  },

  methods: {
    async getPosts() {
      try {
        const res = await axios.get('/api/posts')
        this.posts = res.data
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