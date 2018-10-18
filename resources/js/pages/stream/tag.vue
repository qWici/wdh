<template>
  <div class="home">
    <h2 class="live">{{ this.$route.params.id }}</h2>
    <div v-show="streams.length > 0" class="content-wrapper">
      <content-item
        v-for="(item, key) in streams"
        :key="key"
        :src="getThumbnail(item)"
        :link="item.twitch"
        :title="item.title"
        :author="item.name"
        :date="item.date"
        :type="type"
        :online="item.online"/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'StreamTag',

  components: {
    ContentItem
  },

  metaInfo () {
    return { title: this.$route.params.id }
  },

  data: () => ({
    type: 'stream'
  }),

  computed: mapGetters({
    streams: 'streams/byTag'
  }),

  created () {
    this.$store.dispatch('streams/fetchStreamsByTag', this.$route.params.id)
  },

  methods: {
    getThumbnail (stream) {
      return stream.online
        ? `https://static-cdn.jtvnw.net/previews-ttv/live_user_${stream.name}-600x340.jpg`
        : stream.logo
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
    }
  }
  .content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
  }
</style>
