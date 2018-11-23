<template>
  <aside class="sidebar">
    <div class="main">
      <div v-if="user" class="user">
        <img :src="userPhoto" :alt="user.nickname" class="user__img">
        <div>
          <span class="user__name">
            {{ user.nickname }}
          </span>
          <span v-show="user.specialization" class="user__specs">
            {{ user.specialization }}
          </span>
        </div>
      </div>
      <nav class="content-nav">
        <ul>
          <li>
            <RouterLink :to="{ name: 'article' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-pink">
                <Fa :icon="['far', 'newspaper']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('articles') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'stream' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-purple-to-pink">
                <Fa :icon="'tv'" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('streams') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'video' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-blue">
                <Fa :icon="['fab', 'youtube']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('videos') }}
              </span>
            </RouterLink>
          </li>
          <li>
            <RouterLink :to="{ name: 'podcast' }" class="content-nav__category" active-class="active">
              <span class="content-nav__category__icon gradient-crimson">
                <Fa :icon="['fas', 'microphone']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('podcasts') }}
              </span>
            </RouterLink>
          </li>
        </ul>
      </nav>
    </div>
    <footer v-if="showLocalesOnTablets()">
      <div class="lang">
        <LocaleDropdown />
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
