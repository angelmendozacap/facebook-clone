<template>
  <article class="bg-white rounded shadow w-2/3 mt-6 overflow-hidden">
    <div class="flex flex-col p-4">
      <div class="flex items-center">
        <div>
          <img
            :src="post.data.attributes.posted_by.data.attributes.profile_image.data.attributes.path"
            class="w-8 h-8 object-cover rounded-full"
            alt="Profile"
          />
        </div>
        <div class="ml-6">
          <h3 class="text-sm font-bold" v-text="post.data.attributes.posted_by.data.attributes.name"></h3>
          <div class="text-sm text-gray-600" v-text="post.data.attributes.posted_at"></div>
        </div>
      </div>
      <div class="mt-4">
        <p v-text="post.data.attributes.body"></p>
      </div>
    </div>

    <div class="w-full" v-if="post.data.attributes.image">
      <img
        :src="post.data.attributes.image"
        alt="post image"
        class="w-full"
      />
    </div>

    <div class="px-4 py-2 flex justify-between text-gray-700 text-sm">
      <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
          <path
            d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"
          />
        </svg>
        <p
          class="ml-1"
          v-text="postLikesCount"
        ></p>
      </div>

      <div>
        <p
          v-text="postCommentsCount"
        ></p>
      </div>
    </div>

    <div class="flex justify-between border-1 border-gray-400 p-4">
      <button
        @click="likePost({ postId: post.data.post_id, postKey: $vnode.key })"
        class="flex justify-center items-center py-2 rounded-lg text-sm w-full focus:outline-none"
        :class="[post.data.attributes.likes.user_likes_post ? 'bg-blue-500 text-white' : 'hover:bg-gray-200 text-gray-700']"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
          <path
            d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"
          />
        </svg>
        <span class="ml-2">Like</span>
      </button>
      <button
        @click="comments = !comments"
        class="flex justify-center items-center py-2 rounded-lg text-sm w-full focus:outline-none hover:bg-gray-200"
        :class="[comments ? 'text-blue-500': 'text-gray-700']"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
          <path
            d="M20.3 2H3.7C2 2 .6 3.4.6 5.2v10.1c0 1.7 1.4 3.1 3.1 3.1V23l6.6-4.6h9.9c1.7 0 3.1-1.4 3.1-3.1V5.2c.1-1.8-1.3-3.2-3-3.2zm1.8 13.3c0 1-.8 1.8-1.8 1.8H9.9L5 20.4V17H3.7c-1 0-1.8-.8-1.8-1.8v-10c0-1 .8-1.8 1.8-1.8h16.5c1 0 1.8.8 1.8 1.8v10.1zM6.7 6.7h10.6V8H6.7V6.7zm0 2.9h10.6v1.3H6.7V9.6zm0 2.8h10.6v1.3H6.7v-1.3z"
          />
        </svg>
        <span class="ml-2">Comment</span>
      </button>
    </div>

    <div v-if="comments" class="border-t border-gray-400 p-4 pt-2">
      <div class="flex">
        <input
          v-model="commentBody"
          type="text"
          name="comment"
          class="w-full pl-4 h-8 bg-gray-200 rounded-full focus:outline-none focus:shadow-outline"
          placeholder="Write Your Comment"
        >

        <transition name="bounce">
          <button
            v-if="commentBody"
            class="bg-blue-500 text-white ml-2 px-2 py-1 rounded-full focus:outline-none"
            @click="commentPost({ body: commentBody, postId: post.data.post_id, postKey: $vnode.key }); commentBody = ''"
          >Post</button>
        </transition>
      </div>

      <!-- COMMENTS -->
      <div
        v-for="(comment,commentKey) in post.data.attributes.comments.data"
        :key="commentKey"
        class="flex my-4 items-center"
      >
        <div class="w-8">
          <router-link
            :to="`/users/${comment.data.attributes.commented_by.data.user_id}`"
            class="cursor-pointer"
          >
            <img
              :src="comment.data.attributes.commented_by.data.attributes.profile_image.data.attributes.path"
              class="w-8 h-8 object-cover rounded-full"
              alt="Profile"
            />
          </router-link>
        </div>

        <div class="flex-1 ml-4">
          <div class="bg-gray-200 rounded-lg p-2 text-sm">
            <router-link
              :to="`/users/${comment.data.attributes.commented_by.data.user_id}`"
              class="cursor-pointer font-bold text-blue-700 hover:text-blue-500"
              v-text="comment.data.attributes.commented_by.data.attributes.name"
            ></router-link>

            <p
              class="inline"
              v-text="comment.data.attributes.body"
            ></p>
          </div>

          <div class="text-xs text-gray-700 pl-2">
            <p
              v-text="comment.data.attributes.commented_at"
            ></p>
          </div>
        </div>
      </div>
    </div>
  </article>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: "Post",
  props: [ 'post' ],

  data() {
    return {
      comments: false,
      commentBody: ''
    }
  },

  methods: {
    ...mapActions('Posts', ['likePost', 'commentPost'])
  },

  computed: {
    postLikesCount() {
      const likeCount = this.post.data.attributes.likes.like_count
      const likeCountText = `${likeCount} ${likeCount === 1 ? 'like' : 'likes'}`

      return likeCountText
    },
    postCommentsCount() {
      const commentCount = this.post.data.attributes.comments.comment_count
      const commentCountText = `${commentCount} ${commentCount === 1 ? 'comment' : 'comments'}`

      return commentCountText
    }
  }
};
</script>

<style scoped>
  .bounce-enter-active {
    animation: bounce-in .5s;
  }
  .bounce-leave-active {
    animation: bounce-in .5s reverse;
  }
  @keyframes bounce-in {
    0% {
      opacity: 0;
      transform: scale(0);
    }
    50% {
      transform: scale(1.2);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>