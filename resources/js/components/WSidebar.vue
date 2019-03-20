<template>
  <aside class="sidebar">
    <div class="main">
      <div class="user">
        <img :src="userPhoto" :alt="user === null ? 'Guest' : user.nickname" class="user__img">
        <div>
          <span class="user__name">
            {{ user === null ? 'Guest' : user.nickname }}
          </span>
          <router-link :to="{ name: 'bookmarks' }" v-if="user" class="user__bookmarks" active-class="active">
            {{ $t('bookmarks') }}
          </router-link>
        </div>
      </div>
      <nav class="content-nav">
        <ul>
          <li>
            <router-link :to="{ name: 'home' }" class="content-nav__category" active-class="active" exact>
              <span class="content-nav__category__icon gradient-green">
                <fa :icon="['fas', 'home']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('home') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'article' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-pink">
                <fa :icon="['far', 'newspaper']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('articles') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'stream' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-purple-to-pink">
                <fa :icon="'tv'" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('streams') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'video' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-blue">
                <fa :icon="['fab', 'youtube']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('videos') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'podcast' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-crimson">
                <fa :icon="['fas', 'microphone']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('podcasts') }}
              </span>
            </router-link>
          </li>
          <li class="patron">
            <a href="https://www.patreon.com/bePatron?u=16249136" target="_blank" rel="noreferrer">
              <img src="https://c5.patreon.com/external/logo/become_a_patron_button@2x.png" alt="Become a Patron!">
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <footer v-if="showLocalesOnTablets()">
      <div class="lang">
        <locale-dropdown />
      </div>
    </footer>
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },
  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  }),
  methods: {
    showLocalesOnTablets () {
      return document.documentElement.clientWidth > 768
    }
  }
}
</script>
