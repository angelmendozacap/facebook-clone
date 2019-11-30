<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
    <Nav />
    <router-view />
  </div>
</template>

<script>
import Nav from './Nav'
export default {
  name: 'App',
  components: {
    Nav
  }
}
</script>