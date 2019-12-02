<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
    <Nav />
    <div class="flex overflow-y-hidden flex-1">
      <Sidebar />

      <div class="overflow-x-hidden w-2/3">
        <router-view />
        <p v-for="i in 100" :key="i">Gaaaa</p>
      </div>
    </div>
  </div>
</template>

<script>

import Nav from './Nav'
import Sidebar from './Sidebar'

export default {
  name: 'App',
  components: {
    Nav,
    Sidebar
  }
}
</script>