<template>
  <img
    ref="userImage"
    :src="imageObject.data.attributes.path"
    :alt="alt"
    :class="classes"
  />
</template>

<script>
import Dropzone from 'dropzone'

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
      dropzone: null,
      uploadedImage: null
    }
  },

  computed: {
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
          this.uploadedImage = res
        }
      }
    },

    imageObject() {
      return this.uploadedImage || this.userImage
    }
  },

  mounted() {
    this.dropzone = new Dropzone(this.$refs.userImage, this.settings)
  }
}
</script>

<style>

</style>