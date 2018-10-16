<template>
  <div class="home">
    <h2 v-show="live.length > 0" class="live">Live now</h2>
    <div v-show="live.length > 0" class="content-wrapper">
      <content-item
        v-for="(item, key) in live"
        :key="key"
        :src="getTwitchThumbnail(item.twitch)"
        :link="getTwitchStreamLink(item.twitch)"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :type="type"/>
    </div>
    <h2 v-show="lastOnline.length > 0" class="offline">Last online</h2>
    <div v-show="lastOnline.length > 0" class="content-wrapper">
      <content-item
        v-for="(item, key) in lastOnline"
        :key="key"
        :src="getTwitchThumbnail(item.twitch)"
        :link="getTwitchStreamLink(item.twitch)"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :type="type"/>
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
    return { title: this.$t('streams') }
  },

  // @TODO: Get data from server
  data: () => ({
    type: 'stream'
  }),

  computed: mapGetters({
    live: 'streams/streamsOnline',
    lastOnline: 'streams/lastOnline'
  }),

  created () {
    this.$store.dispatch('streams/fetchOnlineStreams')
    this.$store.dispatch('streams/fetchLastOnline')
  },

  methods: {
    getTwitchThumbnail (twitchNickname) {
      return `https://static-cdn.jtvnw.net/previews-ttv/live_user_${twitchNickname}-600x340.jpg`
    },
    getTwitchStreamLink (twitchNickname) {
      return `https://www.twitch.tv/${twitchNickname}`
    },
    moreThen (items, value) {
      return items.length > value;
    },
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
