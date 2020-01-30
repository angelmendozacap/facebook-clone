<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden" v-if="authUser">
    <Nav />
    <div class="flex overflow-y-hidden flex-1">
      <Sidebar />

      <div class="overflow-x-hidden w-2/3">
        <router-view :key="$route.fullPath" />
      </div>
    </div>
  </div>
</template>

<script>

import { mapActions, mapGetters } from 'vuex'

import Nav from './Nav'
import Sidebar from './Sidebar'

export default {
  name: 'App',
  components: {
    Nav,
    Sidebar
  },
  methods: {
    ...mapActions('User', [
      'fetchAuthUser'
    ]),

    ...mapActions('Title', [
      'setPageTitle'
    ])
  },
  computed: {
    ...mapGetters('User', ['authUser'])
  },
  watch: {
    $route(to, from) {
      this.setPageTitle(to.meta.title)
    }
  },
  created() {
    this.setPageTitle(this.$route.meta.title)
  },
  mounted() {
    this.fetchAuthUser()
  }
}
</script>