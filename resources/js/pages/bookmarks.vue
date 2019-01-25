<template>
  <div class="home">
    <h2 class="live">
      {{ $t('bookmarks') }}
    </h2>
    <div class="empty-bookmarks" v-if="bookmarks.length === 0">
      <img src="/img/sad_box.svg" alt="">
      <h2>{{ $t('error_alert_title') }}</h2>
      <h3>{{ $t('empty_bookmarks') }}</h3>
    </div>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in bookmarks"
        :key="key"
        :src="getItemImage(item)"
        :link="getItemLink(item)"
        :title="item.title"
        :author="getItemAuthor(item)"
        :date="getItemDate(item)"
        :type="item.type"
        :online="item.online ? item.online : false"
      />
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <span slot="no-results"></span>
        <span slot="no-more"></span>
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  middleware: 'auth',
  layout: 'inner',

  components: {
    ContentItem,
    InfiniteLoading
  },

  data: () => ({
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  watch: {
    bookmarks (newItems) {
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

  metaInfo () {
    return { title: this.$t('bookmarks') }
  },

  computed: {
    ...mapGetters({
      bookmarks: 'global/bookmarks'
    })
  },

  destroyed () {
    this.$store.dispatch('global/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('global/getUserBookmarks', this.page)
    },
    getItemLink (item) {
      switch (item.type) {
        case 'article':
          return { author: item.author.slug, slug: item.slug }
        case 'video':
          return { channel: item.channel.slug, slug: item.slug }
        case 'podcast':
          return { show: item.show.slug, slug: item.slug }
        default:
          return item.twitch
      }
    },
    getItemImage (item) {
      switch (item.type) {
        case 'stream':
          const nickname = item.twitch
          return `https://static-cdn.jtvnw.net/previews-ttv/live_user_${nickname}-600x340.jpg`
        case 'podcast':
          return item.show.image_url
        default:
          return item.image_src
      }
    },
    getItemAuthor (item) {
      switch (item.type) {
        case 'article':
          return item.author.name
        case 'podcast':
          return item.show.title
        case 'stream':
          return item.name
        default:
          return item.channel.title
      }
    },
    getItemDate (item) {
      if (item.type === 'podcast' || item.type === 'video') {
        return item.published_at
      }

      if (item.type === 'stream') {
        return item.updated_at
      }

      return item.date
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/elements/home";
@import "../../sass/vars";

.empty-bookmarks {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 100%;
  text-align: center;
  & img {
    max-width: 250px;
    margin-bottom: 50px;
  }
  h3 {
    color: $pink;
  }
}
@media #{$mobile} {
  .empty-bookmarks {
    & img {
      max-width: 150px;
    }
    h3 {
      font-size: 20px;
    }
  }
}
</style>
