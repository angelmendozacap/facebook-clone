<template>
  <div class="bg-white rounded shadow w-2/3 p-4">
    <div class="flex justify-between items-center">
      <div>
        <div class="w-8">
          <img
            :src="authUser.data.attributes.profile_image.data.attributes.path"
            class="w-8 h-8 object-cover rounded-full"
            alt="Profile"
          />
        </div>
      </div>
      <div class="flex-1 flex mx-4">
        <input
          v-model="textMessage"
          type="text"
          name="body"
          class="w-full pl-4 h-8 bg-gray-200 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline text-sm"
          placeholder="Add a Post"
        />

        <transition name="bounce">
          <button
            v-if="textMessage"
            @click="postHandler"
            class="bg-blue-500 text-white ml-2 px-3 py-1 rounded-full focus:outline-none"
          >Post</button>
        </transition>
      </div>
      <div>
        <button ref="postImage" class="dz-clickable flex justify-center items-center rounded-full w-10 h-10 bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="dz-clickable fill-current w-5 h-5">
            <path
              d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"
            />
          </svg>
        </button>
      </div>
    </div>

    <div class="dropzone-previews">
      <div id="dz-template" class="hidden">
        <div class="dz-preview dz-file-preview mt-4">
          <div class="dz-details">
            <img data-dz-thumbnail class="w-32 h-32">

            <button data-dz-remove class="text-xs">REMOVE</button>
          </div>

          <div class="dz-progress"><span class="dz-upload" data-dz-upload></span></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import _ from 'lodash'
import Dropzone from 'dropzone'

export default {
  name: "NewPost",

  data() {
    return {
      dropzone: null
    }
  },

  methods: {
    ...mapActions('Posts', ['postMessage']),

    postHandler() {
      if (this.dropzone.getAcceptedFiles().length) {
        this.dropzone.processQueue()
      } else {
        this.postMessage()
      }

      this.$store.commit('Posts/posts/UPDATE_MESSAGE', '')
    }
  },

  computed: {
    ...mapGetters('Posts', ['postTextMessage']),
    ...mapGetters('User', ['authUser']),

    textMessage: {
      get() {
        return this.postTextMessage
      },
      set: _.debounce(function (text) {
        this.$store.commit('Posts/posts/UPDATE_MESSAGE', text)
      }, 300)
    },

    settings() {
      return {
        paramName: 'image',
        url: '/api/posts',
        acceptedFiles: 'image/*',
        clickable: '.dz-clickable',
        autoProcessQueue: false,
        previewsContainer: '.dropzone-previews',
        previewTemplate: document.getElementById('dz-template').innerHTML,
        params: {
          width: 1000,
          height: 1000,
        },
        sending: (file, xhr, formData) => {
          formData.append('body', this.postTextMessage)
        },
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
        },
        success: (e, res) => {
          this.dropzone.removeAllFiles()

          this.$store.commit('Posts/posts/PUSH_POSTS', res)
        }
      }
    }
  },

  mounted() {
    this.dropzone = new Dropzone(this.$refs.postImage, this.settings)
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