<template>
  <div class="home">
    <h2 v-show="items.length > 0" >{{ $t('last_publications') }}</h2>
    <div class="content-wrapper">
      <content-item
        v-for="(item, key) in items"
        :key="key"
        :src="item.image_src"
        :link="getVideoLink(item)"
        :title="item.title"
        :author="item.channel.title"
        :date="item.published_at"
        :lang="item.lang"
        :type="type"/>
    </div>
    <infinite-loading :distance="0" spinner="spiral" @infinite="infiniteHandler">
      <div slot="no-more"/>
    </infinite-loading>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ContentItem from '../../components/ContentItem'
import InfiniteLoading from 'vue-infinite-loading'

export default {
  middleware: 'auth',
  layout: 'inner',
  name: 'VideoList',

  components: {
    ContentItem,
    InfiniteLoading
  },

  metaInfo () {
    return { title: this.$t('videos') }
  },

  data: () => ({
    type: 'video',
    page: 0,
    countItems: 0,
    infinityState: null
  }),

  computed: mapGetters({
    items: 'videos/paginate'
  }),

  watch: {
    items (newItems) {
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
    this.$store.dispatch('videos/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('videos/fetchPaginateVideos', this.page + 1)
    },
    getVideoLink (video) {
      return {channel: video.channel.slug, slug: video.slug}
    }
  }
}
</script>

<style lang="scss">
  .content-wrapper {
    > .content-item > .img-wrapper {
      background-size: 100%!important;
      background-repeat: no-repeat;
      background-color: #000;
    }
  }
</style>

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
