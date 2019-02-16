<template>
  <div class="home">
    <h2 v-show="latest.length > 0">
      {{ $t('latest_updates') }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in latest"
        :key="key"
        :src="getItemImage(item)"
        :link="getItemLink(item)"
        :title="item.title"
        :author="getItemAuthor(item)"
        :date="getItemDate(item)"
        :type="getItemType(item)"
        :online="item.online ? item.online : false"
        :lang="getItemLang(item)"
      />
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more" />
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',

  components: {
    ContentItem,
    InfiniteLoading
  },

  metaInfo () {
    return {
      title: ('Aggregator of web development content | ' + this.$t('home')),
      meta: [
        { name: 'description', content: 'It is an aggregator of articles, videos, podcasts, and streams about web development' },
        { property: 'og:title', content: ('Aggregator of web development content | ' + this.$t('home')) },
        { property: 'og:site_name', content: 'WebDevHub' },
        { property: 'og:type', content: 'website' },
        { property: 'og:url', content: window.location.href },
        { property: 'og:image', content: '/img/mockup.png' },
        { property: 'og:description', content: 'It is an aggregator of articles, videos, podcasts, and streams about web development' },
        { name: 'twitter:card', content: 'summary' },
        { name: 'twitter:site', content: window.location.href },
        { name: 'twitter:title', content: ('Aggregator of web development content | ' + this.$t('home')) },
        { name: 'twitter:description', content: 'It is an aggregator of articles, videos, podcasts, and streams about web development' },
        { name: 'twitter:image:src', content: '/img/mockup.png' },
        { itemprop: 'name', content: ('Aggregator of web development content | ' + this.$t('home')) },
        { itemprop: 'description', content: 'It is an aggregator of articles, videos, podcasts, and streams about web development' },
        { itemprop: 'image', content: '/img/mockup.png' }
      ]
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      latest: 'global/latest'
    })
  },

  data: () => ({
    page: 1,
    countItems: 0,
    infinityState: null
  }),

  watch: {
    latest (newItems) {
      if (this.infinityState === null) { return false }

      this.page += 1
      if (this.countItems === newItems.length) {
        this.infinityState.complete()
      } else {
        this.countItems = newItems.length
        this.infinityState.loaded()
      }
    }
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('global/getLatestItems', this.page)
    },
    getItemLink (item) {
      let type = this.getItemType(item)
      switch (type) {
        case 'article':
          return { author: item.author.slug, slug: item.slug }
        case 'video':
          return { channel: item.channel.slug, slug: item.slug }
        default:
          return { show: item.show.slug, slug: item.slug }
      }
    },
    getItemImage (item) {
      let type = this.getItemType(item)
      if (type === 'podcast') {
        return item.show.image_url
      }

      return item.image_src
    },
    getItemAuthor (item) {
      let type = this.getItemType(item)
      switch (type) {
        case 'article':
          return item.author.name
        case 'podcast':
          return item.show.title
        default:
          return item.channel.title
      }
    },
    getItemDate (item) {
      let type = this.getItemType(item)
      if (type === 'podcast' || type === 'video') {
        return item.published_at
      }

      return item.date
    },
    getItemLang (item) {
      let type = this.getItemType(item)
      switch (type) {
        case 'video':
          return item.channel.country.toLowerCase()
        case 'article':
          return item.author.language
        case 'podcast':
          return item.show.language
        default:
          return item.language
      }
    },
    getItemType (item) {
      const types = {
        article: 'author_id',
        podcast: 'podcast_show_id',
        video: 'channel_id'
      }
      for (let type in types) {
        if (item.hasOwnProperty(types[type])) {
          return type
        }
      }
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/home";
</style>
