<template>
  <img
    ref="userImage"
    src="https://images.unsplash.com/photo-1571217668979-f46db8864f75?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80"
    alt="user background image"
    class="object-cover w-full"
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
    }
  },

  data() {
    return {
      dropzone: null
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
          console.log(res)
          alert('Uploaded!')
        }
      }
    }
  },

  mounted() {
    this.dropzone = new Dropzone(this.$refs.userImage, this.settings)
  }
}
</script>

<style>

</style>