<template>
  <div class="main-layout">
    <WHeader />
    <main :class="{ 'nav-open': navOpened }">
      <div class="box">
        <WSidebar />
        <div class="content left-sidebar">
          <WBreadcrumbs />
          <Child />
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

  computed: mapGetters({
    navOpened: 'global/navOpened'
  })
}
</script>
