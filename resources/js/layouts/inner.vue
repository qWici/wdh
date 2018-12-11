<template>
  <div class="main-layout">
    <w-header />
    <main :class="{ 'nav-open': navOpened }">
      <div class="box">
        <w-sidebar />
        <div class="content left-sidebar">
          <w-breadcrumbs v-if="exceptedRoutes" />
          <child />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import WHeader from '~/components/WHeader'
import WSidebar from '~/components/WSidebar'
import WBreadcrumbs from '~/components/WBreadcrumbs'

export default {
  name: 'InnerLayout',

  components: {
    WHeader,
    WSidebar,
    WBreadcrumbs
  },

  computed: {
    exceptedRoutes () {
      const exceptedRoutes = ['home', 'stream', 'article', 'video', 'podcast']

      return exceptedRoutes.indexOf(this.$route.name) === -1
    },
    ...mapGetters({
      navOpened: 'global/navOpened'
    })
  }
}
</script>
