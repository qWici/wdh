<template>
  <div class="home">
    <h2 class="live">
      {{ $t('bookmarks') }}
    </h2>
    <div class="empty-bookmarks" v-if="user.bookmarks.length === 0">
      <img src="/img/sad_box.svg" alt="">
      <h2>{{ $t('error_alert_title') }}</h2>
      <h3>{{ $t('empty_bookmarks') }}</h3>
    </div>
    <div class="content-wrapper" v-if="user && user.bookmarks.length > 0">
      <ContentItem
        v-for="(item, key) in user.bookmarks"
        :key="key"
        :src="getItemImage(item)"
        :link="getItemLink(item)"
        :title="item.title"
        :author="getItemAuthor(item)"
        :date="getItemDate(item)"
        :type="item.type"
        :online="item.online ? item.online : false"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../components/ContentItem'

export default {
  middleware: 'auth',
  layout: 'inner',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.$t('bookmarks') }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user'
    })
  },

  created () {
    this.$store.dispatch('auth/fetchUser')
  },

  methods: {
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
