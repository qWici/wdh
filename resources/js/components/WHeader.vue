<template>
  <header :class="{ 'nav-open': navOpened }">
    <div class="box">
      <Fa v-if="isMobile()" :icon="navOpened ? 'window-close' : 'bars'" fixed-width @click="toggleNav" />

      <RouterLink :to="{ name: user ? 'home' : 'welcome' }" class="logo">
        <img src="/img/logo.png" alt="WebDevHub Logo">
      </RouterLink>

      <RouterLink v-if="isMobile() && !user" :to="{ name: 'login' }" active-class="active">
        <Fa icon="sign-out-alt" fixed-width />
      </RouterLink>

      <a v-if="isMobile() && user" href="#" @click.prevent="logout">
        <Fa icon="sign-out-alt" fixed-width />
      </a>

      <nav v-if="user">
        <WSidebarMobile v-if="isMobile()" />

        <ul v-if="!isMobile()">
          <li>
            <RouterLink :to="{ name: 'settings.profile' }">
              <Fa icon="cog" fixed-width />
              {{ $t('settings') }}
            </RouterLink>
          </li>
          <li>
            <a href="#" @click.prevent="logout">
              <Fa icon="sign-out-alt" fixed-width />
              {{ $t('logout') }}
            </a>
          </li>
        </ul>

        <LocaleDropdown v-if="isMobile()" position="top" />
      </nav>

      <nav v-else>
        <ul>
          <li>
            <RouterLink :to="{ name: 'login' }" active-class="active">
              {{ $t('login') }}
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'register' }" active-class="active">
              {{ $t('register') }}
            </RouterLink>
          </li>
        </ul>
        <LocaleDropdown position="top" />
      </nav>
    </div>
  </header>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import WSidebarMobile from './WSidebarMobile'

export default {
  components: {
    LocaleDropdown,
    WSidebarMobile
  },
  data: () => ({
    iconClass: 'bars'
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      userPhoto: 'auth/userPhoto',
      navOpened: 'global/navOpened'
    })
  },

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    isMobile () {
      return document.documentElement.clientWidth <= 768
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
