<template>
  <first-section></first-section>
</template>

<script>
import { mapGetters } from 'vuex'
import FirstSection from '../components/welcome/FirstSection'

export default {
  layout: 'basic',

  components: {
    FirstSection
  },

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
