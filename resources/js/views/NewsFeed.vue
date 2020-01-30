<template>
  <div class="flex flex-col items-center py-4">
    <NewPost />

    <span
      v-if="newsStatus.postsStatus === 'loading'"
      class="mt-6"
    >Loading...</span>

    <Post
      v-else-if="newsStatus.postsStatus === 'success' && newsPosts.data.length"
      v-for="post in newsPosts.data"
      :post="post"
      :key="post.data.post_id"
    />
  </div>
</template>

<script>

import NewPost from '../components/NewPost'
import Post from '../components/Post'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'NewsFeed',
  components: {
    NewPost,
    Post
  },

  methods: {
    ...mapActions('Posts', ['fetchNewsPosts'])
  },

  computed: {
    ...mapGetters('Posts', ['newsPosts', 'newsStatus'])
  },

  mounted() {
    this.fetchNewsPosts()
  }
}
</script>