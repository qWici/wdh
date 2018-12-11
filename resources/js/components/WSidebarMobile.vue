<template>
  <aside class="sidebar mobile">
    <div class="main">
      <div v-if="user" class="user">
        <img :alt="user.nickname" :src="userPhoto" class="user__img">
        <div>
          <span class="user__name">
            {{ user.nickname }}
          </span>
          <router-link :to="{ name: 'bookmarks' }" class="user__bookmarks" active-class="active">
            {{ $t('bookmarks') }}
          </router-link>
        </div>
      </div>
      <nav class="content-nav">
        <ul>
          <li>
            <router-link :to="{ name: 'article' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-pink">
                <fa :icon="['far', 'newspaper']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('articles') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'stream' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-purple-to-pink">
                <fa :icon="'tv'" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('streams') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'video' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-blue">
                <fa :icon="['fab', 'youtube']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('videos') }}
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'podcast' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-crimson">
                <fa :icon="['fas', 'microphone']" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('podcasts') }}
              </span>
            </router-link>
          </li>
          <hr>
          <li>
            <router-link :to="{ name: 'settings.profile' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-clear">
                <fa icon="cog" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('settings') }}
              </span>
            </router-link>
          </li>
          <li>
            <a href="#" @click.prevent="logout" class="content-nav__category">
              <span class="content-nav__category__icon gradient-clear">
                <fa icon="sign-out-alt" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('logout') }}
              </span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'WSidebarMobile',

  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'welcome' })
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";

@media #{$mobile} {
    aside.sidebar {
        &.mobile {
            display: flex;
            background-image: none;
            background: transparent;
            box-shadow: none;
            .content-nav ul {
                flex-direction: column;
                width: 100%;
                hr {
                    background-color: #1e1f3f;
                }
                li {
                    margin-right: 0;
                }
            }
        }
        .user {
            display: flex;
        }
    }
}
</style>
