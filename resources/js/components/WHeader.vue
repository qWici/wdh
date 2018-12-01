<template>
  <header :class="{ 'nav-open': navOpened }">
    <div class="box">
      <fa v-if="isMobile" :icon="navOpened ? 'window-close' : 'bars'" fixed-width @click="toggleNav" />

      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="logo">
        <img src="/img/logo.png" alt="WebDevHub Logo">
      </router-link>

      <w-search v-if="!isMobile && user" />

      <router-link v-if="isMobile && !user" :to="{ name: 'login' }" active-class="active">
        <fa icon="sign-out-alt" fixed-width />
      </router-link>

      <a v-if="isMobile && user" href="#" @click.prevent="logout">
        <fa icon="sign-out-alt" fixed-width />
      </a>

      <nav v-if="user">
        <w-sidebar-mobile v-if="isMobile" />

        <ul v-if="!isMobile">
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

        <locale-dropdown v-if="isMobile" position="top" />
      </nav>

      <nav v-else>
        <ul>
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
        <locale-dropdown position="top" />
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
    iconClass: 'bars'
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
      this.$router.push({ name: 'login' })
    },
    toggleNav () {
      this.$store.dispatch('global/toggleNav')
    }
  }
}
</script>

<style scoped>
  .profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
  }
</style>
