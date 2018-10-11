<template>
  <div class="locales" v-click-outside="hide">
    <a href="#" class="current-locale" @click.prevent="showLocales">{{ locales[locale] }}</a>
    <ul v-show="show">
      <li v-for="(value, key) in locales" :key="key" v-if="value !== locales[locale]">
        <a href="#" @click.prevent="setLocale(key)">{{ value }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'
import ClickOutside from 'vue-click-outside'

export default {
  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  data: () => ({
    show: false,
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
    },
    hide () {
      this.show = false;
    }
  },
  directives: {
    ClickOutside
  }
}
</script>

<style scoped lang="scss">
.locales {
  position: relative;
  a {
    font-weight: bold;
    color: #FFF;
    &.current-locale {
      display: block;
      position: relative;
      padding-right: 20px;
      &:after {
        content: '';
        position: absolute;
        top: 50%;
        right: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #b1aeae;
        transform: translateY(-50%);
      }
    }
  }
  ul {
    position: absolute;
    top: 25px;
    display: flex;
    flex-direction: column;
    margin: 0;
    width: 70px;
    background-color: #3c376b;
    padding: 10px;
    right: 0;
    li {
      margin: 0 0 10px;
      text-align: right;
      &:last-child {
        margin-bottom: 0;
      }
    }
  }
}
</style>
