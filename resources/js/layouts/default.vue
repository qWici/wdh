<template>
  <div class="main-layout">
    <WHeader />
    <main :class="{ 'nav-open': navOpened }">
      <div class="box">
        <Child />
      </div>
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
