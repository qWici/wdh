<template>
  <div id="welcome">
    {{ redirectUserToHome() }}
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
  }),

  methods: {
    redirectUserToHome () {
      if (this.authenticated) {
        this.$router.push({ name: 'home' })
      }
    }
  }
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
