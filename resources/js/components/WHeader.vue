<template>
  <header :class="{ 'nav-open': navOpened }">
    <div class="box">
      <fa v-if="isMobile" :icon="navOpened ? 'window-close' : 'bars'" fixed-width @click="toggleNav" />

      <router-link :to="{ name: 'home' }" class="logo">
        <img src="/img/logo.png" alt="WebDevHub Logo">
      </router-link>

      <w-search @close="onCloseSearch" :class="{ 'mobile' : isMobile, 'visible' : searchVisible }" />

      <router-link v-if="isMobile && !user" :to="{ name: 'login' }" active-class="active">
        <fa icon="sign-out-alt" fixed-width />
      </router-link>

      <fa v-if="isMobile && user" icon="search" fixed-width @click="showSearch" />

      <nav>
        <w-sidebar-mobile v-if="isMobile" />

        <ul v-if="!isMobile && user !== null">
          <li>
            <router-link :to="{ name: 'settings.profile' }">
              <fa icon="cog" fixed-width />
              {{ $t('settings') }}
            </router-link>
          </li>
          <li>
            <a href="#" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              {{ $t('logout') }}
            </a>
          </li>
        </ul>

        <ul v-else-if="!isMobile">
          <li>
            <router-link :to="{ name: 'login' }" active-class="active">
              {{ $t('login') }}
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'register' }" active-class="active">
              {{ $t('register') }}
            </router-link>
          </li>
        </ul>

        <locale-dropdown v-if="isMobile" position="top" />
      </nav>
    </div>
  </header>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import WSidebarMobile from './WSidebarMobile'
import WSearch from './WSearch'

export default {
  components: {
    LocaleDropdown,
    WSidebarMobile,
    WSearch
  },
  data: () => ({
    iconClass: 'bars',
    searchVisible: false
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      userPhoto: 'auth/userPhoto',
      navOpened: 'global/navOpened',
      isMobile: 'global/isMobile'
    })
  },

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'home' })
    },
    toggleNav () {
      this.$store.dispatch('global/toggleNav')
    },
    showSearch () {
      this.searchVisible = true
    },
    onCloseSearch () {
      this.searchVisible = false
    }
  }
}
</script>

<style scoped lang="scss">
  .profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
  }
  .patron {
    img {
      height: 30px;
    }
  }
</style>
