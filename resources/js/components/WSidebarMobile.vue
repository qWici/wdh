<template>
  <aside class="sidebar mobile">
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
          <w-sidebar-nav-item v-for="(link, key) in links" :key="key" :item="prepareLink(link)" />
          <hr>
          <li>
            <a href="https://www.patreon.com/bePatron?u=16249136" class="patron" target="_blank">
              <img src="https://c5.patreon.com/external/logo/become_a_patron_button@2x.png" alt="Become a Patron!">
            </a>
          </li>
          <hr v-if="user !== null">
          <li v-if="user !== null">
            <router-link :to="{ name: 'settings.profile' }" active-class="active" class="content-nav__category">
              <span class="content-nav__category__icon gradient-clear">
                <fa icon="cog" fixed-width />
              </span>
              <span class="content-nav__category__title">
                {{ $t('settings') }}
              </span>
            </router-link>
          </li>
          <li v-if="user !== null">
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
import WSidebarNavItem from './WSidebarNavItem'
import WSidebarNavItemType from '../types/ui/WSidebarNavItemType'

export default {
  name: 'WSidebarMobile',

 components: {
  WSidebarNavItem
 },

  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  }),

  data: () => ({
    links: [
      {
        text: 'home',
        link: 'home',
        faIcon: ['fas', 'home'],
        iconGradientClass: 'gradient-green'
      },
      {
        text: 'articles.articles',
        link: 'article',
        faIcon: ['far', 'newspaper'],
        iconGradientClass: 'gradient-pink',
        children: [
          { text: 'articles.all', link: 'article' },
          { text: 'articles.authors', link: 'authors' },
          { text: 'articles.suggest', link: 'suggest.type', params: { type: 'author' } }
        ]
      },
      {
        text: 'streams.streams',
        link: 'stream',
        faIcon: 'tv',
        iconGradientClass: 'gradient-purple-to-pink',
        children: [
          { text: 'streams.live', link: 'stream' },
          { text: 'streams.suggest', link: 'suggest.type', params: { type: 'stream' } }
        ]
      },
      {
        text: 'videos.videos',
        link: 'video',
        faIcon: ['fab', 'youtube'],
        iconGradientClass: 'gradient-blue',
        children: [
          { text: 'videos.all', link: 'video' },
          { text: 'videos.channels', link: 'video' }, // @TODO: channels
          { text: 'videos.suggest', link: 'suggest.type', params: { type: 'channel' } }
        ]
      },
      {
        text: 'podcasts.podcasts',
        link: 'podcast',
        faIcon: ['fas', 'microphone'],
        iconGradientClass: 'gradient-crimson',
        children: [
          { text: 'podcasts.all', link: 'podcast' },
          { text: 'podcasts.shows', link: 'podcast' }, // @TODO: shows
          { text: 'podcasts.suggest', link: 'suggest.type', params: { type: 'show' } }
        ]
      }
    ]
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'home' })
    },
    prepareLink (item) {
      return new WSidebarNavItemType(item)
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/vars";

@media #{$w991} {
    .patron img {
      height: 35px;
      margin: 0 auto;
      display: block;
    }
    aside.sidebar {
        &.mobile {
            width: 100%;
            display: flex;
            background-image: none;
            background: transparent;
            box-shadow: none;
            position: relative;
            height: 100%;
            top: 0;
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
