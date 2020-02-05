<template>
  <div v-if="status.user === 'success' && userProfile">
    <header class="relative mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <UploadableImage
          imageWidth="1000"
          imageHeight="562"
          location="cover"
          classes="object-cover w-full"
          :alt="`${userProfile.data.attributes.name} Background Image`"
          :userImage="userProfile.data.attributes.cover_image"
        />
      </div>

      <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
        <div class="w-32">
          <UploadableImage
            imageWidth="750"
            imageHeight="750"
            location="profile"
            classes="w-32 h-32 object-cover border-4 border-gray-200 rounded-full shadow-lg"
            :alt="`${userProfile.data.attributes.name} Profile`"
            :userImage="userProfile.data.attributes.profile_image"
          />
        </div>
        <p class="text-2xl text-gray-100 ml-4" v-text="userProfile.data.attributes.name"></p>
      </div>

      <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
        <button
          v-if="friendButtonText && friendButtonText !== 'Accept'"
          class="py-1 px-3 bg-gray-400 rounded"
          @click="sendFriendRequest($route.params.userId)"
          v-text="friendButtonText"
        ></button>

        <button
          v-if="friendButtonText && friendButtonText === 'Accept'"
          class="mr-2 py-1 px-3 bg-blue-500 rounded text-white"
          @click="acceptFriendRequest($route.params.userId)"
          v-text="'Accept'"
        ></button>

        <button
          v-if="friendButtonText && friendButtonText === 'Accept'"
          class="mr-2 py-1 px-3 bg-gray-400 rounded"
          @click="ignoreFriendRequest($route.params.userId)"
          v-text="'Ignore'"
        ></button>
      </div>
    </header>

    <span v-if="newsStatus.postsStatus === 'loading'" class="mt-6">Loading Posts...</span>
    <main v-else class="flex flex-col items-center">
      <p
        v-if="newsStatus.postsStatus !== 'loading' && !posts.data.length"
        class="bg-white px-4 py-2 rounded"
      >
        No Posts Found.
        <a href="#" class="text-blue-500 hover:text-blue-600">Get Started...</a>
      </p>

      <Post
        v-else-if="newsStatus.postsStatus === 'success' && posts.data.length"
        v-for="(post,postKey) in posts.data"
        :post="post"
        :key="postKey"
      />
    </main>
  </div>
</template>

<script>
import Post from "../../components/Post"
import UploadableImage from '../../components/UploadableImage'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: "Show",

  components: {
    Post,
    UploadableImage
  },

  methods: {
    ...mapActions('Profile', [
      'fetchUser',
      'sendFriendRequest',
      'acceptFriendRequest',
      'ignoreFriendRequest'
    ]),

    ...mapActions('Posts', ['fetchUserPosts'])
  },

  computed: {
    ...mapGetters('Profile', [
      'userProfile',
      'friendButtonText',
      'status'
    ]),

    ...mapGetters('Posts', ['posts', 'newsStatus'])
  },

  mounted() {
    const userId = this.$route.params.userId
    this.fetchUser(userId);
    this.fetchUserPosts(userId)
  }
}
</script>