<template>
  <img
    ref="userImage"
    :src="userImage.data.attributes.path"
    :alt="alt"
    :class="classes"
  />
</template>

<script>
import Dropzone from 'dropzone'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'UploadableImage',

  props: {
    imageWidth: {
      type: String,
      required: true
    },
    imageHeight: {
      type: String,
      required: true
    },
    location: {
      type: String,
      required: true
    },
    userImage: {
      type: Object,
      required: false
    },
    classes: {
      type: String,
      required: true
    },
    alt: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      dropzone: null
    }
  },

  methods: {
    ...mapActions('User', ['fetchAuthUser']),
    ...mapActions('Posts', ['fetchUserPosts']),
    ...mapActions('Profile', ['fetchUser'])
  },

  computed: {
    ...mapGetters('User', ['authUser']),

    settings() {
      return {
        paramName: 'image',
        url: '/api/user-images',
        acceptedFiles: 'image/*',
        params: {
          width: this.imageWidth,
          height: this.imageHeight,
          location: this.location
        },
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
        },
        success: (e, res) => {
          this.fetchAuthUser()
          this.fetchUser(this.$route.params.userId)
          this.fetchUserPosts(this.$route.params.userId)
        }
      }
    }
  },

  mounted() {
    if (this.authUser.data.user_id.toString() === this.$route.params.userId) {
      this.dropzone = new Dropzone(this.$refs.userImage, this.settings)
    }
  }
}
</script>

<style>

</style>