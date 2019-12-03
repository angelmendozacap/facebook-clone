<template>
  <div>
    <div class="w-100 h-64 overflow-hidden">
      <img src="http://lorempixel.com/960/720/nature/" alt="user background image" class="object-cover w-full">
    </div>
  </div>
</template>

<script>
export default {
  name: 'Show',

  data() {
    return {
      user: {},
      loading: true
    }
  },

  methods: {
    async getUser() {
      try {
        const res = await axios.get(`/api/users/${this.$route.params.userId}`)
        this.user = res.data
      } catch (err) {
        console.log('Uanble to fetch the user from the server')
      }

      this.loading = false
    }
  },

  mounted() {
    this.getUser()
  }
}
</script>