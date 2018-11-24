<template>
  <div class="home">
    <h2 class="live">
      {{ $t('live_now') }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in live"
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
      <InfiniteLoading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more" />
      </InfiniteLoading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'StreamList',

  components: {
    ContentItem,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('streams') }
  },

  data: () => ({
    type: 'stream',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: mapGetters({
    live: 'streams/streamsOnline'
  }),

  watch: {
    live (newItems) {
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

  destroyed () {
    this.$store.dispatch('streams/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('streams/fetchOnlineStreams', this.page + 1).then(() => {
        let breadcrumbs = [{ title: this.$t('streams'), route: { name: 'stream' } }]

        this.$store.dispatch('breadcrumbs/setBreadcrumbs', breadcrumbs)
      })
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
