<template>
  <div id="welcome">
    <first-section/>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import FirstSection from '../components/welcome/FirstSection'

export default {
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

<style scoped lang="scss">
#welcome {
  width: 100%;
}
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
