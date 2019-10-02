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
          <w-sidebar-nav-item v-for="(link, key) in links" :key="key" :item="prepareLink(link)" />
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
import WSidebarNavItem from './WSidebarNavItem'
import WSidebarNavItemType from '../types/ui/WSidebarNavItemType'

export default {
  components: {
    LocaleDropdown,
    WSidebarNavItem
  },

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

  computed: mapGetters({
    user: 'auth/user',
    userPhoto: 'auth/userPhoto'
  }),

  methods: {
    showLocalesOnTablets () {
      return document.documentElement.clientWidth > 768
    },
    prepareLink (item) {
      return new WSidebarNavItemType(item)
    }
  }
}
</script>
