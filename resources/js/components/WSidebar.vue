<template>
  <aside class="sidebar">
    <div class="main">
      <div v-if="user" class="user">
        <img :src="userPhoto" :alt="user.nickname" class="user__img">
        <div>
          <span class="user__name">{{ user.nickname }}</span>
          <span v-show="user.specialization" class="user__specs">{{ user.specialization }}</span>
        </div>
      </div>
      <nav class="content-nav">
        <ul>
          <li>
            <router-link :to="{ name: 'article' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-pink">
                <fa :icon="['far', 'newspaper']" fixed-width />
              </span>
              <span class="content-nav__category__title">{{ $t('articles') }}</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'stream' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-purple-to-pink">
                <fa :icon="'tv'" fixed-width />
              </span>
              <span class="content-nav__category__title">{{ $t('streams') }}</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'video' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-blue">
                <fa :icon="['fab', 'youtube']" fixed-width />
              </span>
              <span class="content-nav__category__title">{{ $t('videos') }}</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'podcast' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-crimson">
                <fa :icon="['fas', 'microphone']" fixed-width />
              </span>
              <span class="content-nav__category__title">{{ $t('podcasts') }}</span>
            </router-link>
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
