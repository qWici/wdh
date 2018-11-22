<template>
  <div v-click-outside="hide" :class="'locales ' + position">
    <a href="#" class="current-locale" @click.prevent="showLocales">
      <lang-flag :iso="locale" :squared="false" class="flag" />
      {{ locales[locale] }}
    </a>
    <ul v-show="show">
      <li v-for="(value, key) in locales" :key="key">
        <a v-if="value !== locales[locale]" href="#" @click.prevent="setLocale(key)">
          <lang-flag :iso="key" :squared="false" class="flag" />
          {{ value }}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'
import ClickOutside from 'vue-click-outside'

export default {
  directives: {
    ClickOutside
  },

  props: {
    position: {
      type: String,
      default: 'bottom',
      validator: value => {
        return ['top', 'bottom'].indexOf(value) !== -1
      }
    }
  },

  data: () => ({
    show: false
  }),

  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales'
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
      this.show = false
    }
  }
}
</script>

<style scoped lang="scss">
.locales {
  position: relative;
  z-index: 1;
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
  &.top {
    margin-left: 20px;
    ul {
      top: 25px;
    }
  }
  ul {
    position: absolute;
    top: -90px;
    display: flex;
    flex-direction: column;
    margin: 0;
    width: 80px;
    background-color: #3c376b;
    padding: 10px;
    right: 0;
    li {
      margin: 0 0 10px;
      text-align: right;
      &:last-child {
        margin-bottom: 0;
      }
      a {
        display: flex;
        span {
          margin-right: 10px;
        }
      }
    }
  }
}
</style>
