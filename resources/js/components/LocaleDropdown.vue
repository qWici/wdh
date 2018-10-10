<template>
  <div class="locales">
    <a href="#" class="current-locale" @click.prevent="showLocales">{{ locales[locale] }}</a>
    <ul v-show="show">
      <li v-for="(value, key) in locales" :key="key">
        <a href="#" @click.prevent="setLocale(key)">{{ value }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  data: () => ({
    show: true,
  }),

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    },
    showLocales () {
      this.show = !this.show
    }
  }
}
</script>

<style scoped>
.locales a {
  font-weight: bold;
  color: #FFF;
}
</style>
