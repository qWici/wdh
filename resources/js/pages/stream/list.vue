<template>
  <div class="home">
    <h2 class="live">
      {{ countItems > 0 ? $t('live_now') : 'All streamers are offline now' }}
    </h2>

    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in streams"
        :key="key"
        :src="getTwitchThumbnail(item.twitch)"
        :link="item.twitch"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :lang="item.language"
        :online="item.online"
        :type="type"
      />
      <suggest-button type="stream" />
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more" />
        <div slot="no-results" />
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import SuggestButton from '../../components/SuggestButton'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  layout: 'inner',
  name: 'StreamList',

  components: {
    ContentItem,
    SuggestButton,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('streams.streams') }
  },

  data: () => ({
    type: 'stream',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: {
    streams () {
      return this.live.length > 0 ? this.live : this.lastOnline
    },
    ...mapGetters({
      live: 'streams/streamsOnline',
      lastOnline: 'streams/lastOnline'
    })
  },

  watch: {
    live (newItems) {
      if (this.infinityState === null) {
        return false
      }

      if (this.countItems === newItems.length) {
        this.infinityState.complete()
      } else {
        this.countItems = newItems.length
        this.infinityState.loaded()
      }
    }
  },

  destroyed () {
    this.$store.dispatch('streams/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('streams/fetchOnlineStreams', this.page + 1)
    },
    getTwitchThumbnail (twitchNickname) {
      return `https://static-cdn.jtvnw.net/previews-ttv/live_user_${twitchNickname}-600x340.jpg`
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../../sass/elements/home";
</style>
