<template>
  <div>
    <span v-if="userLoading" class="mt-6">Loading Profile...</span>
    <header v-else class="relative mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <img
          src="http://lorempixel.com/960/720/nature/"
          alt="user background image"
          class="object-cover w-full"
        />
      </div>

      <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
        <div class="w-32">
          <img
            src="https://picsum.photos/300/300"
            class="w-32 h-32 object-cover border-4 border-gray-200 rounded-full shadow-lg"
            alt="Profile"
          />
        </div>
        <p class="text-2xl text-gray-100 ml-4" v-text="user.data.attributes.name"></p>
      </div>
    </header>

    <span v-if="postLoading" class="mt-6">Loading Posts...</span>
    <main v-else class="flex flex-col items-center">
      <p v-if="!postLoading && !posts.data.length" class="bg-white px-4 py-2 rounded">
        No Posts Found.
        <a href="#" class="text-blue-500 hover:text-blue-600">Get Started...</a>
      </p>

      <Post v-for="post in posts.data" :post="post" :key="post.data.post_id" />
    </main>
  </div>
</template>

<script>
import Post from "../../components/Post"

export default {
  name: "Show",

  components: {
    Post
  },

  data() {
    return {
      user: {},
      posts: [],
      userLoading: true,
      postLoading: true
    };
  },

  methods: {
    async getUser() {
      try {
        const res = await axios.get(`/api/users/${this.$route.params.userId}`);
        this.user = res.data;
      } catch (err) {
        console.log("Unable to fetch the user from the server");
      }

      this.userLoading = false;
    },
    async getPosts() {
      try {
        const res = await axios.get(
          `/api/users/${this.$route.params.userId}/posts`
        );
        this.posts = res.data;
      } catch (err) {
        console.log("Unable to fetch posts");
      }

      this.postLoading = false;
    }
  },

  mounted() {
    this.getUser();
    this.getPosts();
  }
}
</script>