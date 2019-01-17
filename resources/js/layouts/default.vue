<template>
  <div class="main-layout">
    <w-header />
    <main :class="{ 'nav-open': navOpened }">
      <child />
    </main>
  </div>
</template>

<script>
import WHeader from '~/components/WHeader'
import { mapGetters } from 'vuex'

export default {
  name: 'MainLayout',

  components: {
    WHeader
  },

  computed: mapGetters({
    navOpened: 'global/navOpened'
  })
}
</script>

<style scoped>
  main {
    overflow-y: hidden;
    margin-top: 80px;
  }
</style>
