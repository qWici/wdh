<template>
  <div class="home">
    <h2 class="live">{{ $t('live_now') }}</h2>
    <div class="content-wrapper">
      <content-item
        v-for="(item, key) in live"
        :key="key"
        :src="getTwitchThumbnail(item.twitch)"
        :link="item.twitch"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :lang="item.language"
        :online="item.online"
        :type="type"/>
      <infinite-loading :distance="0" spinner="spiral" @infinite="infiniteHandler">
        <div slot="no-more"/>
      </infinite-loading>
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
      this.$store.dispatch('streams/fetchOnlineStreams', this.page + 1)
    },
    getTwitchThumbnail (twitchNickname) {
      return `https://static-cdn.jtvnw.net/previews-ttv/live_user_${twitchNickname}-600x340.jpg`
    }
  }
}
</script>

<style scoped lang="scss">
  .home {
    margin-top: 20px;
    padding-right: 10px;
    padding-bottom: 20px;
    overflow-y: scroll;
    height: calc(100vh - 100px);
    &::-webkit-scrollbar {
      width: 10px;
    }
    &::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px rgba(0,0,0,0.3);
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb {
      background: #0e1430;
      border-radius: 5px;
    }
    &::-webkit-scrollbar-thumb:hover {
      background: #0e1430;
    }
    h2 {
      color: #FFF;
      margin-top: 20px;
      display: inline-block;
      position: relative;
      padding-right: 20px;
      margin-bottom: 25px;
      &:first-child {
        margin-top: 0;
      }
      &:after {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
      }
      &.live:after {
        background-color: #D92B4C;
      }
      &.offline:after {
        background-color: #858585;
      }
    }
  }
  .content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
  }
</style>
