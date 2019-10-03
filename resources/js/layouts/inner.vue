<template>
  <div class="main-layout">
    <w-header />
    <w-sidebar />
    <main :class="{ 'nav-open': navOpened }">
      <div class="content">
        <w-breadcrumbs v-if="exceptedRoutes" />
        <child />
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
      const exceptedRoutes = [
        'home', 'stream', 'article', 'video', 'podcast', 'bookmarks', 'authors', 'shows', 'channels',
        'suggest', 'suggest.type'
      ]

      return exceptedRoutes.indexOf(this.$route.name) === -1
    },
    ...mapGetters({
      navOpened: 'global/navOpened'
    })
  }
}
</script>

<style scoped>
  main {
    margin-top: 80px;
    margin-left: 300px;
    display: flex;
    flex-direction: column;
  }
  @media only screen and (max-width: 991px) {
    main {
      margin-left: 0;
    }
  }
</style>
