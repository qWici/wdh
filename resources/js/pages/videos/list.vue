<template>
  <div class="home">
    <h2 v-show="items.length > 0">
      {{ $t('last_publications') }}
    </h2>
    <div class="content-wrapper">
      <ContentItem
        v-for="(item, key) in items"
        :key="key"
        :src="item.image_src"
        :link="getVideoLink(item)"
        :title="item.title"
        :author="item.channel.title"
        :date="item.published_at"
        :lang="item.lang"
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
    this.$store.dispatch('videos/clearState')
  },

  methods: {
    infiniteHandler ($state) {
      this.infinityState = $state
      this.$store.dispatch('videos/fetchPaginateVideos', this.page + 1)
    },
    getVideoLink (video) {
      return { channel: video.channel.slug, slug: video.slug }
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
  @import "../../../sass/elements/home";
</style>
